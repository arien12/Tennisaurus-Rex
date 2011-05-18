<h1>Add New Game</h1>

<script>
	$(function() {
		$( "#dateCompleted" ).datepicker($.datepicker.regional[ "" ]);
	});
</script>

<?=form_open('adhoc_matches/add_game/'.$currSetId, array('class' => 'fstyle'));?>
<p>Please enter information for the game:</p>
<ol>
	<li>
		<label for="team1Score"><?=$teams[0]->name."'s "?>Score</label>
		<input type="text" id="team1Score" name="team1Score" value="0"/>
	</li>
	<li>
		<label for="team2Score"><?=$teams[1]->name."'s "?> Score</label>
		<input type="text" id="team2Score" name="team2Score" value="0"/>
	</li>
	<li>
		<label for="server" id="server">Server</label>
		<select id="server"  name="server">
			<option value="-1"></option>
			<?php foreach ($players as $player): ?>
				<option value="<?=$player->idPlayer?>"><?=$player->name?></option>
			<?php endforeach;?>
		</select>
	</li>
	<li>
		<label for="complatedDate">Date Completed</label>
		<input type="text" id="completedDate" name="completedDate" value="<?=date("m/d/y");?>"/>
	</li>
	<li id="send">
		<button type="submit">Add Game</button>
	</li>
</ol>
</form>

<p><?=anchor("adhoc_matches/".$match->idMatch, "Back to Match")?></p>