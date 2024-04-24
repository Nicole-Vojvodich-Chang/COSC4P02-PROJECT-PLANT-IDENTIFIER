<link rel="icon" href="/../LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}



function updateUserProfile($name, $email, $age, $location, $bio)
{
	$servername = "localhost";
	$username = "root";		
	$password = "";
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("ERROR PLEASE TRY AGAIN LATER... : " . mysqli_connect_error());
	}
	$sql = "UPDATE details SET name = '" . $name . "' , email = '" . $email . "' , age = '" . $age . "' , location = '" . $location . "' , bio = '" . $bio . "' WHERE username = 'GinkoBinko'";					   
    if ($conn->query($sql) == TRUE){}
}







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Hugger</title>
    <link rel="stylesheet" href="settings-style.css">
</head>
<body>
    <header>
        <img src="Tree-Hugger-Co-Logo.png" alt="Tree Hugger" id="logo">
        <div id="company-name">
            <span>Tree</span>
            <span>Hugger</span>
        </div>
        <nav>
            <button class="nav-button" onclick="location.href='/../home/home.php';">Home</button>
			<button class="nav-button" onclick="location.href='/../plants.php';">PlantList</button>
            <button class="nav-button" onclick="location.href='environments.php';">Garden</button>
        </nav>
    </header>
    <main>
        <!-- Can pre-load fields with current account details -->
        <form id="user-settings-form" method = "post">
            <h1>Account Details</h1>
            <div class="setting-item">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="setting-item">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="setting-item">
                <label for="degree">Degree:</label>
                <input type="text" id="degree" name="degree">
            </div>
            <div class="setting-item">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="0">
            </div>
            <div class="setting-item">
                <label for="city">Country:</label>
                <input type="text" id="city" name="city">
            </div>
            <div class="setting-item">
                <label for="bio">Account Bio:</label>
                <textarea id="bio" name="bio" rows="4" cols="50"></textarea>
            </div>
            <div class="setting-item">
                <button type="submit">UPDATE</button>
            </div>
			<?php
			if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["degree"])&& isset($_POST["age"])&& isset($_POST["city"]))
			{
				updateUserProfile($_POST["name"],$_POST["email"],$_POST["degree"],$_POST["age"],$_POST["city"]);
			}
			?>
        </form>

		<h1>Account Settings</h1>

		<form id="settings" method = "post">
		<div class="setting-item">
			<label for="languages">Language:</label>
			<select name="languages" id="languages">
			<option value="English">English</option>
			
			<label for="accType">Account Visibility:</label>
			</select>
			<br>
			<select name="accType" id="accType">
			<option value="public">Public</option>
			<option value="private">Private</option>
			</select>
			<br>
			
			<label for="eUpdate">Receive Email Updates:</label>
			<input type="checkbox" name="eUpdate" checked>
			
			<label for="2FA">Two Factor Authentication:</label>
			<input type="checkbox" name="2FA" checked>
			
            <button type="apply">Apply</button>
		</div>
			<?php
				//WRITE CODE INTO THIS
				//UPDATE ACCOUNT CREATION TO ADD SETTINGS ENTRY
				
				
				//echo $_POST["languages"];
			?>
		</form>
		<?php
				echo date("m/d/Y") ;
		?>
        
    </main>
</body>
</html>
