<h1>Create Tournament</h1>
<p>Form to create new tournament goes here.</p>
<?=form_open('tournaments/tournament_insert');?>
<p>Name: <input type="text" name="name" /></p>
<p>Type: 
<select>
<?php if ($query->num_rows() > 0): ?>
	<?php foreach($query->results() as $row): ?>
		<option value="<?=$row->name?>"><?=$row->name?></option>
	<?php endforeach; ?>
<?php endif; ?>
</select>
</p>
</form>