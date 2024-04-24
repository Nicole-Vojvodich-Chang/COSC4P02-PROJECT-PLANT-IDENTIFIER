<link rel="icon" href="/../LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garden</title>
    <link rel="stylesheet" href="environments-style.css">
</head>
<body>

	<div class="topnav">
        <a href="/../home/home.php">Home</a>
        <a href="/../plants.php">PlantList</a>
		<a href="/../account/account.php" >My Account</a>
		<a href="environments.php" class="active">Garden</a>
		<a href="settings.php">Settings</a>
        <!-- Add more navigation links as needed -->
    </div>

    <div class="image-container">
        <!-- Placeholder for a large image -->
        <img src="meadow.jpg" alt="Nature Background">
    </div>

    <div class="plant-container">
        <!-- Plant items will be generated and inserted here by JavaScript -->
    </div>
<script src="environments-source.js"></script>
</body>
</html>
