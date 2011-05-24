<h1><?=$teams[0]->name?> VS <?=$teams[1]->name?></h1>


<table class="matchTable">
	<tr>
		<th></th>
		<?php for ($i=1; $i <= count($match->sets); $i++): ?>
			<th>S<?php echo $i ?></th>
		<?php endfor; ?>
		<th>Total</th>
	</tr>
	<tr>
		<th><?=$teams[0]->name?></th>
		<?php foreach($sets as $set): ?>
			<td><?php echo $set[0] ?></td>
		<?php endforeach; ?>
		<td class="total win"><?php echo $total[0] ?></td>
	</tr>
	<tr>
		<th><?=$teams[1]->name?></th>
		<?php foreach($sets as $set): ?>
			<td><?php echo $set[1] ?></td>
		<?php endforeach; ?>
		<td class="total win"><?php echo $total[1] ?></td>
	</tr>
</table>


<br/>
<div>
<p><?=anchor("adhoc_matches/add_game_view/".$match->idMatch, "Add New Game")?></p>

<p><?=anchor("adhoc_matches", "Back to Adhoc Match List")?></p>
</div>
