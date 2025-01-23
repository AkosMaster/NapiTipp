<div style="text-align: left; display: inline; white-space: nowrap; position: absolute;" class="board tooltip" onclick="document.location.href='/viewprofile.php'">
	<a class="extra"><?php echo($icon . $username); ?> (</a> <a id="userscore-disp" class="extra" style="color: #61F2C2;"> <?php echo(SQL_getUserScore($hash)); ?>p </a> <a class="extra">)</a> <br>

	</div>

	<div style="text-align: right; display: inline; white-space: nowrap; position: absolute; right: 8px;" class="board tooltip" onclick="document.location.href='/login.php'">
		<a class="extra">Profilváltás</a> 
	</div>