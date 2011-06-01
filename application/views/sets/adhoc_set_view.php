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
		<th>Game <?php echo $i+1; ?></th>
		<td><?php echo $set->games[$i][0]; ?></td>
		<td><?php echo $set->games[$i][1]; ?></td>
	</tr>
	<?php endfor; ?>
</table>
<br/>
<?php endforeach; ?>

<br/>

<div>
<p><?=anchor("adhoc_matches/".$match->idMatch, "Back to View Match")?></p>
</div>
