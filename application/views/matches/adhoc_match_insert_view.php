<h1>Create Adhoc Match</h1>

<?=form_open('matches/adhoc_match_insert', array('class' => 'fstyle'));?>

  <p>Please enter information to create an adhoc match:</p>
  <ol>
    <li>
      <label for="player1">Player 1<em>*</em></label>
      <input id="player1" />
    </li>
    <li>
      <label for="player2">Player 2<em>*</em></label>
      <input id="player2" />
    </li>
    <li id="send">
    	<button type="submit">Create Match</button>
    </li>
  </ol>

</form>