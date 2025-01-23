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
			//echo("name: " . $name . "<br>");

			$hash = generateRandomString(32);
			while(SQL_doesHashExist($hash)) {
				$hash = generateRandomString(32);
			}
			//echo("hash: " . $hash . "<br>");

			$icon = mysqli_real_escape_string($db, $_POST["input-icon"]);
			//echo("icon: " . $icon . "<br>");

			if (SQL_doesNameExist($name)) {
				$warnBox = <<<HTML
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
						<strong>Hiba!</strong> Ez a felhasználónév már foglalt!
					</div>
				HTML;
				echo($warnBox);
			} else {
				mysqli_query($db, "INSERT INTO Users (Hash, Name, Icon) VALUES ('{$hash}', '{$name}', '{$icon}');");

				setcookie("UserHash",$hash,time() + (5 * 365 * 24 * 60 * 60));

				header('Location: index.php');
				exit;
			}
		} else {
			$hash = mysqli_real_escape_string($db, $_POST["input-hash"]);
			if (!SQL_doesHashExist($hash)) {
				$warnBox = <<<HTML
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
						<strong>Hiba!</strong> Nem létező kód.
					</div>
				HTML;
				echo($warnBox);
			} else {
				setcookie("UserHash",$hash,time() + (5 * 365 * 24 * 60 * 60));
				header('Location: index.php');
				exit;
			}
		}
	}
?>

<html>
<meta charset="UTF-8">
<title>- NapiTipp -</title>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Galindo&display=swap" rel="stylesheet">

	<script src="nouislider.min.js"></script>
	<link href="nouislider.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<base href=".">
	<script type="module" src="/node_modules/emoji-picker-element/picker.js"></script>
	<script type="module" src="/node_modules/emoji-picker-element/database.js"></script>
</head>
<body style="background-color:#255F85;">

	<div style="text-align: right; display: inline; white-space: nowrap; position: absolute; right: 8px;" class="board tooltip" onclick="document.location.href='/index.php'">
		<a class="extra">Főoldal</a> 
	</div>

	<center>

		<h1 class="extra" style="color:  #5BC0EB;">- NapiTipp -</h1>
		<hr>
		<p class="simple" style="text-decoration: underline;">Új profil létrehozása:</p>

		<form action="/login.php" method="POST">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
			
				<a class="extra">Név:</a> <input type="text" name="input-name" required maxlength="10"><br>
				<a class="extra" style="color: #FF6F59;"> Ikon: </a>
				<!-- <select name="input-icon">
  					<option value="1">&#128512;</option>
  					<option value="2">&#128513;</option>
  					<option value="3">&#128511;</option>
  					<option value="4">&#128509;</option>
				</select> -->
				<input style="background: transparent; border: none;" type="text" name="input-icon" id="input-icon" readonly value="😀">
				<emoji-picker></emoji-picker>

			</div>
			<br>
			<button type="submit">Profil mentése</button>
		</form>

		<br>
		<hr style="width: 10%;">
		<br>

		<p class="simple" style="text-decoration: underline;">Bejelentkezés:</p>

		<form action="/login.php" method="POST">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
			
				<a class="extra">Kód:</a> <input type="text" name="input-hash" required><br>

			</div>
			<br>
			<button type="submit">Bejelentkezés</button>
		</form>

		<br>
		<hr style="width: 10%;">
		<br>

		<?php
		if (isset($_COOKIE['UserHash'])) {
			$codeBox = <<<HTML
			<details>
				<summary class="extra">Titkos kód</summary>
				{$_COOKIE['UserHash']}
			</details>
			HTML;
			echo($codeBox);
		}
		?>

		<br><br><br><br><br><br><br><br>
	</center>

</body>
</html>

<script type="text/javascript">
	var inputIcon = document.getElementById("input-icon");
	document.querySelector('emoji-picker').addEventListener('emoji-click', event => inputIcon.value = event.detail.unicode);
</script>