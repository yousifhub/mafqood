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

# Define the GAN Generator
def get_gan_generator(input_shape=(128, 128, 3)):
    generator_input = layers.Input(shape=input_shape, name="Generator_Input")
    x = layers.Conv2D(32, (3, 3), activation='relu', padding='same')(generator_input)
    x = layers.UpSampling2D((2, 2))(x)
    x = layers.Conv2D(64, (3, 3), activation='relu', padding='same')(x)
    x = layers.UpSampling2D((2, 2))(x)
    x = layers.Conv2D(128, (3, 3), activation='relu', padding='same')(x)
    x = layers.Conv2D(3, (3, 3), activation='sigmoid', padding='same')(x)
    return Model(generator_input, x, name="Generator")

# Load the GAN model
gan_generator = get_gan_generator()
gan_generator.load_weights('D:/laragon/www/fmp/model/gan_generator_weights.h5', by_name=True, skip_mismatch=True)

# Database configuration
db_config = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "children_db"
}

def save_to_db(input_data, output_data):
    try:
        conn = pymysql.connect(**db_config)
        cursor = conn.cursor()
        sql = "INSERT INTO generated_images (input_data, output_data) VALUES (%s, %s)"
        cursor.execute(sql, (str(input_data), str(output_data)))
        conn.commit()
        cursor.close()
        conn.close()
        return True
    except Exception as e:
        logging.error(f"Database Error: {e}")
        return False

@app.route('/generate', methods=['POST'])
def generate():
    try:
        # Ensure the image file is present in the request
        if 'input_data' not in request.files:
            logging.error("No image file part in the request")
            return jsonify({"error": "No image file part in the request"}), 400
        
        # Receive the image
        img_file = request.files['input_data']
        filename = secure_filename(img_file.filename)
        temp_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        img_file.save(temp_path)  # Save to temporary path

        # Log the received file details
        logging.debug(f"Received file: {filename}, saved to: {temp_path}")

        # Load and preprocess the image
        img = image.load_img(temp_path, target_size=(128, 128))
        img_array = image.img_to_array(img)
        img_array = np.expand_dims(img_array, axis=0)  # Convert shape to (1, 128, 128, 3)
        img_array = img_array / 255.0  # Normalize the image

        # Log the preprocessed image details
        logging.debug(f"Preprocessed image array shape: {img_array.shape}")

        # Generate new image using the GAN model
        generated_image = gan_generator.predict(img_array)
        generated_image = (generated_image * 255).astype(np.uint8)

        # Save the generated image
        generated_filename = f"generated_{filename}"
        generated_path = os.path.join(app.config['UPLOAD_FOLDER'], generated_filename)
        image.save_img(generated_path, generated_image[0])

        # Log the generated image details
        logging.debug(f"Generated image saved to: {generated_path}")

        # Save the result to the database
        if not save_to_db(str(img_array.tolist()), generated_filename):
            logging.error("Failed to save to database")

        # Remove the temporary file
        os.remove(temp_path)

        return jsonify({"generated_image": generated_filename})

    except Exception as e:
        logging.error(f"Error during generation: {e}")
        return jsonify({"error": str(e)}), 500

# Route to serve uploaded images
@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

if __name__ == '__main__':
    app.run(debug=True)
