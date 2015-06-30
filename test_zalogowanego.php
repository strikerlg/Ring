<?php
//sprawdzamy czy w sesji zapisano nr gracza, czyli czy jest zalogowany
if(empty($_SESSION['user'])){
    //nie jest zalogowany, przenieś do strony logowania
    header("Location: logowanie.php");
} else {
    //dodatkowo zabezpieczymy sesję, rzutując wartość na liczbę
    $_SESSION['user'] = (int)$_SESSION['user'];

    //pobieramy dane gracza z bazy
    $uzytkownik = mysql_fetch_array(mysql_query("select *, (select count(*) from ring_poczta where typ = 1 and do = gracz and status = 0) as poczta from ring_gracze where gracz = ".$_SESSION['user']));
	
	
    //jeżeli nie pobrało gracza, to znaczy, że ktoś kombinuje coś z sesją i trzeba go wylogować
    if(empty($uzytkownik)) header("Location: wyloguj.php");

	//jeżeli skończył się okres vip
	if(($uzytkownik['vip'] > 0) && ($uzytkownik['vip'] < time())){
		mysql_query("update ring_gracze set vip = 0, akcje_max = 100 where gracz = ".$uzytkownik['gracz']);
		$uzytkownik['vip'] = 0;
		$uzytkownik['akcje_max'] = 100;
		if($uzytkownik['akcje'] > 100) $uzytkownik['akcje'] = 100;
	}

}
?> 