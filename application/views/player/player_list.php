<?php
foreach($players as $player){
	echo '<div >';
	echo anchor('player/'.$player->idPlayer, $player->name);
	echo '</div>';
	echo '<br>'	;		
}
?>