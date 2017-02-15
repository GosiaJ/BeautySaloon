<?php
session_start();

?>
<!DOCTYPE HTML>
<head>
<html lang="pl">
	<meta charset="utf-8" /> <!-- meta informacje -->
	<title> Strona główna </title>
	<meta name="description" content="Twoja własna baza najlepszych filmów" />
	<!-- KEY WORDS, żeby podnieść stronę w wynikach wyszukiwania. -->
	<meta name="keywords" content="multimedia" />
	<!-- dla Explorera w razie jakby cś w Explorerze nie działało :D 
	rozkazuje IE generowanie najwyższej wersji systemu-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="ikons/css/fontello.css" type="text/css" />	
	
	<!-- fonty google -->
	<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Open+Sans+Condensed:300=latin-ext" rel="stylesheet">

	<script src="timer.js"></script>
	
</head>

<body onload="odliczanie();">

	<div id="container">

		<div class="rectangle">
			<div id="logo"><a href="index.php" class="backtomainmenu"> Salon Urody <br/> Zyta Lalko</a></div>
			<div id="zegar"></div>
			<div style="clear:both;"></div>
		</div>

		<div class="mainRectangle">
			<div class="square1">

			<div class="tile1"> 
				<a href="omnie.php" class="teillink"> 
					<i class="icon-user-woman"></i> <br/> O mnie
				</a>
			</div>

			<div class="tile1"> 
				<a href="osalinie.php" class="teillink"> 
					<i class="icon-diamond"></i> <br/> O salonie
				</a>
			</div>

			<div class="tile1">  
				<a href="kontakt.php" class="teillink">
					<i class="icon-mail"></i> <br/> Kontakt
				</a>
			</div>

			<div class="tile1">  
				<a href="zapisy.php" class="teillink">
					<i class="icon-doc-new"></i> <br/> Zapisy
				</a>
			</div>

			<div class="tile1">  
				<a href="zalogujsie.php" class="teillink"> 
					<i class="icon-user-plus"></i> <br/> Zaloguj się
				</a>
			</div>

			</div>

			<div class="square2">
				<div class="tile5"> 
					Cześć, <br/> <br/>
					PODSTAWOWE INFORMACJE O SALONIE


				</div>

				<div class="fb">
					<a href="https://www.facebook.com/gosia.janeczek" target="_blank" class="socialmedia">
						<i class="icon-facebook"></i>
					</a>
				</div>

				<div class="insta">
					<a href="http://www.pictaram.com/user/zyta_lko/2994790401" target="_blank" class="socialmedia">
						<i class="icon-instagram-filled"></i>	
					</a>	
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>

		</div>

			<div class="rectangle"> 2016 &copy; Salon Urody - Zyta Lalko <i class="icon-mail2"></i> e-mail: z.la@majl.pl
			</div>

	</div>




</body>
