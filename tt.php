<?php

function getOptions(){
	$string = file_get_contents("airport.json");
	$json_a = json_decode($string, true);

	for($i=0; $i<sizeof($json_a); $i++){
		echo '<option value="'.$json_a[$i]['code'].'">'.$json_a[$i]['code']. ' - '.$json_a[$i]['name'].'</option>';
	}
	
}

?>