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


echo "<h2>Walki rankingowe</h2><hr/>
Walki o miejsce w rankingu są najbardziej prestiżowe i dochodowe. Tylko zwycięzca otrzymuje nagrodę.<br/>
Za wygranie pojedynku otrzymasz pewną kwotę pieniędzy. Dodatkowo, jeżeli pokonasz gracza wyżej w rankingu niż Ty, to otrzymasz bonus pieniężny i zamienisz się z tym graczem miejscami w rankingu.<br/><br/>
Warto powoli awansować w rankingu i tym samym zgarnąć większą ilość pieniędzy z wszystkich wygranych.<br/><br/>
<b>Koszt pojedynku to 50 akcji</b><hr/>
";



if(!empty($_GET['walcz'])){
	$_GET['walcz'] = (int)$_GET['walcz'];

	if($_GET['walcz'] == $uzytkownik['gracz']){
		echo "<p class='error'>Nie możesz walczyć sam ze sobą</p><br class='clear'>";
	} elseif($uzytkownik['akcje'] < 50){
		echo "<p class='error'>Posiadasz za mało punktów akcji</p><br class='clear'>";
	} else {
		$vs = mysql_fetch_array(mysql_query("select * from ring_gracze where gracz = ".$_GET['walcz']));
		if(empty($vs)){
			echo "<p class='error'>Nie ma takiego gracza!</p><br class='clear'>";
		} else {
			$punkty_gracz = 10*$uzytkownik['boksowanie'] + 12*$uzytkownik['walka_parter'] + 8*$uzytkownik['zapasy'] + 11*$uzytkownik['kopanie'] + 15*$uzytkownik['kondycja'];

			$punkty_przeciwnik = 10*$vs['boksowanie'] + 12*$vs['walka_parter'] + 8*$vs['zapasy'] + 11*$vs['kopanie'] + 15*$vs['kondycja'];
			
			$pozycja = $uzytkownik['ranking'];
			if($punkty_gracz > $punkty_przeciwnik) {
				if($uzytkownik['ranking'] <= $vs['ranking']){
					mysql_query("update ring_gracze set akcje = akcje - 50, kasa = kasa + ".($punkty_przeciwnik*10)." where gracz = ".$uzytkownik['gracz']); 
					echo "
						<p class='note'>Wygrałeś sparing</p><br class='clear'>
						<p>Wygrałeś swój sparing! Odbierasz wynagrodzenie w wysokości ".($punkty_przeciwnik*10)."$.</p>
						<p>Niestety nie udało Ci się zmienić miejsca w rankingu.</p>
					";
					$uzytkownik['akcje'] -= 50;
					$uzytkownik['kasa'] += $punkty_przeciwnik*10;
					
					// wyślij info do wyzwanego gracza o przebiegu walki
					mysql_query("insert into ring_poczta (od, do, typ, tytul, tresc, data)
					value(1,".$vs['gracz'].",1,'Pojedynek z ".$uzytkownik['login']."','Gracz wyzwał Cię na pojedynek i wygrał. Nie udało mu się zająć Twojego miejsca',now())");
				
				} else {

					mysql_query("update ring_gracze set akcje = akcje - 50, kasa = kasa + ".($punkty_przeciwnik*50).", ranking = ".$vs['ranking']." where gracz = ".$uzytkownik['gracz']);
					
					mysql_query("update ring_gracze set  ranking = ".$uzytkownik['ranking']." where gracz = ".$vs['gracz']);

					echo "
						<p class='note'>Wygrałeś sparing</p><br class='clear'>
						<p>Wygrałeś swój sparing! Odbierasz wynagrodzenie w wysokości ".($punkty_przeciwnik*50)."$.</p>
						<p>Zajmujesz miejsce przeciwnika! Awansowałeś na ".$vs['ranking']." miejsce!</p>
					";
					$uzytkownik['akcje'] -= 50;
					$uzytkownik['kasa'] += $punkty_przeciwnik*50;
					$uzytkownik['ranking'] = $vs['ranking'];
					
					// wyślij info do wyzwanego gracza o przebiegu walki
					mysql_query("insert into ring_poczta (od, do, typ, tytul, tresc, data)
					value(1,".$vs['gracz'].",1,'Pojedynek z ".$uzytkownik['login']."','Gracz wyzwał Cię na pojedynek i wygrał. Przeciwnik zajmuje Twoje miejsce w rankingu i spadasz na ".$pozycja." pozycję!',now())");
				}
				
			} else {
				mysql_query("update ring_gracze set akcje = akcje - 50, kasa = kasa + ".($punkty_przeciwnik*10)." where gracz = ".$uzytkownik['gracz']); 
				echo "
					<p class='note'>Przegrałeś sparing</p><br class='clear'>
					<p>Przegrałeś i odchodzisz z niczym.</p>
				";
				$uzytkownik['akcje'] -= 50;
				
				// wyślij info do wyzwanego gracza o przebiegu walki
				mysql_query("insert into ring_poczta (od, do, typ, tytul, tresc, data)
				value(1,".$vs['gracz'].",1,'Pojedynek z ".$uzytkownik['login']."','Gracz wyzwał Cię na pojedynek i przegrał. Obroniłeś swoją pozycję w rankingu.',now())");
			}
			
		}
	}
}


$przeciwnicy = mysql_query("select * from ring_gracze where ranking <= ".$uzytkownik['ranking']." and gracz  != ".$uzytkownik['gracz']." limit 5");

if(mysql_num_rows($przeciwnicy) == 0){
	echo "<p class='note'>Brak przeciwników sklasyfikowanych wyżej niż ty</p><br class='clear'>";
} else {
	echo "
	<table id='rank'>
		<tr style='background:#8F8F8F;'>
			<th>Pozycja</th>
			<th>Gracz</th>
			<th></th>
		</tr>
	";

	if($uzytkownik['akcje'] >= 50){
		while($przeciwnik = mysql_fetch_array($przeciwnicy)){
			$i++;
			if($i % 2 == 0) $styl = " style='background:#B2B2B2'"; else $styl="";
			echo "
			<tr align='center' ".$styl.">
				<td>".$przeciwnik['ranking']."</td>
				<td>".$przeciwnik['login']."</td>
				<td><a href='walki.php?walcz=".$przeciwnik['gracz']."'>walcz</a></td>
			</tr>";
		}
	} else {
		while($przeciwnik = mysql_fetch_array($przeciwnicy)){
			$i++;
			if($i % 2 == 0) $styl = " style='background:#B2B2B2'"; else $styl="";
			echo "
			<tr align='center' ".$styl.">
				<td>".$przeciwnik['ranking']."</td>
				<td>".$przeciwnik['login']."</td>
				<td>za mało punktów akcji</td>
			</tr>";
		}
	}
	echo "</table>";
}



//pobieramy zawartość prawego bloku
require_once('prawy_blok.php');

//pobieramy stopkę
require_once('dol_strony.php');

//wyłączamy bufor
ob_end_flush();
?> 