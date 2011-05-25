<h1>Add New Game</h1>

<script type="text/javascript" src="<?=base_url()?>scripts/scorewidget.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults($.datepicker.regional[""]);
		$( "#completedDate" ).datetimepicker({ampm: true});
	});
</script>

<?=form_open('adhoc_matches/add_game', array('class' => 'fstyle'));?>
<?=form_hidden('matchId', $match->idMatch);?>
<p>Please enter information for the game:</p>
<ol>
	<li>
		<div name="scoreWidget">
			<label for="team1Score"><?=$teams[0]->name."'s "?>Score</label>
			<input type="text" id="team1Score" name="team1Score" value="0" class="numTxt" maxlength="4" />
			<img src="<?=base_url()?>images/down_arrow.png" width="20px" height="20px" class="updownbuttons" />
			<img src="<?=base_url()?>images/up_arrow.png" width="20px" height="20px" class="updownbuttons" />
		</div>
	</li>
	<li>
		<div name="scoreWidget">
			<label for="team2Score"><?=$teams[1]->name."'s "?> Score</label>
			<input type="text" id="team2Score" name="team2Score" value="0" class="numTxt" maxlength="4" />
			<img src="<?=base_url()?>images/down_arrow.png" width="20px" height="20px" class="updownbuttons" />
			<img src="<?=base_url()?>images/up_arrow.png" width="20px" height="20px" class="updownbuttons" />
		</div>
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
		<input type="text" id="completedDate" name="completedDate" value="<?=date("y-m-d h:i a");?>"/>
	</li>
	<li id="send">
		<button type="submit">Add Game</button>
	</li>
</ol>
</form>

<p><?=anchor("adhoc_matches/".$match->idMatch, "Back to Match")?></p>