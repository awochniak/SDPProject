<?php

require('simple_html_dom.php');
$html = file_get_html("temp.txt");

$i = 0;
$tableOfResults = array(); // to będzie obiekt z lotami
$host = 'http://www.azair.cz/'; 

echo '<pre>';

foreach($html->find('input[name=adults]') as $adult){
	$adults = $adult->getAttribute('value');
}

foreach($html->find('input[name=children]') as $child){
	$children = $child->getAttribute('value');
}

foreach($html->find('input[name=infants]') as $infant){
	$infants = $infant->getAttribute('value');
}

$list = $html->find('div.list'); // zebranie danych z div'a lista - tylko jeden takich div

// kazdy div text jest równy jednemu wierszowi wyszukiwarce dlatego wrzucamy to w pętle
foreach($list[0]->find('div.text') as $text) {
	
	$j = 0;
	$k = 0;
	$l = 0;
	$m = 0;
	$n = 0;
	$o = 0;
	$p = 0;
	$q = 0;
	$r = 0;
	$s = 0;
	
	$flagOfDeparture = $text->find('span.tam'); //odnalezienie flagi dla wylotu
	$flagOfArrival = $text->find('span.sem'); //odnalezienie flagi dla powrotu
	
	$departureDateObject = explode('&nbsp;',$flagOfDeparture[0]->next_sibling()->plaintext); //przypisanie daty do zmiennej
	$arrivalDateObject = explode('&nbsp;',$flagOfArrival[0]->next_sibling()->plaintext); //przypisanie daty do zmiennej
	
	$dateOfDeparture = rtrim($departureDateObject[1]);
	$dateOfArrival = rtrim($arrivalDateObject[1]);
	
	$start = substr($flagOfDeparture[0]->next_sibling()->next_sibling()->firstChild()->next_sibling()->plaintext,0,3); //przypisanie miejsca startowego do zmiennej
	$destination = substr($flagOfArrival[0]->next_sibling()->next_sibling()->firstChild()->next_sibling()->plaintext,0,3); //przypisanie miejsca docelowego do zmiennej
	$duration = $flagOfDeparture[0]->next_sibling()->next_sibling()->next_sibling()->next_sibling()->plaintext;
	
	$timestampArrival = strtotime($dateOfArrival); //wyciągniecie timestampa z daty w celu pobrania dnia tygodnia
	$timestampDeparture = strtotime($dateOfDeparture); //wyciągniecie timestampa z daty w celu pobrania dnia tygodnia
		
	$dayOfArrivalShortcut = date('N', $timestampArrival);
	$dayOfDepartureShortcut = date('N', $timestampDeparture);
	
	$dayOfArrival = getDay($dayOfArrivalShortcut);
	$dayOfDeparture = getDay($dayOfDepartureShortcut);
		
	$tableOfResults[$i]['airportOfDeparture'] = $start;
	$tableOfResults[$i]['dateOfDeparture'] = $dateOfDeparture;
	$tableOfResults[$i]['dayOfDeparture'] = $dayOfDeparture;
	
	$tableOfResults[$i]['aiportOfArrival'] = $destination;
	$tableOfResults[$i]['dateOfArrival'] = $dateOfArrival;
	$tableOfResults[$i]['dayOfArrival'] = $dayOfArrival;
	
	$tableOfResults[$i]['infants'] = $infants;
	$tableOfResults[$i]['children'] = $children;
	$tableOfResults[$i]['adults'] = $adults;
	
	$tableOfResults[$i]['duration'] = $duration;
		
	$details = $text->find('div.detail'); //wyciagniecie pozostalych szczegolow lotu

	foreach($text->find('div.totalPrice') as $divPrice){
		foreach($divPrice->find('span.tp') as $spanPrice){
			$priceObject = explode(' ',$spanPrice->plaintext);
			$totalPrice = (int)$priceObject[0];
			$tableOfResults[$i]['totalPrice'] = $totalPrice;
		}
	}

	//WYLOTY
	foreach($details[0]->find('span.from') as $detailsFrom){
		$departureHour =  explode('&nbsp;', $detailsFrom->plaintext);
		$tableOfResults[$i]['flightTo'][$k]['departureHour'] = $departureHour[1];
		//var_dump($departureHour[0]);
		foreach($detailsFrom->find('span.code') as $detailsFromCode){
			$departureCode = substr($detailsFromCode->plaintext,0, 3);
			$tableOfResults[$i]['flightTo'][$k]['departureCode'] = $departureCode;
		$k++;
		}
	}
	
	foreach($details[0]->find('span.to') as $detailsTo){
		$arrivalHour =  explode('&nbsp;', $detailsTo->plaintext);
		$tableOfResults[$i]['flightTo'][$j]['arrivalHour'] = $arrivalHour[0];
		
		foreach($detailsTo->find('span.code') as $detailsToCode){
			$arrivalCode = substr($detailsToCode->plaintext,0, 3);
			$tableOfResults[$i]['flightTo'][$j]['arrivalCode'] = $arrivalCode;
			$flightNumber = $detailsToCode->next_sibling()->plaintext;
			$tableOfResults[$i]['flightTo'][$j]['flightNumber'] = trim($flightNumber);
			$j++;
		}	
	}
		
	foreach($details[0]->find('span.airline') as $detailsAirlines){
		$airline = $detailsAirlines->plaintext;
		$tableOfResults[$i]['flightTo'][$p]['airline'] = trim($airline);
		$p++;
	}

	foreach($details[0]->find('span.legPrice') as $legPrice){
		$subPrice =  explode(' ',$legPrice->plaintext);
		$partPrice = (int)$subPrice[0];
		$tableOfResults[$i]['flightTo'][$n]['subprice'] = $partPrice;
		$n++;
	}
	
	foreach($details[0]->find('a.affPopUp') as $detailsURL){
		$url = $host.$detailsURL->getAttribute('href');
		$tableOfResults[$i]['flightTo'][$r]['url'] = $url;
		$r++;
	}
	
	//PRZYLOTY
	foreach($details[1]->find('span.from') as $detailsFrom){
		$departureHour =  explode('&nbsp;', $detailsFrom->plaintext);
		$tableOfResults[$i]['flightFrom'][$l]['departureHour'] = $departureHour[1];
		
		foreach($detailsFrom->find('span.code') as $detailsFromCode){
			$departureCode = substr($detailsFromCode->plaintext,0, 3);
			$tableOfResults[$i]['flightFrom'][$l]['departureCode'] = $departureCode;
			$flightNumber = $detailsToCode->next_sibling()->plaintext;
			$tableOfResults[$i]['flightFrom'][$l]['flightNumber'] = trim($flightNumber);
		$l++;
		}
	}
	
	foreach($details[1]->find('span.to') as $detailsTo){
		$arrivalHour =  explode('&nbsp;', $detailsTo->plaintext);
		$tableOfResults[$i]['flightFrom'][$m]['arrivalHour'] = $arrivalHour[0];
		
		foreach($detailsTo->find('span.code') as $detailsToCode){
			$arrivalCode = substr($detailsToCode->plaintext,0, 3);
			$tableOfResults[$i]['flightFrom'][$m]['arrivalCode'] = $arrivalCode;
		$m++;
		}		
	}
	
	foreach($details[1]->find('span.airline') as $detailsAirlines){
		$airline = $detailsAirlines->plaintext;
		$tableOfResults[$i]['flightFrom'][$q]['airline'] = trim($airline);
		$q++;
	}

	foreach($details[1]->find('span.legPrice') as $legPrice){
		$subPrice =  explode(' ',$legPrice->plaintext);
		$partPrice = (int)$subPrice[0];
		$tableOfResults[$i]['flightFrom'][$o]['subprice'] = $partPrice;
		$o++;
	}
	
	foreach($details[1]->find('a.affPopUp') as $detailsURL){
		$url = $host.$detailsURL->getAttribute('href');
		$tableOfResults[$i]['flightTo'][$s]['url'] = $url;
		$s++;
	}
	
	$tableOfResults[$i]['totalPrice'] = $totalPrice;
	$i++;
}
echo json_encode($tableOfResults);

function getDay($date){
	switch ($date)
	{
		case 1:
		  return "Poniedziałek";
		  break;

		case 2:
		  return "Wtorek";
		  break;

		case 3:
		  return "Środa";
		  break;

		case 4:
		  return "Czwartek";
		  break;

		case 5:
		  return "Piątek";
		  break;
		  
		case 6:
		  return "Sobota";
		  break;
		 
		case 7:
		  return "Niedziela";
		  break;		  
	}
}
?>
