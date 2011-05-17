<h1>Adhoc Matches</h1>
<p><?=anchor("adhoc_matches/adhoc_match_insert_view","Create Match")?></p>
<ul>
<?php if (count($matchList) > 0): ?>
	<?php foreach($matchList as $row): ?>
		<li><?=$row['match']->idMatch?></li>
		<li><?=$row['teams'][1]->name?></li>
		<li><?=$row['teams'][2]->name?></li>
		<li>BREAK</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>