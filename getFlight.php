<?php

$url = 'http://www.azair.cz/azfin.php?';
$data = array(
    'searchtype' => 'flexi', // *
    'isOneway' => 'return', // jeżeli w jedną stronę wówczas 'oneway'
    'srcAirport' => '[POZ] (+WMI)', //*porty wylotu, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'dstAirport' => '[MXP]', //*porty docelowe, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'depdate' => '2019-05-18', //* dolny zakres daty
    'arrdate' => '2020-03-31', //* górny zakres daty
    'minDaysStay' => '2', //* min ilość dni
    'maxDaysStay' => '3', //* max ilość dni
	
    'samedep' => 'true', // opcjonalnie w razie braku wartość false - to samo lotnisko wylotu
    'samearr' => 'true', // opcjonalnie w razie braku wartości false - to samo lotnisko przylotu
    'autoprice' => 'true', // opcjonalnie, aktualizacja cen
	
	//  przy braku jakiegokolwiek z trzech poniższych parametrów bierze domyślnie cenę dla jednego dorosłego
    'adults' => '1', // opcjonalnie, liczba dorosłych
//  'children' => '0', // opcjonalnie, liczba dzieci
//  'infants' => '0', // opcjonalnie, liczba niemowląt
    
//	'maxChng' => '0', // opcjonalnie, liczba przesiadek
	'currency' => 'PLN', // opcjonalnie, domyślnie euroski, do wyboru - to samo
	'lang' => 'pl', // opcjonalnie, domyślnie angielski, do wyboru - nie podaje innych języków bo to tego bliku klient nie będzie miał dostępu
   
//   'wizzxclub' => 'true', // opcjonalnie, z kartą wizz discouny
//   'supervolotea' => 'true', // opcjonalnie, z kartą voloytea
//   'nextday' => 'true', // opcjonalnie, przelot następnego dnia (przy przysiadkach)
// 
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


// ZAPIS DO PLIKU

$file = fopen('temp.txt', 'w'); // otwarcie pliku z uprawieniami do zapisu
fwrite($file, $response); // zapis odpowiedzi do pliku
fclose($file); // zamknięcie pliku
?>