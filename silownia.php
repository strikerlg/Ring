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

echo "<h2>Siłownia</h2><hr/>";

if(!empty($_GET['trenuj'])){
	switch($_GET['trenuj']){
		case 1:
			if($uzytkownik['kasa'] < $uzytkownik['boksowanie'] * 100)
				echo "<p class='error'>Za mało gotówki</p><br class='clear'>";
			elseif($uzytkownik['akcje'] < 1)
				echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < $uzytkownik['boksowanie'])
				echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				mysql_query("update ring_gracze set akcje = akcje - 1, boksowanie = boksowanie + 1, kasa = kasa - ".(100*$uzytkownik['boksowanie']).", zmeczenie = zmeczenie - ".$uzytkownik['boksowanie']." where gracz = ".$uzytkownik['gracz']);

				
				$uzytkownik['kasa'] -= $uzytkownik['boksowanie'] * 100;
				
				$uzytkownik['zmeczenie'] -= $uzytkownik['boksowanie'];
				$uzytkownik['boksowanie']++;

				echo "<p class='note'>Trening udany</p><br class='clear'>";

			}
		break;
		case 2:
			if($uzytkownik['kasa'] < $uzytkownik['walka_parter'] * 120)
				echo "<p class='error'>Za mało gotówki</p><br class='clear'>";
			elseif($uzytkownik['akcje'] < 1)
				echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < $uzytkownik['walka_parter'])
				echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				mysql_query("update ring_gracze set akcje = akcje - 1, walka_parter = walka_parter + 1, kasa = kasa - ".(120*$uzytkownik['walka_parter']).", zmeczenie = zmeczenie - ".$uzytkownik['walka_parter']." where gracz = ".$uzytkownik['gracz']);

				
				$uzytkownik['kasa'] -= $uzytkownik['walka_parter'] * 120;
				
				$uzytkownik['zmeczenie'] -= $uzytkownik['walka_parter'];
				$uzytkownik['walka_parter']++;

				echo "<p class='note'>Trening udany</p><br class='clear'>";

			}
		break;
		case 3:
			if($uzytkownik['kasa'] < $uzytkownik['zapasy'] * 80)
				echo "<p class='error'>Za mało gotówki</p><br class='clear'>";
			elseif($uzytkownik['akcje'] < 1)
				echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < $uzytkownik['zapasy'])
				echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				mysql_query("update ring_gracze set akcje = akcje - 1, zapasy = zapasy + 1, kasa = kasa - ".(80*$uzytkownik['zapasy']).", zmeczenie = zmeczenie - ".$uzytkownik['zapasy']." where gracz = ".$uzytkownik['gracz']);

				
				$uzytkownik['kasa'] -= $uzytkownik['zapasy'] * 80;
				
				$uzytkownik['zmeczenie'] -= $uzytkownik['zapasy'];
				$uzytkownik['zapasy']++;

				echo "<p class='note'>Trening udany</p><br class='clear'>";

			}
		break;
		case 4:
			if($uzytkownik['kasa'] < $uzytkownik['kopanie'] * 110)
				echo "<p class='error'>Za mało gotówki</p><br class='clear'>";
			elseif($uzytkownik['akcje'] < 1)
				echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < $uzytkownik['kopanie'])
				echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				mysql_query("update ring_gracze set akcje = akcje - 1, kopanie = kopanie + 1, kasa = kasa - ".(110*$uzytkownik['kopanie']).", zmeczenie = zmeczenie - ".$uzytkownik['kopanie']." where gracz = ".$uzytkownik['gracz']);

				
				$uzytkownik['kasa'] -= $uzytkownik['kopanie'] * 110;
				
				$uzytkownik['zmeczenie'] -= $uzytkownik['kopanie'];
				$uzytkownik['kopanie']++;

				echo "<p class='note'>Trening udany</p><br class='clear'>";

			}
		break;
		case 5:
			if($uzytkownik['kasa'] < $uzytkownik['kondycja'] * 150)
				echo "<p class='error'>Za mało gotówki</p><br class='clear'>";
			elseif($uzytkownik['akcje'] < 1)
				echo "<p class='error'>Za mało punktów akcji</p><br class='clear'>";
			elseif($uzytkownik['zmeczenie'] < $uzytkownik['kondycja'])
				echo "<p class='error'>Jesteś zbyt zmęczony</p><br class='clear'>";
			else {
				mysql_query("update ring_gracze set akcje = akcje - 1, kondycja = kondycja + 1, kasa = kasa - ".(150*$uzytkownik['kondycja']).", zmeczenie = zmeczenie - ".$uzytkownik['kondycja']." where gracz = ".$uzytkownik['gracz']);

				
				$uzytkownik['kasa'] -= $uzytkownik['kondycja'] * 150;
				
				$uzytkownik['zmeczenie'] -= $uzytkownik['kondycja'];
				$uzytkownik['kondycja']++;

				echo "<p class='note'>Trening udany</p><br class='clear'>";

			}
		break;
		default:
			echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
		break;
	}

}

