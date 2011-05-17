<h1>Adhoc Matches</h1>
<p><?=anchor("adhoc_matches/adhoc_match_insert_view","Create Match")?></p>

<?php if (count($matchList) > 0): ?>
	<?php foreach($matchList as $row): ?>
		<div><?=$row['match']->idMatch?> -- <?=$row['teams'][1]->name?> VS <?=$row['teams'][2]->name?></div>
	<?php endforeach; ?>
<?php endif; ?>
