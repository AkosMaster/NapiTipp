<?php
	include('db.php');
	session_start();
	include('userinfo.php');

	$viewedHash = $hash;

	if (isset($_GET['uname'])) {
		$viewedHash = SQL_getUserHashByName(mysqli_escape_string($db,$_GET['uname']));
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
</head>
<body style="background-color:#255F85;">

	<div style="text-align: left; display: inline; white-space: nowrap; position: absolute;" class="board tooltip" onclick="document.location.href='/viewprofile.php'">
	<a class="extra"><?php echo($icon . $username); ?> (</a> <a id="userscore-disp" class="extra" style="color: #61F2C2;"> <?php echo(SQL_getUserScore($hash)); ?>p </a> <a class="extra">)</a> <br>

	</div>

	<div style="text-align: right; display: inline; white-space: nowrap; position: absolute; right: 8px;" class="board tooltip" onclick="document.location.href='/index.php'">
		<a class="extra">Főoldal</a> 
	</div>

	<center>

		<h1 class="extra" style="color:  #5BC0EB;">- NapiTipp -</h1>
		<hr>
		

		<div style="text-align: left; white-space: nowrap;" class="board tooltip" onclick="copyhash()">
			<a class="extra"><?php echo(SQL_getUserIcon($viewedHash) . SQL_getUserName($viewedHash)); ?> (</a> <a id="userscore-disp" class="extra" style="color: #61F2C2;"> <?php echo(SQL_getUserScore($viewedHash)); ?>p </a> <a class="extra">)</a> <br>
		</div>
		
		<table class='board' id="userAnswers">
				<caption class='extra'>Korábbi válaszok:</caption>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				
					<?php
						$_result = SQL_previousAnswers($viewedHash);

						$count = 0;
						while ($row = mysqli_fetch_array($_result,MYSQLI_ASSOC)) {
							$b_UserHash = $row['UserHash'];
							$score = $row['Score'];
							$qid = $row['QuestionID'];
							$count += 1;

							$text = SQL_getQuestionText($qid);
							$day = SQL_getQuestionDayUsed($qid);

							echo("<tr class='leaderboard'>");
								echo("<td><a class='extra' style='color:#FF6F59'>#" . $day . "</a></td>");
								echo ("<td><a class='extra'>" . $text . "</a><td>");
								echo ("<td><a class='extra' style='color: #61F2C2;'>" . $score . " pont</a><td>");
							echo("</tr>");
						}

						if ($count == 0) {
							echo("<tr>");
								echo("<td><a class='extra' style='color:#FF6F59'>Még nincsenek válaszok.</a></td>");
							echo("</tr>");
							echo("<script>document.getElementById('userAnswers').class = 'board';</script>");
						}
					?>
				
			</table>

	</center>

</body>
</html>


