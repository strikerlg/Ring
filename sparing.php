<?php
//włączamy bufor
ob_start();

//pobieramy zawartość pliku ustawień
require_once('var/ustawienia.php');

//startujemy lub przedłużamy sesję
session_start();

//dołączamy plik, który sprawdzi czy napewno mamy dostęp do tej strony
require_once('test_zalogowanego.php');
if($uzytkownik['pracuje'] > 0) header('location: praca.php');

//pobieramy nagłówek strony
require_once('gora_strony.php');


//pobieramy zawartość menu
require_once('menu.php');

echo "<h2>Sparingi</h2><hr/>";


if(!empty($_GET['sparing'])){

	switch($_GET['sparing']){
		case 1:

			if($uzytkownik['akcje'] < 5) echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < 10) echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				$punkty_gracz = 10*$uzytkownik['boksowanie'] + 12*$uzytkownik['walka_parter'] + 8*$uzytkownik['zapasy'] + 11*$uzytkownik['kopanie'] + 15*$uzytkownik['kondycja'];

				$punkty_przeciwnik = 10* rand(1,5) + 12* rand(1,5) + 8* rand(1,5) + 11* rand(1,5) + 15* rand(1,5);
				
				if($punkty_gracz > $punkty_przeciwnik) {
					mysql_query("update ring_gracze set akcje = akcje - 5, zmeczenie = zmeczenie - 10, kasa = kasa + ".($punkty_przeciwnik*10)." where gracz = ".$uzytkownik['gracz']); 
					echo "
					<p class='note'>Wygrałeś sparing</p><br class='clear'>
					<p>Wygrałeś swój sparing! Odbierasz wynagrodzenie w wysokości ".($punkty_przeciwnik*10)."$.</p>
					";
					$uzytkownik['akcje'] -= 5;
					$uzytkownik['zmeczenie'] -= 10;
					$uzytkownik['kasa'] += $punkty_przeciwnik*10;
				} else {
					mysql_query("update ring_gracze set akcje = akcje - 5, zmeczenie = zmeczenie - 10, kasa = kasa + ".($punkty_przeciwnik)." where gracz = ".$uzytkownik['gracz']);
					echo "
					<p class='error'>Przegrałeś sparing</p><br class='clear'>
					<p>Przegrałeś swój sparing, otrzymujesz tylko 10% wynagrodzenia w wysokości ".($punkty_przeciwnik)."$.</p>
					";
					$uzytkownik['akcje'] -= 5;
					$uzytkownik['zmeczenie'] -= 10;
					$uzytkownik['kasa'] += $punkty_przeciwnik;
				}
			}
			
			
		break;
		case 2:
			if($uzytkownik['akcje'] < 10) echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < 20) echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				$punkty_gracz = 10*$uzytkownik['boksowanie'] + 12*$uzytkownik['walka_parter'] + 8*$uzytkownik['zapasy'] + 11*$uzytkownik['kopanie'] + 15*$uzytkownik['kondycja'];

				$punkty_przeciwnik = 10* rand(5,10) + 12* rand(5,10) + 8* rand(5,10) + 11* rand(5,10) + 15* rand(5,10);
				
				if($punkty_gracz > $punkty_przeciwnik) {
					mysql_query("update ring_gracze set akcje = akcje - 10, zmeczenie = zmeczenie - 20, kasa = kasa + ".($punkty_przeciwnik*10)." where gracz = ".$uzytkownik['gracz']); 
					echo "
					<p class='note'>Wygrałeś sparing</p><br class='clear'>
					<p>Wygrałeś swój sparing! Odbierasz wynagrodzenie w wysokości ".($punkty_przeciwnik*10)."$.</p>
					";
					$uzytkownik['akcje'] -= 10;
					$uzytkownik['zmeczenie'] -= 20;
					$uzytkownik['kasa'] += $punkty_przeciwnik*10;
				} else {
					mysql_query("update ring_gracze set akcje = akcje - 10, zmeczenie = zmeczenie - 20, kasa = kasa + ".floor($punkty_przeciwnik/2)." where gracz = ".$uzytkownik['gracz']);
					echo "
					<p class='error'>Przegrałeś sparing</p><br class='clear'>
					<p>Przegrałeś swój sparing, otrzymujesz tylko 10% wynagrodzenia w wysokości ".floor($punkty_przeciwnik/2)."$.</p>
					";
					$uzytkownik['akcje'] -= 10;
					$uzytkownik['zmeczenie'] -= 20;
					$uzytkownik['kasa'] += floor($punkty_przeciwnik/2);
				}
			}
		break;
		case 3:
			if($uzytkownik['akcje'] < 15) echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < 25) echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				$punkty_gracz = 10*$uzytkownik['boksowanie'] + 12*$uzytkownik['walka_parter'] + 8*$uzytkownik['zapasy'] + 11*$uzytkownik['kopanie'] + 15*$uzytkownik['kondycja'];

				$punkty_przeciwnik = 10* rand(10,20) + 12* rand(10,20) + 8* rand(10,20) + 11* rand(10,20) + 15* rand(10,20);
				
				if($punkty_gracz > $punkty_przeciwnik) {
					mysql_query("update ring_gracze set akcje = akcje - 15, zmeczenie = zmeczenie - 25, kasa = kasa + ".($punkty_przeciwnik*10)." where gracz = ".$uzytkownik['gracz']); 
					echo "
					<p class='note'>Wygrałeś sparing</p><br class='clear'>
					<p>Wygrałeś swój sparing! Odbierasz wynagrodzenie w wysokości ".($punkty_przeciwnik*10)."$.</p>
					";
					$uzytkownik['akcje'] -= 15;
					$uzytkownik['zmeczenie'] -= 25;
					$uzytkownik['kasa'] += $punkty_przeciwnik*10;
				} else {
					mysql_query("update ring_gracze set akcje = akcje - 15, zmeczenie = zmeczenie - 25, kasa = kasa + ".floor($punkty_przeciwnik/4)." where gracz = ".$uzytkownik['gracz']);
					echo "
					<p class='error'>Przegrałeś sparing</p><br class='clear'>
					<p>Przegrałeś swój sparing, otrzymujesz tylko 10% wynagrodzenia w wysokości ".floor($punkty_przeciwnik/4)."$.</p>
					";
					$uzytkownik['akcje'] -= 15;
					$uzytkownik['zmeczenie'] -= 25;
					$uzytkownik['kasa'] += floor($punkty_przeciwnik/4);
				}
			}
		break;
		default:
			echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
		break;
	}	
}


echo "
	<hr/>Możliwe sparingi<hr/>
	<ul>
		<li>Sparing łatwy (5 akcji, 10 zmęczenia) <a href='sparing.php?sparing=1'>walcz</a></li>
		<li>Sparing normalny (10 akcji, 20 zmęczenia) <a href='sparing.php?sparing=2'>walcz</a></li>
		<li>Sparing trudny (15 akcji, 25 zmęczenia) <a href='sparing.php?sparing=3'>walcz</a></li>
	</ul>
";




//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 