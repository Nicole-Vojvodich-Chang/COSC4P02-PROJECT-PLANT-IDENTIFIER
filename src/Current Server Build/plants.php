<link rel="icon" href="LEAF.png">
<meta http-equiv="Cache-control" content="public">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_GET['page']))
{
	$_GET['page'] = 1;
}

function searchPlant($url, $plantName)
{
	$url .= $plantName;
	
	if(array_key_exists('next', $_POST)) 
	{ 
		$_GET['page'] += 1;
    } 
	if(array_key_exists('previous', $_POST)) 
	{ 
		$_GET['page'] -= 1;
    } 

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "my_password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	$output = curl_exec($ch);
	$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$array = json_decode( $output, true );
	$vals = $array['data'];

	
	echo '<h1>SHOWING RESULTS FOR: "' . $_POST["sBox"] . '"<br> </h1>';
	if (sizeof($vals) < 1)
	{
		echo "<br>NO RESULTS FOUND!<br>";
	}
	else
	{
		echo "FOUND A TOTAL OF " . sizeof($vals) . " RESULTS<br>";
	}
	
	
	
	echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
	echo '<input type="submit" name="previous" value = "PREVIOUS PAGE">';	
	echo '<input type="submit" name="next" value = "NEXT PAGE">';	
	echo "</form>";
	
	echo "<center><table cellspacing='3' bgcolor='#000000'>";
	echo "<tr bgcolor='#ffffff'><th><h2>common name</h2></th><th><h2>scientific name</h2></th><th><h2>image</h2></th></tr>";
	
	for ($x = 0; $x < sizeof($vals); $x++)
	{
		echo "<tr bgcolor='#ffffff'>";
		
		if (isset($vals[$x]['default_image']['original_url']))
		{
			echo "<td><img src=" . $vals[$x]['default_image']['original_url'] . " style='width:512px;height:512px;'></td>";
		}
		else
		{
			echo "<td>NO IMAGE AVAILABLE!</td>";
		}
		echo "<center><td align='center'><h1>" . $vals[$x]['common_name'] . "</h1></td></center>";
		echo "<center><td align='center'><h1>" . $vals[$x]['scientific_name'][0] . "</h1></td></center>";
		echo "</tr>";	
	}
	echo "</table></center>";
	
	echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
	echo '<input type="submit" name="previous" value = "PREVIOUS PAGE">';	
	echo '<input type="submit" name="next" value = "NEXT PAGE">';	
	echo "</form>";
	
	
	
	
}

function call($url)
{	
	if ($_GET['page'] < 1 && isset($_GET['page']))
	{
		$_GET['page'] = 1;
	}
	if(array_key_exists('next', $_POST)) 
	{ 
		$_GET['page'] += 1;
    } 
	if(array_key_exists('previous', $_POST)) 
	{ 
		$_GET['page'] -= 1;
    } 
	
	$url .= $_GET['page'];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "my_password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	$output = curl_exec($ch);
	$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$array = json_decode( $output, true );
	$vals = $array['data'];
	$cName = $vals[0];
	
	echo "<h1>LIST OF PLANT SPECIES: </h1>";

	echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
	echo '<input type="submit" name="previous" value = "PREVIOUS PAGE">';	
	echo '<input type="submit" name="next" value = "NEXT PAGE">';	
	echo "</form>";


	echo "<center><table cellspacing='3' bgcolor='#000000'>";
	echo "<tr bgcolor='#ffffff'><th><h2>IMAGE</h2></th><th><h2>COMMON NAME</h2></th><th><h2>SCIENTIFIC NAME</h2></th></tr>";
	
	for ($x = 0; $x < sizeof($vals); $x++)
	{
		echo "<tr bgcolor='#ffffff'>";
		
		if (isset($vals[$x]['default_image']['original_url']))
		{
			echo "<td><img src=" . $vals[$x]['default_image']['original_url'] . " style='width:512px;height:512px;'></td>";
		}
		else
		{
			echo "<td>NO IMAGE AVAILABLE!</td>";
		}
		echo "<center><td align='center'><h1>" . $vals[$x]['common_name'] . "</h1></td></center>";
		echo "<center><td align='center'><h1>" . $vals[$x]['scientific_name'][0] . "</h1></td></center>";
		echo "</tr>";	
	}
	echo "</table></center>";
	
	echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
	echo '<input type="submit" name="previous" value = "PREVIOUS PAGE">';	
	echo '<input type="submit" name="next" value = "NEXT PAGE">';	
	echo "</form>";
	

	
}
?>

<html>
	<?php 
		echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
		echo '<input type="text" name="sBox">';
		echo '<input type="submit" name="SEARCH" value = "SEARCH PLANT">';		
		echo "</form>";
	
		if (isset($_POST["sBox"]))
		{
			if ($_POST["sBox"] != "")
			{
				searchPlant("https://perenual.com/api/species-list?key=sk-Isew65d71a109b4c94313&q=", $_POST["sBox"]);
				echo "<br>";
			}
			else
			{
				header("Location: plants.php?page=1");
			}
			echo "<a href='plants.php?page=1'> RETURN TO LIST </a>";
		}
		else
		{
			//alphabetical
			//call("https://perenual.com/api/species-list?key=sk-Isew65d71a109b4c94313&order=asc&page=", 1);
			
			//default
			call("https://perenual.com/api/species-list?key=sk-Isew65d71a109b4c94313&page=", 1);
		}
	?>
	
</html>
