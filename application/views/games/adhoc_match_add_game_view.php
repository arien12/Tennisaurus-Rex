<h1>
<?php if ($game): ?>
	Update Existing Game
<?php else: ?>
	Add New Game
<?php endif ?>
</h1>

<script type="text/javascript" src="<?=base_url()?>scripts/scorewidget.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults($.datepicker.regional[""]);
		$( "#completedDate" ).datetimepicker({ampm: true});
	});
</script>

<?=form_open('adhoc_matches/add_game', array('class' => 'fstyle'));?>
<?=form_hidden('matchId', $idMatch);?>
<?php
$team1Score = 0;
$team2Score = 0;
$server = -1;
if ($game):
	$team1Score = $game->points[0];
	$team2Score = $game->points[1];
	$server = $game->server;
endif;
?>
<p>Please enter information for the game:</p>
<ol>
	<li>
		<div name="scoreWidget">
			<label for="team1Score"><?=$teams[0]->name."'s "?>Score</label>
			<input type="text" id="team1Score" name="team1Score" value="<?php echo $team1Score ?>" class="numTxt" maxlength="4" />
			<img src="<?=base_url()?>images/down_arrow.png" width="20px" height="20px" class="updownbuttons" />
			<img src="<?=base_url()?>images/up_arrow.png" width="20px" height="20px" class="updownbuttons" />
		</div>
	</li>
	<li>
		<div name="scoreWidget">
			<label for="team2Score"><?=$teams[1]->name."'s "?> Score</label>
			<input type="text" id="team2Score" name="team2Score" value="<?php echo $team2Score ?>" class="numTxt" maxlength="4" />
			<img src="<?=base_url()?>images/down_arrow.png" width="20px" height="20px" class="updownbuttons" />
			<img src="<?=base_url()?>images/up_arrow.png" width="20px" height="20px" class="updownbuttons" />
		</div>
	</li>
	<li>
		<label for="server" id="server">Server</label>
		<select id="server"  name="server">
			<option value="-1"></option>
			<?php foreach ($players as $player): ?>
				<?php if ($server == $player->idPlayer): ?>
					<option value="<?=$player->idPlayer?>" selected="selected"><?=$player->name?></option>
				<?php else: ?>
					<option value="<?=$player->idPlayer?>"><?=$player->name?></option>
				<?php endif; ?>
			<?php endforeach;?>
		</select>
	</li>
	<li>
		<label for="complatedDate">Date Completed</label>
		<input type="text" id="completedDate" name="completedDate" value="<?=date("y-m-d h:i a");?>"/>
	</li>
	<li id="send">
		<button type="submit">
		<?php if ($game): ?>
			Update Game
		<?php else: ?>
			Add Game
		<?php endif; ?>
		</button>
	</li>
</ol>
</form>

<p>
<?=anchor("adhoc_matches/".$idMatch, "Back to Match");?>
</p>