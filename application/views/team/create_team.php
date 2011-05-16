<?=form_open('team/processtc', array('class' => 'fstyle'));?>

  <p>Please enter information to create an Team:</p>
  <ol>
    <li>
    	<div class="ui-widget">
	      	<label for="player1">Player 1<em>*</em></label>
	      	 <?php if($this->session->userdata(idPlayerType) == 3){?>
		    <select id="player1">
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
			 <?php }else{?>
    				<input type='text' id="player1" disabled="disabled" value="<?=$name?>" >
    		<?php }?>
		</div>
    </li>
    <li>
    	<div class="ui-widget">
	    	<label for="player2">Player 2<em>*</em></label>
	      	<select id="player2">
				<?php if ($players): ?>
					<?php foreach($players as $row): ?>
						<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
					<?php endforeach; ?>
				<?php endif; ?>
		  	</select>
	  	</div>
    </li>
    <li>
    	<div class="ui-widget">
    		<label for='teamtag'>Tag (4 character max)<em>*</em></label>
    		<input id='teamtag' type='text' max='4' />
    	</div>
    </li>
     <li>
    	<div class="ui-widget">
    		<label for='tagline'>Tagline<em>*</em></label>
    		<input id='tagline' type='text' value='We are not awesome enough to come up with a tagline.' />
    	</div>
    </li>
    <li id="send">
    	<button type="submit">Create Team</button>
    </li>
  </ol>

</form>