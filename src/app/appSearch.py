# V9 - Final
from flask import Flask, request, jsonify, send_from_directory
import pymysql
import tensorflow as tf
import numpy as np
from tensorflow.keras import layers, Model
from tensorflow.keras.preprocessing import image
from werkzeug.utils import secure_filename
import os
import logging

# Configure logging
logging.basicConfig(level=logging.DEBUG, filename='app.log', filemode='a',
                    format='%(asctime)s - %(levelname)s - %(message)s')

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = 'D:/laragon/www/fmp/uploads'

# Ensure the UPLOAD_FOLDER exists
os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

# Define the DistanceLayer


class DistanceLayer(layers.Layer):
    def __init__(self, **kwargs):
        super().__init__(**kwargs)

    def call(self, anchor, positive, negative):
        ap_distance = tf.reduce_sum(tf.square(anchor - positive), -1)
        an_distance = tf.reduce_sum(tf.square(anchor - negative), -1)
        return (ap_distance, an_distance)

# Define the Encoder


def get_encoder(input_shape=(128, 128, 3)):
    encoder_input = layers.Input(shape=input_shape, name="Encoder_Input")
    x = layers.Conv2D(32, (3, 3), activation='relu',
                      padding='same')(encoder_input)
    x = layers.MaxPooling2D((2, 2))(x)
    x = layers.Conv2D(64, (3, 3), activation='relu', padding='same')(x)
    x = layers.MaxPooling2D((2, 2))(x)
    x = layers.Flatten()(x)
    x = layers.Dense(128, activation='relu')(x)
    encoder_output = layers.Dense(64, activation='relu')(x)
    return Model(encoder_input, encoder_output, name="Encoder")

# Define the Siamese Network


def get_siamese_network(input_shape=(128, 128, 3)):
    encoder = get_encoder(input_shape)
    anchor_input = layers.Input(input_shape, name="Anchor_Input")
    positive_input = layers.Input(input_shape, name="Positive_Input")
    negative_input = layers.Input(input_shape, name="Negative_Input")

    encoded_a = encoder(anchor_input)
    encoded_p = encoder(positive_input)
    encoded_n = encoder(negative_input)

    distances = DistanceLayer()(encoded_a, encoded_p, encoded_n)

    siamese_network = Model(
        inputs=[anchor_input, positive_input, negative_input],
        outputs=distances,
        name="Siamese_Network"
    )
    return siamese_network


# Load the model
siamese_network = get_siamese_network()
siamese_network.load_weights(
    'src/app/siamese_92.weights.h5', by_name=True, skip_mismatch=True)

# Database configuration
db_config = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "children_db"
}


def get_all_images():
    try:
        conn = pymysql.connect(**db_config)
        cursor = conn.cursor()
        sql = "SELECT photo FROM report"
        cursor.execute(sql)
        rows = cursor.fetchall()
        cursor.close()
        conn.close()
        return [os.path.join(app.config['UPLOAD_FOLDER'], row[0]) for row in rows]
    except Exception as e:
        logging.error(f"Database Error: {e}")
        return []


def save_to_db(input_data, output_data):
    try:
        conn = pymysql.connect(**db_config)
        cursor = conn.cursor()
        sql = "INSERT INTO predictions (input_data, output_data) VALUES (%s, %s)"
        cursor.execute(sql, (str(input_data), str(output_data)))
        conn.commit()
        cursor.close()
        conn.close()
        return True
    except Exception as e:
        logging.error(f"Database Error: {e}")
        return False


# Define the threshold
THRESHOLD = 0.5


@app.route('/test', methods=['POST', 'GET'])
def search():
    try:
        # Ensure the image file is present in the request
        if 'file' not in request.files:
            logging.error("No image file part in the request")
            return jsonify({"error": "No image file part in the request"}), 400

        # Receive the image
        img_file = request.files['file']
        filename = secure_filename(img_file.filename)
        temp_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        img_file.save(temp_path)  # Save to temporary path

        # Log the received file details
        logging.debug(f"Received file: {filename}, saved to: {temp_path}")

        # Load and preprocess the image
        img = image.load_img(temp_path, target_size=(128, 128))
        img_array = image.img_to_array(img)
        # Convert shape to (1, 128, 128, 3)
        img_array = np.expand_dims(img_array, axis=0)
        img_array = img_array / 255.0  # Normalize the image

        # Log the preprocessed image details
        logging.debug(f"Preprocessed image array shape: {img_array.shape}")

        # Get embeddings for the uploaded image
        uploaded_embedding = siamese_network.get_layer(
            'Encoder').predict(img_array)

        # Get all images from the database
        all_images = get_all_images()
        logging.debug(f"Number of images in database: {len(all_images)}")

        best_match = None
        best_distance = float('inf')

        for img_path in all_images:
            # Check if the file exists
            if not os.path.exists(img_path):
                logging.error(f"File not found: {img_path}")
                continue

            logging.debug(f"Processing file: {img_path}")

            # Load and preprocess the database image
            db_img = image.load_img(img_path, target_size=(128, 128))
            db_img_array = image.img_to_array(db_img)
            # Convert shape to (1, 128, 128, 3)
            db_img_array = np.expand_dims(db_img_array, axis=0)
            db_img_array = db_img_array / 255.0  # Normalize the image

            # Get embeddings for the database image
            db_embedding = siamese_network.get_layer(
                'Encoder').predict(db_img_array)

            # Compute the Euclidean distance between the embeddings
            distance = np.linalg.norm(uploaded_embedding - db_embedding)
            logging.debug(
                f"Distance between uploaded image and {img_path}: {distance}")

            if distance < best_distance:
                best_distance = distance
                best_match = img_path

        if best_match and best_distance < THRESHOLD:
            response = {
                "found": "yes",
                "image": best_match,
                "sim": best_distance
            }
        else:
            response = {"found": "no"}

        # Save the result to the database
        save_to_db(str(img_array.tolist()), str(response))

        # Remove the temporary file
        os.remove(temp_path)

        return jsonify(response)

    except Exception as e:
        logging.error(f"Error during prediction: {e}")
        return jsonify({"error": str(e)}), 500

# Route to serve uploaded images


@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)


if __name__ == '__main__':
    app.run(debug=True)
