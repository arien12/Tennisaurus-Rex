<h1><?=$teams[0]->name?> VS <?=$teams[1]->name?></h1>

<?php foreach ($sets as $set): ?>
<table class="setTable">
	<tr>
		<th colspan="3" class="setHeader">Set <?php echo $set->setNum; ?></th>
	</tr>
	<tr>
		<th></th>
		<th><?php echo $teams[0]->name; ?></th>
		<th><?php echo $teams[1]->name; ?></th>
	</tr>
	<?php for ($i=0; $i < count($set->games); $i++): ?>
	<tr>
		<th><?=anchor("adhoc_matches/edit_game_view/".$match->idMatch."/".$set->games[$i]->idGame, "Game ".($i+1)) ?></th>
		<?php 
		if (intval($set->games[$i]->scores[0]) > intval($set->games[$i]->scores[1])): 
 			$team1Status = "winner"; 
 			$team2Status = "loser"; 
 		else:
			$team2Status = "winner"; 
 			$team1Status = "loser"; 
		endif 
		?>
		<td class="<?php echo $team1Status ?>"><?php echo $set->games[$i]->scores[0]; ?></td>
		<td class="<?php echo $team2Status ?>"><?php echo $set->games[$i]->scores[1]; ?></td>
	</tr>
	<?php endfor; ?>
</table>
<br/>
<?php endforeach; ?>

<br/>

<div>
<p><?=anchor("adhoc_matches/".$match->idMatch, "Back to View Match") ?></p>
</div>
