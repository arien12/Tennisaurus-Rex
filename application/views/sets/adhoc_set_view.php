<h1><?=$teams[0]->name?> VS <?=$teams[1]->name?></h1>

<table class="setTable">
	<tr>
		<th colspan="3" class="setHeader">Set <?php echo $setCount ?></th>
	</tr>
	<tr>
		<th></th>
		<th><?php echo $teams[0]->name ?></th>
		<th><?php echo $teams[1]->name ?></th>
	</tr>
	<?php for ($i=0; $i < count($game_scores); $i++): ?>
	<tr>
		<th>Game <?php echo $i+1 ?></th>
		<td><?php echo $game_scores[$i][0] ?></td>
		<td><?php echo $game_scores[$i][1] ?></td>
	</tr>
	<?php endfor; ?>
</table>

<br/>

<div>
<p><?=anchor("adhoc_matches/".$match->idMatch, "Back to View Match")?></p>
</div>
