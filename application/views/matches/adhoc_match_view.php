<h1><?=$teams[0]->name?> VS <?=$teams[1]->name?></h1>

<table class="matchTable">
	<tr>
		<th></th>
		<th>S1</th>
		<th>S2</th>
		<th>S3</th>
		<th>Total</th>
	</tr>
	<tr>
		<th><?=$teams[0]->name?></th>
		<td>3</td>
		<td>3</td>
		<td>2</td>
		<td class="total winner">2</td>
	</tr>
	<tr>
		<th><?=$teams[1]->name?></th>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td class="total loser">0</td>
	</tr>
</table>

<br/>
<div>
<p><?=anchor("adhoc_matches/add_game_view/".$match->idMatch, "Add New Game")?></p>

<p><?=anchor("adhoc_matches", "Back to Adhoc Match List")?></p>
</div>
