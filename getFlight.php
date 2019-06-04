<?php

include "dbHelper.php";

$srcAirport = $_POST['srcAirport'];
$dstAirport = $_POST['dstAirport'];
$depdate = $_POST['depdate'];
$arrdate = $_POST['arrdate'];
$minDaysStay = $_POST['minDaysStay'];
$maxDaysStay = $_POST['maxDaysStay'];
$infants = $_POST['infants'];
$children = $_POST['children'];
$adults = $_POST['adults'];
$maxChng = $_POST['maxChng'];
$samedep = $_POST['samedep'];
$samearr = $_POST['samearr'];
$wizzxclub = $_POST['wizzxclub'];
$nextday = $_POST['nextday'];
$supervolotea = $_POST['supervolotea'];
$reminder = $_POST['reminder'];
$reminderPrice = $_POST['reminderPrice'];

$filename = 'results/'.$_POST['filename'].'.txt';


$url = 'http://www.azair.cz/azfin.php?';
$data = array(
    'searchtype' => 'flexi', // *
    'isOneway' => 'return', // jeżeli w jedną stronę wówczas 'oneway'
    'srcAirport' => '['.$srcAirport.']', //*porty wylotu, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'dstAirport' => '['.$dstAirport.']', //*porty docelowe, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'depdate' => $depdate, //* dolny zakres daty
    'arrdate' => $arrdate, //* górny zakres daty
    'minDaysStay' => $minDaysStay, //* min ilość dni
    'maxDaysStay' => $maxDaysStay, //* max ilość dni
	
    'samedep' => $samedep, // opcjonalnie w razie braku wartość false - to samo lotnisko wylotu
    'samearr' => $samearr, // opcjonalnie w razie braku wartości false - to samo lotnisko przylotu
    'autoprice' => 'true', // opcjonalnie, aktualizacja cen
	
	//  przy braku jakiegokolwiek z trzech poniższych parametrów bierze domyślnie cenę dla jednego dorosłego
    'adults' => $adults, // opcjonalnie, liczba dorosłych
    'children' => $children, // opcjonalnie, liczba dzieci
    'infants' => $adults, // opcjonalnie, liczba niemowląt
    
	'maxChng' => $maxChng, // opcjonalnie, liczba przesiadek
	'currency' => 'PLN', // opcjonalnie, domyślnie euroski, do wyboru - to samo
	'lang' => 'pl', // opcjonalnie, domyślnie angielski, do wyboru - nie podaje innych języków bo to tego bliku klient nie będzie miał dostępu
   
    'wizzxclub' => $wizzxclub, // opcjonalnie, z kartą wizz discouny
    'supervolotea' => $supervolotea, // opcjonalnie, z kartą voloytea
    'nextday' => $nextday, // opcjonalnie, przelot następnego dnia (przy przysiadkach)
 
    );


// ODNALEZIENIE STRONY O PODANYCH W ANDROIDZIE PARAMETRACH WEJŚCIOWYCH

$params = http_build_query($data, '', '&'); // transformacja tablicy do parametrów łączonych &
$requestUrl = $url.$params; //połączenie urlu z parametrami - link w postaci get

	$curl = curl_init(); //inicjalizacja żądania
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1, // oczekiwanie na odpowiedź zwrotną
			CURLOPT_URL => $requestUrl, // przypisanie adresu url
		]);
		
	$response = curl_exec($curl); // wykonanie żądania
	curl_close($curl); // zamknięcie żądania curl i wyczyszczenie zasobów

// ZAPIS PARAMETRÓW DO BAZY
if($reminder == "true"){
	$conn = connectDB();
	insertToSearchDB($srcAirport,$dstAirport,$minDaysStay,$maxDaysStay,$infants,$children,$adults,$depdate,$arrdate,$samedep,$samearr,$wizzxclub,$supervolotea,$reminderPrice,$maxChng,$nextday,$conn);
	$conn->close();
}

// ZAPIS DO PLIKU

$file = fopen($filename, 'w'); // otwarcie pliku z uprawieniami do zapisu
fwrite($file, $response); // zapis odpowiedzi do pliku
fclose($file); // zamknięcie pliku

?>