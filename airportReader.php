<?php

$i = 0;
$j = 0;

$fileLon = explode("\n", file_get_contents('GlobalAirportDatabase.txt'));
echo '<pre>';

	foreach($fileLon as $lon){
		$longitude = explode(':', $lon);
		$listOf[$j]['code'] = trim($longitude[1]);
		$listOf[$j]['latitude'] = (double)trim($longitude[14]);
		$listOf[$j]['longitude'] = (double)trim($longitude[15]);
		$j++;
	}
	

$file = explode("\n", file_get_contents('lotniska.txt'));
echo '<pre>';
$row = explode("\r", $file[0]);

	foreach($row as $airports){
		$k = 0;
		$airport = explode('-', $airports);
		$listOfAirports[$i]['code'] = trim($airport[0]);
		$listOfAirports[$i]['name'] = trim($airport[1]);
		
		for($k = 0; $k<sizeof($listOf); $k++){
			if($listOf[$k]['code'] === $listOfAirports[$i]['code']){
				$listOfAirports[$i]['latitude'] = $listOf[$k]['latitude'];
				$listOfAirports[$i]['longitude'] = $listOf[$k]['longitude'];
			} 
		}

			$i++;
	}
	
$z = 0;
	
for($o = 0; $o<sizeof($listOfAirports); $o++){
		if(sizeof($listOfAirports[$o]) == 4){
			$finalList[$z] = $listOfAirports[$o];
			$z++;
		}
}
	
var_dump($finalList);


	

$response = json_encode($finalList);
$file = fopen('airport.json', 'w'); // otwarcie pliku z uprawieniami do zapisu
fwrite($file, $response);


?>