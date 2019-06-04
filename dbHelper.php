<?php

function connectDB(){
$servername = "sql.aroslav.nazwa.pl";
$username = "aroslav_loty";
$password = "Arek1996!@";
$dbname = "aroslav_loty";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
	if ($conn->connect_error) {
		die("Błąd połączenia z bazą: " . $conn->connect_error);
	} else {
		return $conn;
	}
}

function insertToSearchDB($srcAirport,$dstAirport,$minDaysStay,$maxDaysStay,$infants,$children,$adults,$depdate,$arrdate,$samedep,$samearr,$wizzxclub,$supervolotea,$reminderPrice,$maxChng,$nextday,$conn){
		$sql = "INSERT INTO `aroslav_loty`.`search_params`
					(
					`srcAirport`,
					`dstAirport`,
					`minDaysStay`,
					`maxDaysStay`,
					`infants`,
					`children`,
					`adults`,
					`maxChng`,
					`depdate`,
					`arrdate`,
					`samedep`,
					`samearr`,
					`wizzxclub`,
					`nextday`,
					`supervolotea`,
					`request_to_cron`,
					`cron`,
					`reminder_price`
					)
					VALUES
					(
					'".$srcAirport."',
					'".$dstAirport."',
					".$minDaysStay.",
					".$maxDaysStay.",
					".$infants.",
					".$children.",
					".$adults.",
					".$maxChng.",
					'".$depdate."',
					'".$arrdate."',
					'".$samedep."',
					'".$samearr."',
					'".$wizzxclub."',
					'".$nextday."',
					'".$supervolotea."',
					1,
					0,".
					$reminderPrice.")";
					
		var_dump($sql);			
					
		if ($conn->query($sql) === TRUE) {
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	
}

function selectWaitingAlert($conn){
	$i = 0;
	$sql = "SELECT * FROM search_params where request_to_cron = 1 AND cron = 0";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
		$results['id'][$i] = $row['id'];
		$results['srcAirport'][$i] = $row['srcAirport'];
		$results['dstAirport'][$i] = $row['dstAirport'];
		$results['depdate'][$i] = $row['depdate'];
		$results['arrdate'][$i] = $row['arrdate'];
		$results['minDaysStay'][$i] = $row['minDaysStay'];
		$results['maxDaysStay'][$i] = $row['maxDaysStay'];
		$results['infants'][$i] = $row['infants'];
		$results['children'][$i] = $row['children'];
		$results['adults'][$i] = $row['adults'];
		$results['maxChng'][$i] = $row['maxChng'];
		$results['samedep'][$i] = $row['samedep'];
		$results['samearr'][$i] = $row['samearr'];
		$results['wizzxclub'][$i] = $row['wizzxclub'];
		$results['nextday'][$i] = $row['nextday'];
		$results['supervolotea'][$i] = $row['supervolotea'];
		$results['reminderPrice'][$i] = $row['reminder_price'];
		$i++;
    }
	return $results;
	} else {
		echo "Brak oczekujących";
	}
};

function deleteWaitingAlert($conn){
	
}

function acceptWaitingAlert($id,$conn){
	$sql = "UPDATE `search_params` SET `cron` = '1' WHERE id = ".$id;

	if ($conn->query($sql) === TRUE) {
		echo "Rekord poprawnie zaktualizowany";
	} else {
		echo "Problem z aktualizacją rekordu: " . $conn->error;
	}

}

?>