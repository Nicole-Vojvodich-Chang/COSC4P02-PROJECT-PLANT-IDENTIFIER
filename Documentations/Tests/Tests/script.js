function identifyPlant(imageUrl) {
    document.getElementById("loadingIndicator").style.display = "block";

    fetch(imageUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        var formData = new FormData();
        formData.append("images", blob);

        fetch("https://plant.id/api/v3/identification", {
            method: 'POST',
            headers: {
                "Api-Key": "AmMB3jE61y72gumlOmAxOmBTo1lJ3rsOEFAAuX72h9tQMKKmU3"
            },
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            var accessToken = result.access_token;
            var name = result.result.classification.suggestions[0].name;;
            var probability = result.result.classification.suggestions[0].probability; // Extract the probability from the API response
            var plantInfo = `${name} (Match: ${probability*100}%)`; // Combine name and probability
            document.getElementById("plantInfo").innerText = plantInfo; // Display the plant info on the webpage
            document.getElementById("plantInfo").style.display = "block"; // Show the plant info div
            document.getElementById("loadingIndicator").style.display = "none";
            fetchPlantCommonNames(accessToken);
        })
        .catch(error => {
            console.error('Error identifying plant:', error);
            document.getElementById("identificationMessage").innerText = 'Error identifying plant: ' + error.message;
            document.getElementById("loadingIndicator").style.display = "none";
            document.getElementById("retryButton").style.display = "block"; // Display the retry button
        });
    })
    .catch(error => {
        console.error('Error fetching image:', error);
        document.getElementById("identificationMessage").innerText = 'Error fetching image: ' + error.message;
        document.getElementById("loadingIndicator").style.display = "none";
        document.getElementById("retryButton").style.display = "block"; // Display the retry button
    });
}

function fetchPlantCommonNames(accessToken) {
    var myHeaders = new Headers();
    myHeaders.append("Api-Key", "Ae3UKCa0OzsNYqYHkpnvSxy4rF1r4pfrsOaLtR7ZpLWbbyWPiC");

    var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    fetch(`https://plant.id/api/v3/identification/${accessToken}?details=common_names&language=en`, requestOptions)
    .then(response => response.json())
    .then(result => {
        // Display plant common names on the webpage
        var commonNames = result.result.classification.suggestions[0].details.common_names;
        var commonName = commonNames[0];
        document.getElementById("plantCommonName").innerHTML = commonName;
        document.getElementById("loadingIndicator").style.display = "none";
    })
    .catch(error => {
        console.error('Error fetching plant common names:', error);
        document.getElementById("identificationMessage").innerText = 'Error fetching plant common name: ' + error.message;
        document.getElementById("loadingIndicator").style.display = "none";
        document.getElementById("retryButton").style.display = "block"; // Display the retry button
    });
}

document.getElementById("uploadInput").addEventListener("change", function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        var imageUrl = event.target.result;
        document.getElementById("imagePreview").innerHTML = '<img src="' + imageUrl + '" alt="Uploaded Image">';
        identifyPlant(imageUrl); // Trigger plant identification when image is uploaded
    }

    reader.readAsDataURL(file);
});

// Camera button functionality 
document.getElementById("cameraButton").addEventListener("click", function() {
    document.getElementById("imageUpload").style.display = "none";
    document.getElementById("videoContainer").style.display = "block";

    navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
        var video = document.getElementById('cameraFeed');
        video.srcObject = stream;
        video.play();
    })
    .catch(function(error) {
        console.error('Error accessing camera:', error);
        document.getElementById("identificationMessage").innerText = 'Error accessing camera: ' + error.message;
        document.getElementById("retryButton").style.display = "block"; // Display the retry button
    });
});

document.getElementById("captureButton").addEventListener("click", function() {
    var video = document.getElementById('cameraFeed');
    var canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    var context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Stop video stream
    video.pause();
    video.srcObject.getTracks().forEach(track => track.stop());

    // Convert captured image to data URL
    var imageUrl = canvas.toDataURL('image/jpeg');

    // Display the captured image
    //document.getElementById("imagePreview").innerHTML = '<img src="' + imageUrl + '" alt="Captured Image">';

    // Identify plant using captured image
    identifyPlant(imageUrl);
});

document.addEventListener("DOMContentLoaded", function() {
document.getElementById("retryButton").addEventListener("click", function() {
console.log("Retry button clicked"); // Add this to check if the button is responsive
document.getElementById("imageUpload").style.display = "block";
document.getElementById("videoContainer").style.display = "none";
document.getElementById("imagePreview").innerHTML = "";
document.getElementById("plantInfo").style.display = "none";
document.getElementById("plantCommonName").innerHTML = "";
document.getElementById("identificationMessage").innerText = "";
document.getElementById("retryButton").style.display = "none";
document.getElementById("uploadInput").value = ""; // Reset the input field
});
});
