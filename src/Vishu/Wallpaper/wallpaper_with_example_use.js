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

