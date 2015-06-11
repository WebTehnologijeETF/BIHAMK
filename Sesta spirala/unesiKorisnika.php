<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$username = htmlentities($_REQUEST['username'], ENT_QUOTES);
$password = htmlentities($_REQUEST['password'], ENT_QUOTES);
$email = htmlentities($_REQUEST['email'], ENT_QUOTES);

$unesiKorisnikaStmt = $veza->prepare("INSERT INTO `wt_baza`.`korisnici` (`id`, `username`, `password`, `email`) VALUES (NULL, ?, ?, ?);");
$unesiKorisnikaStmt->bindParam(1, $username);
$unesiKorisnikaStmt->bindParam(2, $password);
$unesiKorisnikaStmt->bindParam(3, $email);
$rezultat = $unesiKorisnikaStmt->execute();

echo $rezultat;

?>