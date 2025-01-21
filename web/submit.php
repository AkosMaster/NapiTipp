<?php
include('db.php');
session_start();
include('userinfo.php');

$min = mysqli_escape_string($db, $_GET['input-min']);
$max = mysqli_escape_string($db, $_GET['input-max']);

$QuestionID = SQL_getDailyQuestionID();

if (SQL_hasAnsweredQuestion($QuestionID, $hash)) {
	echo('You have already answered this question!');
	exit;
}

$answer = SQL_getDailyQuestionAnswer();

$score = floor(100/($max/$min));

if ($answer < $min || $answer > $max) {
	$score = 0;
}

SQL_submitAnswer($QuestionID, $min, $max, $score);

header('Location: index.php');
exit;
?>