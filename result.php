<?php

$airportFile = file_get_contents("airport.json");
$airports = json_decode($airportFile, true);

$result = 'results/'.$_GET['result'].'.json';

$file = @file_get_contents($result);

if($file == false){
	
	echo '<div class="container">
		<div class="row">
			<div class="col-sm">
				<div class="alert alert-info" role="alert">
					<center>
						<img src="sad.png" height="5%"><br/>
						<p><h6>Dla wskazanych parametrów nie udało się odnaleźć żadnych wyników. </p><p>Proszę spróbować ponownie.</p></h6>
						<a href="http://arek-loty.pl/projekt/" class="btn btn-danger">Powrót</a>
					</center>
				</div>
			</div>
		</div>';
	
} else {

	$flights = json_decode($file, true);



	echo'
	<div class="container">
			<div class="row">
				<div class="col-sm">
					<div class="alert btn-info" role="alert">
						<div class="row">
							<div class="col-sm-9">
								<h6><b>LOT: '.$flights[0]['airportOfDeparture'].' - '.$flights[0]['aiportOfArrival'].'
									<br/>
									NIEMOWLĄT: '.$flights[0]['infants'].', 
									DZIECI: '.$flights[0]['children'].', 
									DOROSŁYCH: '.$flights[0]['adults'].'</b></h6>
							</div>
							<div class="col-sm-3">
								<a class="btn btn-secondary btn-block" href="http://www.arek-loty.pl/projekt">Nowe wyszukiwanie</a>
							</div>
						</div>
					</div>';

						for($i=0; $i<sizeof($flights); $i++){
							echo '<div class="alert alert-info trn" role="alert">
									<div class="row">
										<div class="col-sm-3">';
										
							echo 			'<b>Lotnisko wylotu:</b><br/>'.$flights[$i]['airportOfDeparture'].' - ';
										
											for($k=0; $k<sizeof($airports); $k++){
												if($airports[$k]['code'] == $flights[$i]['airportOfDeparture']){
							echo 					$airports[$k]['name'];
												}
											}
											
							echo 			'<br/>';
										
							echo			'<b>Lotnisko przylotu</b><br/>'.$flights[$i]['aiportOfArrival']. ' - ';
											
											for($k=0; $k<sizeof($airports); $k++){
												if($airports[$k]['code'] == $flights[$i]['aiportOfArrival']){
							echo 					$airports[$k]['name'];
												}
											}
										
							echo '		</div>
							
										<div class="col-sm-3">';
							echo 			'<b>Data wylotu </b><br/>'.$flights[$i]['dayOfDeparture'].', '.$flights[$i]['dateOfDeparture'].'</br>';
							echo 			'<b>Data przylotu: </b><br/>'.$flights[$i]['dayOfArrival'].', '.$flights[$i]['dateOfArrival'];
							
							echo '		</div>
							
										<div class="col-sm-4">';
							echo 			'<b>Czas trwania / przesiadki </b></br>';
							echo 			$flights[$i]['duration'];
							echo 			'</br><button type="button" class="btn btn-info" id="'.$i.'">Pokaż szczegóły</button>';
							echo '		</div>
										<div class="col-sm-2 align="right">';
							echo 			'<b>Cena</br><h2>';
							echo 			$flights[$i]['totalPrice'].' zł';
							echo '		</h2></b></div>
									</div>';

							echo '	<div class="row" id="rowFF'.$i.'" style="display: none" name="hidden">
										<div class="col-sm"><br/>
											<div class="alert alert-secondary" role="alert">
											<b>Loty do miejsca docelowego</b><br/>';
											
											for($k=0; $k<sizeof($flights[$i]['flightTo']);$k++){
							echo 				'<div class="alert alert-light" role="alert">';
							echo 					'<div class="row">';
							echo 					'<div class="col-sm-4">';
							echo						$flights[$i]['flightTo'][$k]['departureHour'];
							echo 						' - <b>';
							echo 						$flights[$i]['flightTo'][$k]['departureCode'];
							echo 						'</b>, ';
						
													for($j=0; $j<sizeof($airports); $j++){
														if($airports[$j]['code'] == $flights[$i]['flightTo'][$k]['departureCode']){
							echo 							$airports[$j]['name'];
														}	
													}
							echo 						'</br>';	
							echo						$flights[$i]['flightTo'][$k]['arrivalHour'];
							echo 						' - <b>';
							echo 						$flights[$i]['flightTo'][$k]['arrivalCode'];
							echo 						'</b>, ';
						
													for($j=0; $j<sizeof($airports); $j++){
														if($airports[$j]['code'] == $flights[$i]['flightTo'][$k]['arrivalCode']){
							echo 							$airports[$j]['name'];
														}	
													}
							echo 					'</div>';
							echo 					'<div class="col-sm-2"><b><h6>';
							echo						$flights[$i]['flightTo'][$k]['airline'];
							echo 					'</h6></b>
													</div>';
							echo 					'<div class="col-sm-2"><b><h6>';
							echo						$flights[$i]['flightTo'][$k]['flightNumber'];
							echo 					'</h6></b>
													</div>';	
							echo 					'<div class="col-sm-2"><b><h2>';
							echo						$flights[$i]['flightTo'][$k]['subprice'].' zł';
							echo 					'</h2></b>
													</div>';	
							echo 					'<div class="col-sm-2"><b><h2>
													<a href="';
							echo						$flights[$i]['flightTo'][$k]['url'];
							echo					'" class="btn btn-success btn-block">Kup bilet</a>';
							echo 					'</h2></b>
													</div>';													
							echo 				'</div>';
							echo 				'</div>';
											}
							echo '			</div>
										</div>
									</div>';
							
							echo '	<div class="row" id="rowFT'.$i.'" style="display: none" name="hidden">
										<div class="col-sm"><br/>
											<div class="alert alert-secondary" role="alert">
											<b>Loty z miejsca docelowego</b><br/>';
											
											for($k=0; $k<sizeof($flights[$i]['flightFrom']);$k++){
							echo 				'<div class="alert alert-light" role="alert">';
							echo 					'<div class="row">';
							echo 					'<div class="col-sm-4">';
							echo						$flights[$i]['flightFrom'][$k]['departureHour'];
							echo 						' - <b>';
							echo 						$flights[$i]['flightFrom'][$k]['departureCode'];
							echo 						'</b>, ';
						
													for($j=0; $j<sizeof($airports); $j++){
														if($airports[$j]['code'] == $flights[$i]['flightFrom'][$k]['departureCode']){
							echo 							$airports[$j]['name'];
														}	
													}
							echo 						'</br>';	
							echo						$flights[$i]['flightFrom'][$k]['arrivalHour'];
							echo 						' - <b>';
							echo 						$flights[$i]['flightFrom'][$k]['arrivalCode'];
							echo 						'</b>, ';
						
													for($j=0; $j<sizeof($airports); $j++){
														if($airports[$j]['code'] == $flights[$i]['flightFrom'][$k]['arrivalCode']){
							echo 							$airports[$j]['name'];
														}	
													}
							echo 					'</div>';
							echo 					'<div class="col-sm-2"><b><h6>';
							echo						$flights[$i]['flightFrom'][$k]['airline'];
							echo 					'</h6></b>
													</div>';
							echo 					'<div class="col-sm-2"><b><h6>';
							echo						$flights[$i]['flightFrom'][$k]['flightNumber'];
							echo 					'</h6></b>
													</div>';	
							echo 					'<div class="col-sm-2"><b><h2>';
							echo						$flights[$i]['flightFrom'][$k]['subprice'].' zł';
							echo 					'</h2></b>
													</div>';	
							echo 					'<div class="col-sm-2"><b><h2>
													<a href="';
							echo						$flights[$i]['flightFrom'][$k]['url'];
							echo					'" class="btn btn-success btn-block">Kup bilet</a>';
							echo 					'</h2></b>
													</div>';													
							echo 				'</div>';
							echo 				'</div>';
											}
							echo '			</div>
										</div>
									</div>';						


	echo							'</div>';
						}
		
	echo'						
					</div>
				</div>
			</div>
	</div>'; }
	
	echo' 	
	<script src="front.js"></script>
	<script>
			$( "button.btn-info" ).click(function() {
				let idOfRow = $(this).attr("id");
				let id = "#"+idOfRow;
				
				let rowNameFF = "#rowFF"+idOfRow;
				let rowNameFT = "#rowFT"+idOfRow;
				
				let nameFF = $(rowNameFF).attr("name");
				let nameFT = $(rowNameFT).attr("name");
				
				
				if(nameFF == "hidden" && nameFT == "hidden"){
					$(rowNameFF).show();
					$(rowNameFF).attr("name","showed");
					
					$(rowNameFT).show();
					$(rowNameFT).attr("name", "showed");
					
					$(id).html("Ukryj szczegóły");
					
				} else if (nameFF == "showed" && nameFT == "showed"){
					$(rowNameFF).hide();
					$(rowNameFF).attr("name","hidden");
					
					$(rowNameFT).hide();
					$(rowNameFT).attr("name", "hidden");
					
					$(id).html("Pokaż szczegóły");
				}
			});
			


	</script>';
	
	unlink($result);

?>