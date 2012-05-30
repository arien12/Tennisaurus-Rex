<script>
	$(function() {
		$( "#player1_combobox" ).combobox();
		$( "#player2_combobox" ).combobox();
		$( "#team1_combobox" ).combobox();
		$( "#team2_combobox" ).combobox();
		$( "#tabs" ).tabs();
	});
</script>

<h1>Create Adhoc Match</h1>

<?php echo validation_errors(); ?>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Singles</a></li>
		<li><a href="#tabs-2">Doubles</a></li>
	</ul>
	<div id="tabs-1">
		  <?=form_open('adhoc_matches/insert_singles_match', array('class' => 'fstyle'));?>
		  <p>Please enter information to create an adhoc singles match:</p>
		  <ol>
		    <li>
		    	<div class="ui-widget" id="player1_combobox">
			      	<label for="player1">Player 1<em>*</em></label>
				    <select id="player1" name="player1">
				    	<option value="-1"></option>
						<?php if ($players): ?>
							<?php foreach($players as $row): ?>
								<?php if ($currTeamId == $row->idTeam): ?>
									<option selected="selected" value="<?=$row->idTeam?>"><?=$row->name?></option>
								<?php else: ?>
									<option value="<?=$row->idTeam?>"><?=$row->name?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
		    </li>
		    <li>
		    	<div class="ui-widget" id="player2_combobox">
			    	<label for="player2">Player 2<em>*</em></label>
			      	<select id="player2" name="player2">
			      		<option value="-1"></option>
						<?php if ($players): ?>
							<?php foreach($players as $row): ?>
								<option value="<?=$row->idTeam?>"><?=$row->name?></option>
							<?php endforeach; ?>
						<?php endif; ?>
				  	</select>
			  	</div>
		    </li>
		    <li>
			    <label for="numOfSets">First to how many sets?<em>*</em></label>
			    <select id="numOfSets" name="numOfSets">
			    	<option value="1" selected="selected">1</option>
			      	<option value="2">2</option>
			      	<option value="3">3</option>
				</select>
		    </li>
		    <li>
			    <label for="numOfGames">First to how many games?<em>*</em></label>
				<select id="numOfGames" name="numOfGames">
			    	<option value="1">1</option>
			      	<option value="2" selected="selected">2</option>
			      	<option value="3">3</option>
			      	<option value="4">4</option>
			      	<option value="5">5</option>
			      	<option value="6">6</option>
				</select>
		    </li>
		    <li>
		    	<label for="winByTwo">Must win by two games?</label>
		    	<input type="checkbox" id="winByTwo" checked="checked" />
		    </li>
		    <li>
			    <label for="court">Court: </label>
			      <select id="court" name="court">
			      	<option value="-1"></option>
					<?php if ($players): ?>
						<?php foreach($players as $row): ?>
							<option value="<?=$row->idTeam?>"><?=$row->name?></option>
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
		  <?=form_open('adhoc_matches/insert_team_match', array('class' => 'fstyle'));?>
		  <p>Please enter information to create an adhoc doubles match:</p>
		  <ol>
		    <li>
		    	<div class="ui-widget" id="team1_combobox">
			      	<label for="team1">Team 1<em>*</em></label>
				    <select id="team1" name="team1">
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
			      	<select id="team2" name="team2">
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
			    <label for="numOfSets">First to how many sets?<em>*</em></label>
			    <select id="numOfSets" name="numOfSets">
			    	<option value="1" selected="selected">1</option>
			      	<option value="2">2</option>
			      	<option value="3">3</option>
				</select>
		    </li>
		    <li>
			    <label for="numOfGames">First to how many games?<em>*</em></label>
				<select id="numOfGames" name="numOfGames">
			    	<option value="1">1</option>
			      	<option value="2" selected="selected">2</option>
			      	<option value="3">3</option>
			      	<option value="4">4</option>
			      	<option value="5">5</option>
			      	<option value="6">6</option>
				</select>
		    </li>
		    <li>
		    	<label for="winByTwo">Must win by two games?</label>
		    	<input type="checkbox" id="winByTwo" checked="checked" />
		    </li>
		    <li>
			    <label for="court">Court: </label>
			      <select id="court" name="court">
			      	<option value="-1"></option>
					<?php if ($players): ?>
						<?php foreach($players as $row): ?>
							<option value="<?=$row->idTeam?>"><?=$row->name?></option>
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