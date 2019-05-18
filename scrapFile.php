<?php

require('simple_html_dom.php');
$html = file_get_html("temp.txt");

$i = 0;
$tableOfResults = array(); // to będzie obiekt z lotami

echo '<pre>';

$list = $html->find('div.list'); // zebranie danych z div'a lista - tylko jeden takich div

// kazdy div text jest równy jednemu wierszowi wyszukiwarce dlatego wrzucamy to w pętle
foreach($list[0]->find('div.text') as $text) {
	
	$k = 0;
	
	$flagOfDeparture = $text->find('span.tam'); //odnalezienie flagi dla wylotu
	$flagOfArrival = $text->find('span.sem'); //odnalezienie flagi dla powrotu
	
	$dateOfDeparture = $flagOfDeparture[0]->next_sibling()->plaintext; //przypisanie daty do zmiennej
	$dateOfArrival = $flagOfArrival[0]->next_sibling()->plaintext; //przypisanie daty do zmiennej
	
	$start = substr($flagOfDeparture[0]->next_sibling()->next_sibling()->firstChild()->next_sibling()->plaintext,0,3); //przypisanie miejsca startowego do zmiennej
	$destination = substr($flagOfArrival[0]->next_sibling()->next_sibling()->firstChild()->next_sibling()->plaintext,0,3); //przypisanie miejsca docelowego do zmiennej
	$duration = $flagOfDeparture[0]->next_sibling()->next_sibling()->next_sibling()->next_sibling()->plaintext;
		
	$tableOfResults[$i]['dateOfDeparture'] = $dateOfDeparture;
	$tableOfResults[$i]['dateOfArrival'] = $dateOfArrival;
	$tableOfResults[$i]['start'] = $start;
	$tableOfResults[$i]['destination'] = $destination;
	$tableOfResults[$i]['duration'] = $duration;
	
	//echo '<b>Lot nr:'.$i.'</b><br/>';
	//echo 'Data wylotu: '.$dateOfDeparture.'</br>'; // wydrukowanie daty wylotu
	//echo 'Data powrotu: '.$dateOfArrival.'</br></br>'; // wydrukowanie daty powrotu
	
	$details = $text->find('div.detail'); //wyciagniecie pozostalych szczegolow lotu

	// echo 'WAW - MED<br/><br/>'; 
	
	// po przejrzeniu kodu w ramach jednego diva text mamy dwa detailsy, jeden z wylotami, drugi z przylotami
	
	//WYLOTY
	foreach($details[0]->find('span.from') as $detailsFrom){
	//	echo 'Przesiadka nr: '.$k.'<br/>';		
		$departureHour =  substr($detailsFrom->plaintext,8,5);
		$tableOfResults[$i]['flightTo'][$k]['departureHour'] = $departureHour;
	//	echo '<b>Godzina: </b>'.$departureHour.'</br>';
		
		foreach($detailsFrom->find('span.code') as $detailsFromCode){
			$departureCode = substr($detailsFromCode->plaintext,0, 3);
			$tableOfResults[$i]['flightTo'][$k]['departureCode'] = $departureCode;

		//	echo '<b>Z: </b>'.$departureCode.'<br/>';
		$k++;
		}
	//	echo '<br/>';
	}
	
	// echo '</br>';
	$i++;
}
		var_dump($tableOfResults);

?>
