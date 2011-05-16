<<script type="text/javascript">
$(function() {
	$( "#p1div" ).combobox();
	$( "#p2div" ).combobox();
});
</script>
<?=form_open('team/processtc', array('class' => 'fstyle'));?>

  <p>Please enter information to create an Team:</p>
  <ol>
   <li>
    	<div class="ui-widget">
    		<label for='teamName'>Team name:<em>*</em></label>
    		<input id='teamName' name='teamName' type='text' />
    	</div>
    </li>
    <li>
    	<div id="p1div" class="ui-widget">
	      	<label for="player1">Player 1<em>*</em></label>
	      	 <?php if($idPlayerType == 4){?>
		    <select id="player1" name="player1">
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
    	<div id='p2div' class="ui-widget">
	    	<label for="player2">Player 2<em>*</em></label>
	      	<select id="player2" name="player2">
				<?php if ($players): ?>
					<?php foreach($players as $row): ?>
						<?php if ($currUserId != $row->idPlayer): ?>
						<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
		  	</select>
	  	</div>
    </li>
    <li>
    	<div class="ui-widget">
    		<label for='teamtag'>Tag (4 character max)<em>*</em></label>
    		<input id='teamtag' name='teamtag' type='text' max='4' />
    	</div>
    </li>
     <li>
    	<div class="ui-widget">
    		<label for='tagline'>Tagline<em>*</em></label>
    		<input id='tagline' name='tagline' type='text' value='We are not awesome enough to come up with a tagline.' />
    	</div>
    </li>
    <li id="send">
    	<button type="submit">Create Team</button>
    </li>
  </ol>

</form>