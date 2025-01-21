<?php
if (!isset($_COOKIE['UserHash'])) {
	header('Location: login.php');
	exit;
}
$hash = $_COOKIE['UserHash'];

if (!SQL_doesHashExist($hash)) {
	header('Location: login.php');
	exit;
}

setcookie("UserHash",$hash,time() + (5 * 365 * 24 * 60 * 60));

$username = SQL_getUserName($hash);
$icon = SQL_getUserIcon($hash);
?>