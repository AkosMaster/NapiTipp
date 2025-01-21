<?php
	include('db.php');
	session_start();

	function generateRandomString($length = 32) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';

    	for ($i = 0; $i < $length; $i++) {
    	    $randomString .= $characters[random_int(0, $charactersLength - 1)];
    	}

    	return $randomString;
	}
//

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['input-name'])) {
			$name = mysqli_real_escape_string($db, $_POST["input-name"]);
			echo("name: " . $name . "<br>");

			$hash = generateRandomString(32);
			while(SQL_doesHashExist($hash)) {
				$hash = generateRandomString(32);
			}
			echo("hash: " . $hash . "<br>");

			$icon = mysqli_real_escape_string($db, $_POST["input-icon"]);
			echo("icon: " . $icon . "<br>");

			if (SQL_doesNameExist($name)) {
				echo("name already exists!");
				exit;
			}

			mysqli_query($db, "INSERT INTO Users (Hash, Name, Icon) VALUES ('{$hash}', '{$name}', {$icon});");

			setcookie("UserHash",$hash,time() + (5 * 365 * 24 * 60 * 60));
		} else {
			$hash = mysqli_real_escape_string($db, $_POST["input-hash"]);
			if (!SQL_doesHashExist($hash)) {
				echo("invalid hash!");
				exit;
			}

			setcookie("UserHash",$hash,time() + (5 * 365 * 24 * 60 * 60));
		}

		exit;
	}
?>

<html>
<meta charset="UTF-8">
<title>NapiTipp</title>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Galindo&display=swap" rel="stylesheet">

	<script src="nouislider.min.js"></script>
	<link href="nouislider.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
</head>
<body style="background-color:#255F85;">

	<center>

		<h1 class="extra" style="color:  #5BC0EB;">NapiTipp</h1>
		<hr>
		<p class="simple" style="text-decoration: underline;">Új profil létrehozása:</p>

		<form action="/login.php" method="POST">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
			
				<a class="extra">Név:</a> <input type="text" name="input-name"><br>
				<a class="extra" style="color: #FF6F59;"> Ikon: </a>
				<select name="input-icon">
  					<option value="1">&#128512;</option>
  					<option value="2">&#128513;</option>
  					<option value="3">&#128511;</option>
  					<option value="4">&#128509;</option>
				</select>

			</div>
			<br>
			<button type="submit">Profil mentése</button>
		</form>

		<br><br>

		<p class="simple" style="text-decoration: underline;">Bejelentkezés:</p>

		<form action="/login.php" method="POST">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
			
				<a class="extra">Kód:</a> <input type="text" name="input-hash"><br>

			</div>
			<br>
			<button type="submit">Bejelentkezés</button>
		</form>
	</center>

</body>
</html>