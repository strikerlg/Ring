<?php
//włączamy bufor
ob_start();

//pobieramy zawartość pliku ustawień
require_once('var/ustawienia.php');

//startujemy lub przedłużamy sesję
session_start();

//dołączamy plik, który sprawdzi czy napewno mamy dostęp do tej strony
require_once('test_zalogowanego.php');

//pobieramy nagłówek strony
require_once('gora_strony.php');
if($uzytkownik['pracuje'] > 0) header('location: praca.php');

//pobieramy zawartość menu
require_once('menu.php');

echo "<h2>Hotel</h2><hr/>";

if(!empty($_POST['pkt'])){
	$_POST['pkt'] = (int)$_POST['pkt'];

	if($_POST['pkt'] < 1) 
		echo "<p class='error'>Nieprawidłowa wartość</p><br class='clear'>";
	elseif($_POST['pkt'] > $uzytkownik['zmeczenie_max'] - $uzytkownik['zmeczenie']) 
		echo "<p class='error'>Podano za dużą wartość</p><br class='clear'>";
	elseif($_POST['pkt'] * 25 > $uzytkownik['kasa']) 
		echo "<p class='error'>Masz za mało kasy</p><br class='clear'>";
	else {
		mysql_query("update ring_gracze set zmeczenie = zmeczenie + ".$_POST['pkt'].", kasa = kasa - ".($_POST['pkt'] * 25)." where gracz = ".$uzytkownik['gracz']);
		
		$uzytkownik['zmeczenie'] += $_POST['pkt'];
		$uzytkownik['kasa'] -= $_POST['pkt'] * 25;

		echo "<p class='note'>Zregenerowano <i><b>".$_POST['pkt']."</b></i> punktów zmęczenia</p><br class='clear'>";
	}
}

if($uzytkownik['zmeczenie'] < $uzytkownik['zmeczenie_max']){
	echo"
		Jeżeli jesteś zmęczony, to w hotelu możesz odzyskać punkty zmęczenia.<br/>
		1 punkt zmęczenia = 25 $<br/>
		<form action='hotel.php' method='post'>
			<input type='text' name='pkt' /> 
			<input type='submit' value='odpocznij'/>
		</form>
	";
} else echo "<p class='note'>Nie musisz odpoczywać</p>";




//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 