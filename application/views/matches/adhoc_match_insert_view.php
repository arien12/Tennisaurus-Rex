<h1>Create Adhoc Match</h1>

<script>
	$(function() {
		$( "#player1_combobox" ).combobox();
		$( "#player2_combobox" ).combobox();
		$( "#team1_combobox" ).combobox();
		$( "#team2_combobox" ).combobox();
		$( "#tabs" ).tabs();
	});
</script>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Singles</a></li>
		<li><a href="#tabs-2">Doubles</a></li>
	</ul>
	<div id="tabs-1">
		  <?=form_open('matches/adhoc_match_insert', array('class' => 'fstyle'));?>
		  <p>Please enter information to create an adhoc singles match:</p>
		  <ol>
		    <li>
		    	<div class="ui-widget" id="player1_combobox">
			      	<label for="player1" id="test">Player 1<em>*</em></label>
				    <select id="player1">
				    	<option value="-1"></option>
						<?php if ($players): ?>
							<?php foreach($players as $row): ?>
								<?php if ($currPlayerId == $row->idPlayer): ?>
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
		    	<div class="ui-widget" id="player2_combobox">
			    	<label for="player2">Player 2<em>*</em></label>
			      	<select id="player2">
			      		<option value="-1"></option>
						<?php if ($players): ?>
							<?php foreach($players as $row): ?>
								<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
							<?php endforeach; ?>
						<?php endif; ?>
				  	</select>
			  	</div>
		    </li>
		    <li>
			    <label for="numOfSets"># of Sets: </label>
				<input type="text" id="numOfSets" value="3" class="numText"/>
		    </li>
		    <li>
			    <label for="numOfGames"># of Games Per Set: </label>
				<input type="text" id="numOfGames" value="3" class="numText"/>
		    </li>
		    <li>
			    <label for="court">Court: </label>
			      <select id="court">
			      	<option value="-1"></option>
					<?php if ($players): ?>
						<?php foreach($players as $row): ?>
							<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				  </select>
			</li>
		    <li id="send">
		    	<button type="submit">Create Singles Match</button>
		    </li>
		  </ol>
		  </form>
	</div>
	<div id="tabs-2">
		  <?=form_open('matches/adhoc_match_insert', array('class' => 'fstyle'));?>
		  <p>Please enter information to create an adhoc doubles match:</p>
		  <ol>
		    <li>
		    	<div class="ui-widget" id="team1_combobox">
			      	<label for="team1">Team 1<em>*</em></label>
				    <select id="team1">
				    	<option value="-1"></option>
						<?php if ($teams): ?>
							<?php foreach($teams as $row): ?>
								<option value="<?=$row->idTeam?>"><?=$row->name?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
		    </li>
		    <li>
		    	<div class="ui-widget" id="team2_combobox">
			    	<label for="team2">Team 2<em>*</em></label>
			      	<select id="team2">
			      		<option value="-1"></option>
						<?php if ($teams): ?>
							<?php foreach($teams as $row): ?>
								<option value="<?=$row->idTeam?>"><?=$row->name?></option>
							<?php endforeach; ?>
						<?php endif; ?>
				  	</select>
			  	</div>
		    </li>
		    <li>
			    <label for="numOfSets"># of Sets: </label>
				<input type="text" id="numOfSets" value="3" class="numText"/>
		    </li>
		    <li>
			    <label for="numOfGames"># of Games Per Set: </label>
				<input type="text" id="numOfGames" value="3" class="numText"/>
		    </li>
		    <li>
			    <label for="court">Court: </label>
			      <select id="court">
			      	<option value="-1"></option>
					<?php if ($players): ?>
						<?php foreach($players as $row): ?>
							<option value="<?=$row->idPlayer?>"><?=$row->name?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				  </select>
			</li>
		    <li id="send">
		    	<button type="submit">Create Doubles Match</button>
		    </li>
		  </ol>
		  </form>
	</div>
</div>