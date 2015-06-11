<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$username = htmlentities($_REQUEST['username'], ENT_QUOTES);

// Master admin
if($username != "edincongo"){
	$obrisiKorisnikaStmt = $veza->prepare("DELETE FROM `wt_baza`.`korisnici` WHERE `korisnici`.`username` = ?");
	$obrisiKorisnikaStmt->bindParam(1, $username);
	$rezultat = $obrisiKorisnikaStmt->execute();
}

?>