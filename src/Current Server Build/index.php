<link rel="icon" href="LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
//USERPASSWORD AUTHENTICATION FUNCTION
function authenticate($em, $pw)
{
	$servername = "localhost";
	$username = "root";		
	$password = '';
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	$getEmail = "SELECT COUNT(email) from user WHERE email = '" . $em . "'";				
	$eResult = mysqli_query($conn, $getEmail);
	$email = mysqli_fetch_row($eResult);
			
	if ($email[0] == 0)
	{
		$conn->close();
		echo "<br>INCORRECT EMAIL OR PASSWORD <br>";
		return false;
	}
	else
	{
		$getPass = "SELECT PASSWORD FROM `user` WHERE email = '" . $em . "'";
		$getUname = "SELECT username FROM `user` WHERE email = '" . $em . "'";
				
		$pResult = mysqli_query($conn, $getPass);
		$uResult = mysqli_query($conn, $getUname);
		$pass = mysqli_fetch_row($pResult);
		$use = mysqli_fetch_row($uResult);
		$currentUser = $use[0];
		$use[0] = hash('sha256', ($use[0] . $pw ));
				
		if ($pass[0] == $use[0])
		{
			$conn->close();					
			$_SESSION["user"] = $currentUser; 
			exec ('index.php') ;
			return true;
		}
		else
		{
			$conn->close();
			echo "INCORRECT EMAIL OR PASSWORD! <br>";
			return false;
		}
	}
}
		
function logout()
{
	if (isset($_SESSION["user"]))
	{
		echo "LOGOUT SUCCESSFUL";
		session_destroy();
	}
}

?>




<html>
<head>
    <title>Login Page</title>
    <!-- Head section for link to CSS -->
    <link rel="stylesheet" type="text/css" href="login-style-rev.css">
</head>
<body>
	
    <!-- Background div that covers the entire page -->
    <div class="background">

        <div class="login-container">
            
            <!-- Image object for the Tree Hugger Co. Logo -->
            <img src='Tree-Hugger-Co-Logo.png' alt="Tree Hugger Co." class="login-logo-image">
            
            <text id="mainResponse"></text>

            <!-- Container for the log in and register sections -->
            <div class="main-container" id="main">

                <!-- Container for the Sign In and Sign Up buttons -->
                <div class="tab-button-container">
                    
                    <!-- Sign In and Sign up buttons -->
                    <button id="signInBtn" class="signUpInput tab">Sign In</button>
                    <button id="signUpBtn" class="signInInput tab">Sign Up</button>

                </div>
                
                <!-- Sign In form section -->
                <div id="signInForm">
				
                    
					
					
                    
                    
					<form action="index.php" method="post">
					<?php 
					echo '<label for="signInUsernameInput">USERNAME</label>';
                    echo '<input name="user" type="text" id="signInUsernameInput"  placeholder="e.g. JohnDoe123">';
                    echo '<div class="password-container">';                        
                    echo '<label for="signInPasswordInput">PASSWORD</label>';
                    echo '<input name="pass" type="password" id="signInPasswordInput" class="signInInput" placeholder="*************">';
                    echo '<button type="button" id="signInTogglePassword" class="toggle-password signInInput">👁️‍🗨️</button>   ';
                    echo '</div>';
					
					
					
					if (isset($_POST["user"]) && isset($_POST["pass"]) && $_POST["pass"] != "" && $_POST["user"] != "")
					{
						echo "<script> console.log('", $_POST["user"] , " " , $_POST["pass"] ,"'); </script>";
					}
					else
					{	
						echo "<script> console.log('ENSURE BOTH FIELDS ARE ENTERED!'); </script>";
					}
					
					echo '<button type="submit" id="login" class="signInInput">Login</button>    <!-- Login button -->'
					
					?>
					
			
					</form>
					<a href='index.php' >Forgot Password?</a>
					
					
		
					
					
					
				
					
					

					
				</div>

                <!-- Sign Up form section (initially hidden) -->
                <div id="signUpForm" style="display: none;">
                    
					
					<form action="index.php" method="post">
					<?php 
					echo '<label for="signUpUsernameInput">USERNAME</label>';
					echo '<input name = "nuser" type="text" id="signUpUsernameInput" class="signUpInput" placeholder="e.g. JohnDoe123">';
                    
					echo '<div class="password-container">';                        
                        echo '<label for="signInPasswordInput">PASSWORD</label>';
                        echo '<input name = "npass" type="password" id="signUpPasswordInput" class="signUpInput" placeholder="*************">';
                        echo '<button type="button" id="signUpTogglePassword" class="toggle-password signUpInput">👁️‍🗨️</button>';
                    echo '</div>';
                    
					echo '<label for="signUpEmailInput">EMAIL</label>';
                    echo '<input name = "email" type="email" id="signUpEmailInput" class="signUpInput" placeholder="e.g. johndoe123@gmail.com">';
					
					if (isset($_POST["nuser"]) && isset($_POST["npass"]) && isset($_POST["email"]) && $_POST["npass"] != "" && $_POST["nuser"] != "" && $_POST["email"] != "")
					{
						echo '<script> console.log("', $_POST['nuser'] , ' ' , $_POST['npass'] , ' ' , $_POST['email'] ,'"); </script>';
					}
					else
					{	
						echo '<script> console.log("ENSURE ALL FIELDS ARE ENTERED!"); </script>';
					}
                    
					

                    echo '<button type="submit" id="register" class="signUpInput">Register</button>'
					?>
					
                    </form>
					
                </div>
            </div>

            <!-- Security Code section -->
            <div class = "security-container" style="display: none;" id="security">
                <body id="security-body">
                    A security code has been sent to the email address you have chosen to register with. Please enter it below.
                </body>
                <text id="securityResponse"></text>
                <label for="codeInput" id ="codeInputLabel">SECURITY CODE</label>
                <input type="code" id="codeInput" class="securityInput" placeholder="e.g. G2XH7U">                            <!-- code text field -->
                <button type="button" id="verify" class="securityInput">Verify</button>
            </div>
        </div>
    </div>
    <script src="login-source.js"></script>   <!-- link to the javascript file -->
</body>
</html>