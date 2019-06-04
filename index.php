<html>
	<head>
		<title>Wyszukiwarka lotów</title>
		<link rel="shortcut icon" type="image/png" href="favicon.ico"/>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css">
		<link href="https://unpkg.com/multiple-select@1.3.0/dist/multiple-select.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.css">		
		<link rel="stylesheet" href="css/front.css">		
		<link rel="stylesheet" href="css/plane.css">		
	</head>
	<body>
	<div id="form">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm">
						<div class="alert alert-info" role="alert">
							<div class="modal fade" id="myModal">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-body">
											<center>
											<div class="atom-spinner">
												<div class="spinner-inner">
													<div class="spinner-line"></div>
													<div class="spinner-line"></div>
													<div class="spinner-line"></div>
													<!--Chrome renders little circles malformed :(-->
													<div class="spinner-circle">
													&#9679;
													</div>
												</div>
											</div>
											<center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="alert alert-light trn" role="alert">
							<center>
								<img src="logo.png"></img>
							</center>
						</div>
						<div class="alert alert-info trn" role="alert">
							<h6><b>Zaznacz lotnisko docelowe i lotnisko wylotu:</b></h6>
						</div>
						
						<div class="alert alert-light" role="alert">
							<div class="row">
							<div class="form-group">
								<div class="col-12 col-sm-3">
									<label for="srcAir">Lotnisko wylotu: </label>
								</div>
								<div class="col-12 col-sm-12">
									<select id="srcAir" name="srcAirport" multiple>
										<?php include "tt.php"; getOptions();?>
									</select>
								</div>	
							</div>
							
							<div class="form-group">
								<div class="col-12 col-sm-3">
									<label for="dstAir">Lotnisko przylotu: </label>
								</div>
								<div class="col-12 col-sm-12">
									<select id="dstAir" name="dstAirport" multiple>
									<?php getOptions();?>
									</select>
								</div>
							</div>
							</div>
						</div>
							
						
						<div class="alert alert-info" role="alert">
							<h6><b>Zaznacz dolną i granicę wyszukiwania:</b></h6>
						</div>
						
						<div class="alert alert-light" role="alert">

							<div class="form-group">
								<label>Od kiedy:</label>
								<input type="date" name="depdate" id="departureDate" min="<?php echo date('Y-m-d');?>"  max="<?php echo date('Y-m-d', strtotime('+10 months'))?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Do kiedy:</label>
								<input type="date" name="arrdate" id="arrivalDate" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime('+10 months'))?>" class="form-control">
							</div>

						</div>	
						
						<div class="alert alert-info" role="alert">
							<h6><b>Zaznacz minimalną i maksymalną długość pobytu:</b></h6>
						</div>
						
						<div class="alert alert-light" role="alert">
							<div class="row">
								<div class="col-12 col-sm-4">
									<div id="minDayCounter"></div>
								</div>
								<div class="col-12 col-sm-8">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="1" max="31" value="3" class="slider" id="minDays" name="minDaysStay">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-4">
									<div id="maxDayCounter"></div>
								</div>
								<div class="col-12 col-sm-8">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="1" max="31" value="5" class="slider" id="maxDays" name="maxDaysStay">
										</div>
									</div>
								</div>
							</div>	
						</div>
						
						<div class="alert alert-info" role="alert">
							<h6><b>Zaznacz ilość pasażerów:</b></h6>
						</div>
						
						<div class="alert alert-light" role="alert">
							<div class="row">
								<div class="col-12 col-sm-4">
									<div id="infantsCounter"></div>
								</div>
								<div class="col-12 col-sm-8">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="0" max="10" value="0" class="slider" id="infant" name="infants">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-4">
									<div id="childrenCounter"></div>
								</div>
								<div class="col-12 col-sm-8">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="0" max="10" value="0" class="slider" id="child" name="children">
										</div>
									</div>
								</div>
							</div>	
							
							<div class="row">
								<div class="col-12 col-sm-4">
									<div id="adultsCounter"></div>
								</div>
								<div class="col-12 col-sm-8">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="0" max="10" value="1" class="slider" id="adult" name="adults">
										</div>
									</div>
								</div>
							</div>	
						</div>

						<div class="alert alert-info" role="alert">
							<h6><b>Zaznacz dodatkowe parametry:</b></h6>
						</div>
						
						<div class="alert alert-light" role="alert">
							<div class="row">
								<div class="col-12 col-sm-4">
									<div class="form-group">
										<div class="slidecontainer">
											<input type="range" min="0" max="3" value="0" class="slider" id="maxChange" name="maxChng" data-slider-ticks="[0, 1, 2, 3]" data-slider-ticks-labels='["0", "1", "2", "3"]'>
											<label class="form-check-label" for="maxChange" id="maxChangeCounter">
											</label>
										</div>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="true" id="nextDayChange" name="nextday">
										<label class="form-check-label" for="nextDayChange">
											Możliwa przesiadka następnego dnia
										</label>
									</div>
								</div>
								<div class="col-12 col-sm-4">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="true" id="sameDeparture" name="samedep">
										<label class="form-check-label" for="sameDeparture">
											To samo lotnisko wylotu
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="true" id="sameArrival" name="samearr">
										<label class="form-check-label" for="sameArrival">
											To samo lotnisko przylotu
										</label>
									</div>
								</div>
								<div class="col-12 col-sm-4">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="true" id="wizz" name="wizzxclub">
										<label class="form-check-label" for="wizz">
											Wizz Discount Club
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="true" id="supervolo" name="supervolotea">
										<label class="form-check-label" for="supervolo">
											SuperVolotea
										</label>
									</div>
								</div>
							</div>
						</div>	
						<div class="alert alert-info" role="alert">
							<div class="row">
								<div class="col-sm-6">
									<input class="form-check-input" type="checkbox" value="true" id="reminder" name="remindMechanism">
									<label class="form-check-label" for="reminder">	
										<h6><b>&nbsp;Włącz alert cenowy</b></h6>
									</label>
								</div>
								<div class="col-sm-6" id="reminderDiv">
									<label class="form-check-label" for="reminder">	
										<h6><b>Wybierz zakres cenowy</b></h6>
									</label>
									<select id="reminderPrice">
										<option value="100"><100 zł</option>
										<option value="200"><200 zł</option>
										<option value="500"><500 zł</option>
										<option value="1000"><1000 zł</option>
										<option value="2000"><2000 zł</option>
										<option value="5000"><5000 zł</option>
									</select> 
								</div>
							</div>
						</div>
					<button type="submit" id="sendRequest" class="btn btn-info btn-block">Sprawdź loty</button>
				</div>
		</div><br/>
					<div class="alert alert-info" role="alert">
						<div class="row">
							<div class="col-12 col-sm-12" align="center">
								<b>Created by AW&JG&ND ©</b>
								<?php echo date("Y")?>
							</div>
						</div>
					</div>
	</div> 
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.full.js"></script>
		<script src="js/slider.js"></script>
		<script src="js/front.js"></script>
	</body>

</html>

