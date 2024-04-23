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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Hugger</title>
    <link rel="stylesheet" href="settings-style.css">
</head>
<body>
    <header>
        <img src="Tree-Hugger-Co-Logo.png" alt="Company Logo" id="logo">
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
        <div id="settings">
            <div class="setting-item">
                <label for="language-dropdown">Language:</label>
                <select id="language-dropdown">
                    <option value="english">English</option>
                    <!-- Add more languages as needed -->
                </select>
            </div>
            <div class="setting-item">
                <label for="account-visibility">Account Visibility:</label>
                <select id="account-visibility">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div class="setting-item">
                <label for="email-notifications">Receive Email Notifications:</label>
                <label class="switch">
                  <input type="checkbox" id="email-notifications">
                  <span class="slider"></span>
                </label>
            </div>
            <div class="setting-item">
                <label for="enable-2fa">Enable 2FA:</label>
                <label class="switch">
                  <input type="checkbox" id="enable-2fa">
                  <span class="slider"></span>
                </label>
            </div>
        </div>
    </main>
</body>
</html>
