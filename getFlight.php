<?php
$method = 'GET';
$url = 'http://www.azair.cz/azfin.php';
$data = array(
    'searchtype' => 'flexi', // *
    'isOneway' => 'return', // jeżeli w jedną stronę wówczas 'oneway'
    'srcAirport' => '[POZ]', //*porty wylotu, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'dstAirport' => '[MXP]', //*porty docelowe, w nawiasie kwadratowym, jeżeli tylko jedno lotnisko, jeżeli dodatkowe, wówczas (+lotnisko_2, lotnisko_3) etc
    'depdate' => '2019-05-16', //* dolny zakres daty
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

    $data = http_build_query($data, '', '&');
    $response = file_get_contents($url."?".$data, false);

echo $response;
?>
