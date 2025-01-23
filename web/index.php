<?php
	include('db.php');
	session_start();
	include('userinfo.php');

	if (!SQL_hasDailyQuestion()) {
		SQL_getNewQuestion();
	}

	$QuestionID = SQL_getDailyQuestionID();

	if (SQL_hasAnsweredQuestion($QuestionID, $hash)) {
		header('Location: scoreboard.php');
		exit();
	}

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
		<?php include ('news.html');?>
		<hr>
		<p class="simple" style="text-decoration: underline;">A nap kérdése:</p>

		<h1 class="question"><?php echo(SQL_getDailyQuestionText()); ?> </h1>

		<br>
		<br>
		<div class="smallextra" id="slider" style="width: 70%;"></div>
		<br><br><br><br>

		<form action="/submit.php" onkeydown="return event.key != 'Enter';">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
				<table>
  					<tr>
  						<th></th>
  						<th></th>
  					</tr>
  					<tr>
  						<td><a class="extra">Min: </a></td>
  						<td><input type="number" id="input-min" name="input-min"> <a id="unit-min"><?php echo($unit); ?></a></td>
  					</tr>
  					<tr>
  						<td><a class="extra"> Max: </a></td>
  						<td><input type="number" id="input-max" name="input-max"> <a id="unit-max"><?php echo($unit); ?></a></td>
  					</tr>
  					<tr>
  						<td><a class="extra" style="color: #FF6F59;"> Jutalom: </a></td>
  						<td><a id="reward-disp" class="extra" style="color: #61F2C2;">200 pont</a></td>
  					</tr>
  				</table>		
			</div>
			<br>
			<button type="submit" id="submitbtn">Válasz beküldése</button>
		</form>
		<br>
		<?php include('leaderboards.php'); ?>
	</center>

</body>
</html>


<script type="text/javascript">
	var slider = document.getElementById('slider');

	var min = <?php echo($min); ?>;
	var max = <?php echo($max); ?>;

	var steps = 11;
	var step = (Math.log(max) - Math.log(min))/(steps - 1);

	var logscale = [];
	for (var i = 0; i < steps; i++)
	{
    	logscale.push(Math.floor(Math.exp(Math.log(min) + i * step)));
	}
	console.log(logscale)

	noUiSlider.create(slider, {
    	start: [min, max],
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

    	snap: false,

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
    			//console.log("from ", value);
        	    return Math.round(parseFloat(value));
        	},
    		to: function(value) {
    			//console.log("to ", value);
            	return Math.round(parseFloat(value));
        	}
    	},
	});

</script>

<script type="text/javascript">
	var inputMin = document.getElementById('input-min');
	var inputMax = document.getElementById('input-max');

	function copyhash() {
		navigator.clipboard.writeText( <?php echo("'" . $hash . "'"); ?> );
	}

	function calcScore(min, max) {
		var min = parseInt(inputMin.value);
		var max = parseInt(inputMax.value);
		var score = Math.floor(100/(max/min));

		document.getElementById("reward-disp").innerHTML = score.toString() + " pont";

		if (score > 0) {
			document.getElementById("submitbtn").disabled = false;
		} else {
			document.getElementById("submitbtn").disabled = true;
		}
	}
</script>

<script type="text/javascript">
	
slider.noUiSlider.on('update', function (values, handle) {

    var value = values[handle];

    console.log("slider updated: ", values);

    if (handle) {
        inputMax.value = value;
    } else {
        inputMin.value = value;
    }
    calcScore();
});

inputMax.addEventListener('change', function () {
	console.log("inputmax updated: ", this.value)
    slider.noUiSlider.set([null, this.value], true, true);
    calcScore();
});

inputMin.addEventListener('change', function () {
	console.log("inputmin updated: ", this.value)
    slider.noUiSlider.set([this.value, null], true, true);
    calcScore();
});

</script>
