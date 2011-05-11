<h1>Create Tournament</h1>

<?=form_open('tournaments/tournament_insert', array('class' => 'fstyle'));?>

  <p>Please enter information to create new tournament:</p>
  <ol>
    <li>
      <label for="name">Name<em>*</em></label>
      <input id="name" />
    </li>
    <li>
      <label for="season">Season<em>*</em></label>
      <input id="season" />
    </li>
    <li>
    	<label for="name">Type<em>*</em></label>
	    <select>
			<?php if ($query->num_rows() > 0): ?>
				<?php foreach($query->results() as $row): ?>
					<option value="<?=$row->name?>"><?=$row->name?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
    </li>
    <li id="send">
    	<button type="submit" id="send">Create Tournament</button>
    </li>
  </ol>

</form>