<h1><?=$teams[0]->name?> VS <?=$teams[1]->name?></h1>

<p>First to <?php echo $match->numberOfGames?> games. First to <?php echo $match->numberOfSets?> sets.</p>

<table class="matchTable">
	<tr>
		<th></th>
		<?php for ($i=1; $i <= count($match->sets); $i++): ?>
			<th><?=anchor("adhoc_matches/sets/".$match->idMatch."/".$match->sets[$i-1]->idSet, "S".$i) ?></th>
		<?php endfor; ?>
		<th><?=anchor("adhoc_matches/sets/".$match->idMatch, 'Total') ?></th>
	</tr>
	<tr>
		<th><?=$teams[0]->name?></th>
		<?php foreach($sets as $set): ?>
			<td><?php echo $set[0] ?></td>
		<?php endforeach; ?>
		<td class="total <?php if (($isMatchCompleted) && ($winner->idTeam==$teams[0]->idTeam)):?>winner<?php elseif($isMatchCompleted):?>loser<?php endif?>"><?php echo $total[0] ?></td>
	</tr>
	<tr>
		<th><?=$teams[1]->name?></th>
		<?php foreach($sets as $set): ?>
			<td><?php echo $set[1] ?></td>
		<?php endforeach; ?>
		<td class="total <?php if (($isMatchCompleted) && ($winner->idTeam==$teams[1]->idTeam)):?>winner<?php elseif($isMatchCompleted):?>loser<?php endif?>"><?php echo $total[1] ?></td>
	</tr>
</table>


<br/>
<div>

<?php if (!$isMatchCompleted):?>
<p><?=anchor("adhoc_matches/add_game_view/".$match->idMatch, "Add New Game")?></p>
<?php endif ?>

<p><?=anchor("adhoc_matches", "Back to Adhoc Match List")?></p>
</div>
