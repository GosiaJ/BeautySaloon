<?php
	session_start();

	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak
		$wszystko_OK = true;

		//sprawdz nickname
		$nick =$_POST['nick'];

		//sprawdzenie długości podanego nicka
		//sytuacja problematyczna
		if((strlen($nick)<3)||(strlen($nick)>20))
		{
			$wszystko_OK = false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków";
		}
		//poprawność adresu e-mail
		$email = $_POST['email'];
		$emailB =filter_var($email, FILTER_SANITIZE_EMAIL);

		if((filter_var($emailB,FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$wszystko_OK = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail";
		}

		//poprawnosc hasla
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];

		if(strlen($haslo1) < 8 || strlen($haslo1) > 20)
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków";
		}

		//hashowanie hasła typ hashowania zależy już od wersji PHPa, którą mamy
		//definiowanie stałej, która nie jest zdeiniowana jak się okazuje :)
				
		if($haslo1 != $haslo2)
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Podane hasła muszą być identyczne";
		}

		if(ctype_alnum($nick)==false)
		{
			$wszystko_OK = false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków!";
		}
		//czy zaakceptowano regulamin
		if(!isset($_POST['regulamin']))
		{
			$wszystko_OK = false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu";
		}
		//czy zaznaczono captchaę?
		$sekret = "6LdVHQoUAAAAAKA-mZKqeTEMLCjp3qjS1kp4BFiH";

		$sprawdz=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

		$odpowiedz = json_decode($sprawdz);
		if($odpowiedz->success==false)
		{
			$wszystko_OK = false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem";
		}

		require_once "connect.php";

		mysqli_report(MYSQLI_REPORT_STRICT);

		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);
			if($polaczenie->connect_errno!=0)
				{ 
					throw new Exception(mysqli_connect_errorno());
				}
				else
				{
					//Czy e-mail już jest w bazie?
					$rezultat = $polaczenie->query("SELECT id from logowaniezyta WHERE email='$email'");

					if(!$rezultat)
					{
						throw new Exception($polaczenie->error);
					}

					$ile_takich_maili = $rezultat->num_rows;
					if($ile_takich_maili>0)
					{
						$wszystko_OK = false;
						$_SESSION['e_email']="Istnieje już konto z podanym kontem e-mail";
					}

					//Czy NICK już jest w bazie?
					$rezultat = $polaczenie->query("SELECT id from logowaniezyta WHERE Nick='$nick'");

					if(!$rezultat)
					{
						throw new Exception($polaczenie->error);
					}

					$ile_takich_nicków = $rezultat->num_rows;
					if($ile_takich_nicków>0)
					{
						$wszystko_OK = false;
						$_SESSION['e_nick']="Istnieje już konto z podanym nickiem";
					}

					

					if ($wszystko_OK == true)
					{
						//Wszystkie testy zaliczone, osoba dopisała się
						if($polaczenie->query("INSERT INTO logowaniezyta VALUES(NULL, '$nick','$haslo1','$email')"))
						{
							$_SESSION['udanarejestracja']=true;
							header('Location: witamy.php');

						}
						else
						{
							throw new Exception($polaczenie->error);
						}
						
					}

					$polaczenie->close();
				}
		}
		catch(xception $e)
		{
			echo "błąd serwera, przepraszamy za niedogodności i prosimy o rejestrację w innm terminie";
			//echo '<br/>  Informacja deweloperska:'.$e;
		}


		


	}



?>
<!DOCTYPE HTML>
<head>
<html lang="pl">
	<meta charset="utf-8" /> <!-- meta informacje -->
	<title> Dopisz się do naszej społeczności! </title>
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
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
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
					<i class="icon-doc-new"></i> <br/> Zapisy
					<a href="zapisy.php" class="teillink"> 

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
					<h3> Dopisz się: </h3>
						<form method="post">
							Nickname: <br />
							<input type ="text" name ="nick" /> <br/><br/>
							
							<?php
							if(isset($_SESSION['e_nick']))
							{
								echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
							?>

							E-mail: <br />
							<input type ="text" name ="email" /> 

							<?php
							if(isset($_SESSION['e_email']))
							{
								echo '<div class="error">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
							?>

							<br/><br/>
							Podaj hasło: <br/>
							<input type ="password" name ="haslo1" /> 

							<?php
							if(isset($_SESSION['e_haslo']))
							{
								echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
								unset($_SESSION['e_haslo']);
							}
							?>

							<br/><br/>
							Powtórz hasło: <br/>
							<input type ="password" name ="haslo2" /> 
							<br/><br/>
							<label>
								<input type ="checkbox" name ="regulamin" /> Akceptuję regulamin!
							</label>
							<?php
							if(isset($_SESSION['e_regulamin']))
							{
								echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
								unset($_SESSION['e_regulamin']);
							}
							?>
							<br/> <br/>

							<div class="g-recaptcha" data-sitekey="6LdVHQoUAAAAAKrgmIeEpVrTHLV34GoVgS_Hnj9i"></div>
							<?php
							if(isset($_SESSION['e_bot']))
							{
								echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
								unset($_SESSION['e_bot']);
							}
							?>
							<br/>
							<input type="submit" value="Dopisz się" />

						</form>	

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
</html>