echo "<table>";

if( ($uzytkownik['kasa'] > $uzytkownik['boksowanie'] * 100) && ($uzytkownik['zmeczenie'] > $uzytkownik['boksowanie']) && ($uzytkownik['akcje'] > 0) )
	echo "
		<tr>
			<td>boksowanie</td>
			<td>".$uzytkownik['boksowanie']."</td>
			<td><a href='silownia.php?trenuj=1'>trenuj (1 akcji, ".$uzytkownik['boksowanie']." zmęczenia, ".($uzytkownik['boksowanie'] * 100)." $)</a> </td>
		</tr>
	";
else
	echo "
		<tr>
			<td>boksowanie</td>
			<td>".$uzytkownik['boksowanie']."</td>
			<td> -  (1 akcji, ".$uzytkownik['boksowanie']." zmęczenia, ".($uzytkownik['boksowanie'] * 100)." $) </td>
		</tr>
	";

if( ($uzytkownik['kasa'] > $uzytkownik['walka_parter'] * 120) && ($uzytkownik['zmeczenie'] > $uzytkownik['walka_parter']) && ($uzytkownik['akcje'] > 0) )
	echo "
		<tr>
			<td>walka w parterze</td>
			<td>".$uzytkownik['walka_parter']."</td>
			<td><a href='silownia.php?trenuj=2'>trenuj (1 akcji, ".$uzytkownik['walka_parter']." zmęczenia, ".($uzytkownik['walka_parter'] * 120)." $)</a> </td>
		</tr>
	";
else
	echo "
		<tr>
			<td>walka_parter</td>
			<td>".$uzytkownik['walka_parter']."</td>
			<td> -  (1 akcji, ".$uzytkownik['walka_parter']." zmęczenia, ".($uzytkownik['walka_parter'] * 120)." $) </td>
		</tr>
	";


if( ($uzytkownik['kasa'] > $uzytkownik['zapasy'] * 80) && ($uzytkownik['zmeczenie'] > $uzytkownik['zapasy']) && ($uzytkownik['akcje'] > 0) )
	echo "
		<tr>
			<td>zapasy</td>
			<td>".$uzytkownik['zapasy']."</td>
			<td><a href='silownia.php?trenuj=3'>trenuj (1 akcji, ".$uzytkownik['zapasy']." zmęczenia, ".($uzytkownik['zapasy'] * 80)." $)</a> </td>
		</tr>
	";
else
	echo "
		<tr>
			<td>zapasy</td>
			<td>".$uzytkownik['zapasy']."</td>
			<td> -  (1 akcji, ".$uzytkownik['zapasy']." zmęczenia, ".($uzytkownik['zapasy'] * 80)." $) </td>
		</tr>
	";


if( ($uzytkownik['kasa'] > $uzytkownik['kopanie'] * 110) && ($uzytkownik['zmeczenie'] > $uzytkownik['kopanie']) && ($uzytkownik['akcje'] > 0) )
	echo "
		<tr>
			<td>kopanie</td>
			<td>".$uzytkownik['kopanie']."</td>
			<td><a href='silownia.php?trenuj=4'>trenuj (1 akcji, ".$uzytkownik['kopanie']." zmęczenia, ".($uzytkownik['kopanie'] * 110)." $)</a> </td>
		</tr>
	";
else
	echo "
		<tr>
			<td>kopanie</td>
			<td>".$uzytkownik['kopanie']."</td>
			<td> -  (1 akcji, ".$uzytkownik['kopanie']." zmęczenia, ".($uzytkownik['kopanie'] * 110)." $) </td>
		</tr>
	";

if( ($uzytkownik['kasa'] > $uzytkownik['kondycja'] * 150) && ($uzytkownik['zmeczenie'] > $uzytkownik['kondycja']) && ($uzytkownik['akcje'] > 0) )
	echo "
		<tr>
			<td>kondycja</td>
			<td>".$uzytkownik['kondycja']."</td>
			<td><a href='silownia.php?trenuj=5'>trenuj (1 akcji, ".$uzytkownik['kondycja']." zmęczenia, ".($uzytkownik['kondycja'] * 150)." $)</a> </td>
		</tr>
	";
else
	echo "
		<tr>
			<td>kondycja</td>
			<td>".$uzytkownik['kondycja']."</td>
			<td> -  (1 akcji, ".$uzytkownik['kondycja']." zmęczenia, ".($uzytkownik['kondycja'] * 150)." $) </td>
		</tr>
	";

echo "</table>";

//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 