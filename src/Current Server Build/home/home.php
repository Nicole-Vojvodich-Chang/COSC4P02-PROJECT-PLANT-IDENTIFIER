<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="sass/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.11.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@2.0.4"></script>
    <title>Plant Image Recognition</title>
</head>
<body>
    <main>
        <nav>
            <div class="logo">
                <embed src="Tree Hugger.png" alt="Logo" class="logo-image" style="margin-left: -10%;">
                <span>Tree<br>Hugger</span>
            </div>
            <a href="#" class="active">Home</a>
            <a href="#"> Category </a>
            <a href="/../Account/index.html"> User Account </a>
            <a href="#"> Snap History </a>
            <a href="environments.php" target="_parent">
              Environments</a>
            <a href="/../environments/settings.php"> Settings </a>
        </nav>
        <aside class="plant-gallery">
            <embed src="plant1.png" alt="Plant 1" class="plant-left">
            <embed src="plant2.png" alt="Plant 2" class="plant-right">
        </aside>
        <section class="newitementry">
            <form id="entryForm">
                <input id="myInput" type="text" name="myCountry" placeholder="search plants" size="40">
                <button id="search button" class="button" title="search new plants" aria-label="search for plants" tabindex="0">⌕</button>               
            </form>

            <section class="listcontainer">     
              <div class="listTitle"> 
                  <h1> Upload Your Image </h1>
              </div>
              <hr />
              <div id="listItems">
                  <div class="item">
                      <div class="container">
                          <div class="wrapper">
                             <div class="image">
                                <img src="" alt="">
                             </div>
                             <div class="content">
                                <div class="icon">
                                   <embed src="plant-icon.png" class="fas fa-cloud-upload-alt" height="80px" color="green"></i>
                                </div>
                                <div class="text">
                                   No file chosen, yet!
                                </div>
                             </div>
                             <div id="cancel-btn">
                                <i class="fas fa-times"></i>
                             </div>
                             <div class="file-name">
                                File name here
                             </div>
                          </div>
                          <button onclick="defaultBtnActive()" id="custom-btn">Choose a file</button>
                          <input id="default-btn" type="file" hidden>
                       </div>
                       <div class="loading-circle" id="loadingCircle"></div>
                       <div id="predictions"></div> <!-- Predictions will be displayed here --> 
                       <script>
                          const wrapper = document.querySelector(".wrapper");
                          const fileName = document.querySelector(".file-name");
                          const defaultBtn = document.querySelector("#default-btn");
                          const customBtn = document.querySelector("#custom-btn");
                          const cancelBtn = document.querySelector("#cancel-btn i");
                          const img = document.querySelector("img");
                          const predictionsDiv = document.getElementById("predictions");
                          let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
                          async function loadModel() {
                              return await mobilenet.load();
                          }
                          async function classifyImage(imageElement, model) {
                              const predictions = await model.classify(imageElement);
                              return predictions;
                          }
                          function defaultBtnActive(){
                            defaultBtn.click();
                          }
                          defaultBtn.addEventListener("change", async function(){
                            const file = this.files[0];
                            if(file){
                              const reader = new FileReader();
                              reader.onload = async function(){
                                const result = reader.result;
                                img.src = result;
                                wrapper.classList.add("active");
                                const model = await loadModel();
                                const predictions = await classifyImage(img, model);
                                displayPredictions(predictions);
                              }
                              cancelBtn.addEventListener("click", function(){
                                img.src = "";
                                wrapper.classList.remove("active");
                              })
                              reader.readAsDataURL(file);
                            }
                            if(this.value){
                              let valueStore = this.value.match(regExp);
                              fileName.textContent = valueStore;
                            }
                          });
                          function displayPredictions(predictions) {
                              predictionsDiv.innerHTML = "<h2>Identified:</h2>";
                              predictions.forEach(prediction => {
                                  predictionsDiv.innerHTML += `<p>${prediction.className}: ${Math.round(prediction.probability * 100)}%</p>`;
                              });
                          }
                          //loading circle appears here
                          const loadingCircle = document.getElementById("loadingCircle");
                          async function defaultBtnActive() {
                              defaultBtn.click();
                              loadingCircle.style.display = "block";
                          }
  
                          async function classifyImage(imageElement, model) {
                              const predictions = await model.classify(imageElement);
                              loadingCircle.style.display = "none"; // Hide loading circle once prediction is completed
                              return predictions;
                          }
                       </script>

            <script>
               function autocomplete(inp, arr) {
                    /*the autocomplete function takes two arguments,
                    the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function(e) {
                        var a, b, i, val = this.value;
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) { return false;}
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                          /*check if the item starts with the same letters as the text field value:*/
                          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                          }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function(e) {
                        var x = document.getElementById(this.id + "autocomplete-list");
                        if (x) x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                          /*If the arrow DOWN key is pressed,
                          increase the currentFocus variable:*/
                          currentFocus++;
                          /*and and make the current item more visible:*/
                          addActive(x);
                        } else if (e.keyCode == 38) { //up
                          /*If the arrow UP key is pressed,
                          decrease the currentFocus variable:*/
                          currentFocus--;
                          /*and and make the current item more visible:*/
                          addActive(x);
                        } else if (e.keyCode == 13) {
                          /*If the ENTER key is pressed, prevent the form from being submitted,*/
                          e.preventDefault();
                          if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                          }
                        }
                    });
                    function addActive(x) {
                      /*a function to classify an item as "active":*/
                      if (!x) return false;
                      /*start by removing the "active" class on all items:*/
                      removeActive(x);
                      if (currentFocus >= x.length) currentFocus = 0;
                      if (currentFocus < 0) currentFocus = (x.length - 1);
                      /*add class "autocomplete-active":*/
                      x[currentFocus].classList.add("autocomplete-active");
                    }
                    function removeActive(x) {
                      /*a function to remove the "active" class from all autocomplete items:*/
                      for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                      }
                    }
                    function closeAllLists(elmnt) {
                      /*close all autocomplete lists in the document,
                      except the one passed as an argument:*/
                      var x = document.getElementsByClassName("autocomplete-items");
                      for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                      }
                    }
                  }
                  /*execute a function when someone clicks in the document:*/
                  document.addEventListener("click", function (e) {
                      closeAllLists(e.target);
                  });
                  } 
                  var countries = ["European Silver Fir","Pyramidalis Silver Fir","White Fir", "Candicans White Fir", "Fraser Fir", "Golden Korean Fir", "Alpine Fir","Blue Spanish Fir", "Noble Fir", "Johin Japanese Maple", "Snakebark Maple", "Amur Maple", "Flame Amur Maple", "Red Rhapsody Amur Maple", "Ruby Slippers Amur Maple", "Paperbark Maple", "Fullmoon Maple", "Cutleaf Fullmoon Maple", "Attaryi Fullmoon Maple*", "Golden Fullmoon Maple", "Emmett's Pumpkin Fullmoon Maple", "Green Cascade Maple", "Big Leaf Maple", "Mocha Rose Big Leaf Maple", "Flamingo Boxelder", "Kelly's Gold Boxelder", "Japanese Maple", "Aka Shigitatsu Sawa Japanese Maple", "Alpenweiss Variegated Dwarf Japanese Maple*", "Ao Shime No Uchi Japanese Maple"];
                  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
                  autocomplete(document.getElementById("myInput"), countries);
            </script>
        </section>
                </div>
            </div>
        </section>     
        <div class="right-images" style="background-color: transparent;right: 0px;">
            <img src="plant3.png" alt="Image 1">
        </div>
    </main>
    <script src="js/main.js" type="module"></script>
</body>
</html>
