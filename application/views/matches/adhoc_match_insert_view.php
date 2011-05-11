<h1>Create Adhoc Match</h1>

<?=form_open('matches/adhoc_match_insert', array('class' => 'fstyle'));?>

  <p>Please enter information to create an adhoc match:</p>
  <ol>
    <li>
    	<div class="ui-widget">
	      	<label for="player1">Player 1<em>*</em></label>
		    <select id="combobox">
				<?php if ($players): ?>
					<?php foreach($players as $row): ?>
						<?php if ($currUserId == $row->idPlayer): ?>
							<option selected="selected" value="<?=$row->idPlayer?>"><?=$row->name?></option>
						<?php else: ?>
							<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
    </li>
    <li>
    	<div class="ui-widget">
	    	<label for="player2">Player 2<em>*</em></label>
	      	<select id="combobox2">
				<?php if ($players): ?>
					<?php foreach($players as $row): ?>
						<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
					<?php endforeach; ?>
				<?php endif; ?>
		  	</select>
	  	</div>
    </li>
    <li id="send">
    	<button type="submit">Create Match</button>
    </li>
  </ol>

</form>