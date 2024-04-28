//I have also added an example usage to aid in understanding the functionality
const fs = require('fs');
const path = require('path');

// Array to store fetched images
let imageArray = [];

// Function to fetch images and store them in the array
function fetchImages() {
    const folderPath = '/path/to/your/image/folder'; // Update this with your folder path
    const files = fs.readdirSync(folderPath);
    
    // Add images to the image array
    files.forEach(file => {
        const imagePath = path.join(folderPath, file);
        imageArray.push(imagePath);
    });

    // If no images were found in the folder, display achievement message
    if (imageArray.length === 0) {
        console.log("All achievements unlocked! Yay!");
    }
}

// Function to get and remove the first image from the array
function getImage() {
    if (imageArray.length === 0) {
        console.log("No more images left.");
        return null;
    }

    // Get the first image from the array
    const firstImage = imageArray.shift();
    return firstImage;
}

// Example usage
fetchImages(); // Fetch images and store them in the array

// Function to fetch and remove images
function fetchImage() {
    const image = getImage();
    if (image) {
        console.log("Fetched image:", image);
    } else {
        console.log("No more images left.");
    }
}

// Call fetchImage function 10 times to fetch images one by one
for (let i = 0; i < 10; i++) {
    fetchImage();
}


// Example callback function to handle the retrieved image
function handleImage(imageName) {
    // Create a new popup element
    const popup = document.createElement('div');
    popup.className = 'popup';
    
    // Set background image to the fetched image
    popup.style.backgroundImage = `url('${imageName}')`;
    
    // Append the popup to the body
    document.body.appendChild(popup);
    
    // After some time, remove the popup
    setTimeout(() => {
        popup.remove();
    }, 5000); // Adjust the timeout as needed (here it's set to 5 seconds)
}

// Example CSS for the popup
.popup {
    position: fixed;
    bottom: 20px; /* Adjust the distance from the bottom */
    left: 50%;
    transform: translateX(-50%);
    width: 200px; /* Adjust as needed */
    height: 200px; /* Adjust as needed */
    background-size: cover;
    background-position: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 9999;
}

