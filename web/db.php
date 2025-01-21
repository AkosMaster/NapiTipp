<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'NapiTipp');
	$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

	function SQL_doesNameExist($name) {
		global $db;
		$result = mysqli_query($db, "SELECT * FROM Users WHERE Name='" . $name . "';");
		return $result->num_rows > 0;
	}

	function SQL_doesHashExist($hash) {
		global $db;
		$result = mysqli_query($db, "SELECT * FROM Users WHERE Hash='" . $hash . "';");
		return $result->num_rows > 0;
	}

	function SQL_getUserName($hash) {
		global $db;
		$result = mysqli_query($db, "SELECT Name FROM Users WHERE Hash='" . $hash . "';");
		return $result->fetch_row()[0];
	}

	function SQL_getUserIcon($hash) {
		global $db;
		$result = mysqli_query($db, "SELECT Icon FROM Users WHERE Hash='" . $hash . "';");
		return $result->fetch_row()[0];
	}

	function SQL_hasDailyQuestion() {
		global $db;
		$date = date('Y-m-d', time());
		$result = mysqli_query($db, "SELECT * FROM Questions WHERE dayUsed='{$date}';");
		return $result->num_rows > 0;
	}

	function SQL_getNewQuestion() {
		global $db;
		$result = mysqli_query($db, "SELECT ID FROM Questions WHERE dayUsed IS NULL;");
		$id = $result->fetch_row()[0];

		$date = date('Y-m-d', time());
		
		mysqli_query($db, "UPDATE Questions SET dayUsed=CAST('{$date}' AS DATE) WHERE ID={$id};");
	}

	function SQL_getDailyQuestionText() {
		global $db;
		$date = date('Y-m-d', time());
		$result = mysqli_query($db, "SELECT Text FROM Questions WHERE dayUsed='{$date}';");
		return $result->fetch_row()[0];
	}

	function SQL_getDailyQuestionMin() {
		global $db;
		$date = date('Y-m-d', time());
		$result = mysqli_query($db, "SELECT Min FROM Questions WHERE dayUsed='{$date}';");
		return $result->fetch_row()[0];
	}

	function SQL_getDailyQuestionMax() {
		global $db;
		$date = date('Y-m-d', time());
		$result = mysqli_query($db, "SELECT Max FROM Questions WHERE dayUsed='{$date}';");
		return $result->fetch_row()[0];
	}

	function SQL_getDailyQuestionAnswer() {
		global $db;
		$date = date('Y-m-d', time());
		$result = mysqli_query($db, "SELECT Answer FROM Questions WHERE dayUsed='{$date}';");
		return $result->fetch_row()[0];
	}
	//htmlspecialchars($string, ENT_QUOTES, 'UTF-8')
?>