<?php
	include('db.php');
	session_start();

	if (!isset($_COOKIE['UserHash'])) {
		header('Location: login.php');
		exit;
	}
	$hash = $_COOKIE['UserHash'];

	$username = SQL_getUserName($hash);


	if (!SQL_hasDailyQuestion()) {
		SQL_getNewQuestion();
	}

	$min = SQL_getDailyQuestionMin();
	$max = SQL_getDailyQuestionMax();
	$answer = SQL_getDailyQuestionAnswer();
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

	<div style="text-align: left; display: inline; white-space: nowrap; position: absolute;" class="board tooltip" onclick="copyhash()">
		<a class="extra">@<?php echo($username); ?> (</a> <a id="userscore-disp" class="extra" style="color: #61F2C2;"> 1200 pont </a> <a class="extra">)</a> <br>

		<span class="tooltiptext">a kódod: <?php echo($hash); ?> (kattints a másoláshoz)</span>
	</div>

	<div style="text-align: right; display: inline; white-space: nowrap; position: absolute; right: 8px;" class="board tooltip" onclick="document.location.href='/login.php'">
		<a class="extra">Profilváltás</a> 
	</div>

	<center>

		<h1 class="extra" style="color:  #5BC0EB;">NapiTipp</h1>
		<hr>
		<p class="simple" style="text-decoration: underline;">A nap kérdése:</p>

		<h1 class="question"> <?php echo(SQL_getDailyQuestionText()); ?> </h1>

		<br>
		<br>
		<div id="slider" style="width: 50%;"></div>
		<br><br><br><br>

		<form action="/submit.php">
			<div style="text-align: left; display: inline-block; white-space: nowrap;" class="board">
			
				<a class="extra">Minimum:</a> <input type="number" id="input-min" name="input-min"> <a id="unit-min">(év)</a><br>
				<a class="extra"> Maximum: </a><input type="number" id="input-max" name="input-max"> <a id="unit-max">(év)</a><br>
				<a class="extra" style="color: #FF6F59;"> Jutalom: </a><a id="reward-disp" class="extra" style="color: #61F2C2;">200 pont</a>

			</div>
			<br>
			<button type="submit">Válasz beküldése</button>
		</form>
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
    	logscale.push(Math.exp(Math.log(min) + i * step));
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

</script>

<script type="text/javascript">
	

var inputMin = document.getElementById('input-min');
var inputMax = document.getElementById('input-max');
slider.noUiSlider.on('update', function (values, handle) {

    var value = values[handle];

    if (handle) {
        inputMax.value = value;
    } else {
        inputMin.value = value;
    }
});

inputMax.addEventListener('change', function () {
    slider.noUiSlider.set([null, this.value]);
});

inputMin.addEventListener('change', function () {
    slider.noUiSlider.set([null, this.value]);
});

</script>

<script type="text/javascript">
	function copyhash() {
		navigator.clipboard.writeText( <?php echo("'" . $hash . "'"); ?> );
	}
</script>
