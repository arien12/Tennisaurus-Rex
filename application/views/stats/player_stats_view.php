<h1>Player Stats</h1>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    
// Load the Visualization API and the piechart package.
google.load('visualization', '1', {'packages':['corechart']});
      
// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawGameChart);
google.setOnLoadCallback(drawMatchChart);
      
// Callback that creates and populates a data table, 
// instantiates the pie chart, passes in the data and
// draws it.
function drawGameChart() {

	// Create our data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([
		['Games Won', <?php echo $gamesWon ?>],
		['Games Lost', <?php echo $gamesLost ?>]
	]);

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('game_chart_div'));
	chart.draw(data, {width: 400, height: 240});
}

//Callback that creates and populates a data table, 
//instantiates the pie chart, passes in the data and
//draws it.
function drawMatchChart() {

	// Create our data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([
		['Matches Won', <?php echo $matchesWon ?>],
		['Matches Lost', <?php echo $matchesLost ?>],
		['Matches Ongoing', <?php echo $matchesIncomplete ?>]
	]);

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('match_chart_div'));
	chart.draw(data, {width: 400, height: 240});
}
</script>

<h2>Match Stats</h2>
<div id="match_chart_div"></div>

<h2>Game Stats</h2>
<div id="game_chart_div"></div>


