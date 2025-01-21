<p class="simple" style="text-decoration: underline;">Ranglisták:</p>
<div style="display: inline-block;">
			<table class='board leaderboard' style="float: left;" id="allTimeLB">
				<caption class='extra'>Összesített ranglista</caption>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				
					<?php
						$LB_result = SQL_allTimeLeaderboard();

						$count = 0;
						while ($row = mysqli_fetch_array($LB_result,MYSQLI_ASSOC)) {
							$b_UserHash = $row['UserHash'];
							$score = $row['Score'];
							$count += 1;

							$b_username = SQL_getUserName($b_UserHash);

							echo("<tr class='leaderboard'>");
								echo("<td><a class='extra' style='color:#FF6F59'>#" . $count . "</a></td>");
								echo ("<td><a class='extra'>" . SQL_getUserIcon($b_UserHash) . $b_username . "</a><td>");
								echo ("<td><a class='extra' style='color: #61F2C2;'>" . $score . " pont</a><td>");
							echo("</tr>");
						}

						if ($count == 0) {
							echo("<tr>");
								echo("<td><a class='extra' style='color:#FF6F59'>Még nincsenek válaszok.</a></td>");
							echo("</tr>");
							echo("<script>document.getElementById('allTimeLB').class = 'board';</script>");
						}
					?>
				
			</table>
			<table class='board leaderboard' id="dailyLB">
				<caption class='extra'>Napi ranglista</caption>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				
					<?php
						$LB_result = SQL_dailyLeaderboard($QuestionID);

						$count = 0;
						while ($row = mysqli_fetch_array($LB_result,MYSQLI_ASSOC)) {
							$b_UserHash = $row['UserHash'];
							$score = $row['Score'];
							$count += 1;

							$b_username = SQL_getUserName($b_UserHash);

							echo("<tr class='leaderboard'>");
								echo("<td><a class='extra' style='color:#FF6F59'>#" . $count . "</a></td>");
								echo ("<td><a class='extra'>" . SQL_getUserIcon($b_UserHash) . $b_username . "</a><td>");
								echo ("<td><a class='extra' style='color: #61F2C2;'>" . $score . " pont</a><td>");
							echo("</tr>");
						}

						if ($count == 0) {
							echo("<tr>");
								echo("<td><a class='extra' style='color:#FF6F59'>Még nincsenek válaszok.</a></td>");
							echo("</tr>");
							echo("<script>document.getElementById('dailyLB').class = 'board';</script>");
						}
					?>
				
			</table>
		</div>