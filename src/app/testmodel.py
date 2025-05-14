import tensorflow as tf
import numpy as np
from tensorflow.keras import layers, Model
from tensorflow.keras.preprocessing import image
from pathlib import Path

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
    x = layers.Conv2D(32, (3, 3), activation='relu', padding='same')(encoder_input)
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
siamese_network.load_weights('D:/laragon/www/fmp/model/model_train/allgood.h5', by_name=True, skip_mismatch=True)

# Function to preprocess the image
def preprocess_image(image_path):
    img = image.load_img(image_path, target_size=(128, 128))
    img_array = image.img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0)  # Convert shape to (1, 128, 128, 3)
    img_array = img_array / 255.0  # Normalize the image
    return img_array

# Test the model with two images
def test_model(image_path1, image_path2):
    img_array1 = preprocess_image(image_path1)
    img_array2 = preprocess_image(image_path2)
    
    # Get embeddings for both images
    embedding1 = siamese_network.get_layer('Encoder').predict(img_array1)
    embedding2 = siamese_network.get_layer('Encoder').predict(img_array2)
    
    # Compute the Euclidean distance between the embeddings
    distance = np.linalg.norm(embedding1 - embedding2)
    
    print(f"Distance between images: {distance}")

if __name__ == "__main__":
    import argparse
    parser = argparse.ArgumentParser(description="Test the Siamese Network model")
    parser.add_argument("--path1", type=Path, help="Path to the first image file")
    parser.add_argument("--path2", type=Path, help="Path to the second image file")
    args = parser.parse_args()
    
    test_model(args.path1, args.path2)