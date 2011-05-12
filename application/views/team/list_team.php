<?php
foreach($teams as $team){
	echo '<div >';
	echo anchor('team/'.$team->idTeam, $team->name);
	echo '</div>';
	echo '<br>'	;		
}
?>