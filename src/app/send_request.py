import requests
import sys

def send_request_with_image(image_path):
    url = "http://127.0.0.1:5000/test"
    
    try:
        # Open the image file in binary mode
        with open(image_path, 'rb') as img_file:
            files = {'file': img_file}  # Key should match the server's expected parameter
            
            # Sending a POST request with the image
            response = requests.post(url, files=files)
            
            # Check if the request was successful
            if response.status_code == 200:
                print("Response from server:", response.json())
            else:
                print(f"Failed to get response. Status code: {response.status_code}")
    except requests.exceptions.RequestException as e:
        print("An error occurred:", e)
    except FileNotFoundError:
        print(f"File not found: {image_path}")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python script_name.py <path_to_image>")
    else:
        image_path = sys.argv[1]
        send_request_with_image(image_path)
