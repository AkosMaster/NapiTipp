<?php
	include('db.php');
	session_start();
	include('userinfo.php');

	if (!SQL_hasDailyQuestion()) {
		SQL_getNewQuestion();
	}

	$QuestionID = SQL_getDailyQuestionID();

	$min = SQL_getDailyQuestionMin();
	$max = SQL_getDailyQuestionMax();
	$answer = SQL_getDailyQuestionAnswer();
	$unit = SQL_getDailyQuestionUnit();
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

	<?php include('banner.php') ?>

	<center>

		<h1 class="extra" style="color:  #5BC0EB;">- NapiTipp -</h1>
		<hr>
		<p class="simple" style="text-decoration: underline;">A nap kérdése:</p>

		<h1 class="question"><?php echo(SQL_getDailyQuestionText()); ?> </h1>

		<h2 class="extra" style="color: #61F2C2;">
			<?php
				if (SQL_hasAnsweredQuestion($QuestionID, $hash)) {
					$score = SQL_getAnswerScore($QuestionID, $hash);

					echo("<div class='smallextra' id='slider' style='width: 70%;'></div><br><br><br><br>");

					$userMin = SQL_getAnswerMin($QuestionID, $hash);
					$userMax = SQL_getAnswerMax($QuestionID, $hash);

					if ($score > 0) {
						echo("<a class='extra'>Helyes válasz!</a><br>");
						echo($score . " pont");
					} else {
						echo("<a style=\"color: #FF6F59;\">Helytelen válasz!</a>");
					}
				} else {
					echo("<button onclick=\"document.location.href='index.php'\">Válaszolok!</button>");
				}
			?>
		</h2>

		<br>
		

		<?php include('leaderboards.php'); ?>

	</center>

</body>
</html>

<style type="text/css">
.noUi-handle {
  border-radius: 0 !important;
    height: 18px!important;
    width: 10px!important;
    top: -1px!important;
    right: -9px!important;
    border-radius: 0!important;
}

.noUi-handle[data-handle="1"] {
  border: 1px solid #cccccc;
    border-radius: 5px;
    background-color: #FDE74C; /* For Safari 5.1 to 6.0 */
    background-image: url(img/star.png)!important;
    background-size: 100% 100%!important;
    background-repeat: no-repeat!important;
    cursor: col-resize;
    box-shadow: inset 0 0 1px #FFF,
                inset 0 1px 7px #EBEBEB,
                0 3px 6px -3px #BBB;
    width: 18px!important;
}

.noUi-handle[data-handle="1"] > .noUi-tooltip {
	bottom: unset!important;
	background-color: #FDE74C;
}

</style>

<script type="text/javascript">
	var slider = document.getElementById('slider');

	var min = <?php echo($min); ?>;
	var max = <?php echo($max); ?>;

	var userMin = <?php echo($userMin); ?>;
	var userMax = <?php echo($userMax); ?>;

	var answer = <?php echo($answer); ?>;

	var steps = 11;
	var step = (Math.log(max) - Math.log(min))/(steps - 1);

	var logscale = [];
	for (var i = 0; i < steps; i++)
	{
    	logscale.push(Math.exp(Math.log(min) + i * step));
	}
	console.log(logscale)

	noUiSlider.create(slider, {
    	start: [userMin, answer, userMax],
    	connect: true,
    	range: {
        	'min': min,
        	'max': max
    	},

    	pips: {
        	mode: 'steps',
        	stepped: false,
        	density: 10
    	},

    	range: {
        	'min': [min],
        	'10%': [logscale[1]],
        	'20%': [logscale[2]],
        	'30%': [logscale[3]],
        	'40%': [logscale[4]],
        	'50%': [logscale[5]],
        	'60%': [logscale[6]],
        	'70%': [logscale[7]],
        	'80%': [logscale[8]],
        	'90%': [logscale[9]],
        	'max': [max]
    	},

    	tooltips: true,

    	format: {
    		from: function(value) {
        	    return parseInt(value);
        	},
    		to: function(value) {
            	return parseInt(value);
        	}
    	},
	});

	slider.noUiSlider.disable();

</script>
