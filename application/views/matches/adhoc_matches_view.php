<h1>Adhoc Matches</h1>
<p><?=anchor("adhoc_matches/adhoc_match_insert_view","Create Match")?></p>
<ul>
<?php if ($matches): ?>
	<?php foreach($matches as $row): ?>
		<li><?=$row->idMatch?></li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>