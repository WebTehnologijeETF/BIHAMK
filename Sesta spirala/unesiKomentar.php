<?php
require "dbkonekcija.php";

$autor = htmlentities($_REQUEST['autor'], ENT_QUOTES);
$email = htmlentities($_REQUEST['email'], ENT_QUOTES);
$tekst = htmlentities($_REQUEST['tekst'], ENT_QUOTES);
$novostId = htmlentities($_REQUEST['idNovosti'], ENT_QUOTES);

$insertStatement = $veza->prepare("INSERT INTO `wt_baza`.`komentari` (`id`, `datum`, `autor`, `email`, `tekst`, `novost`)
 VALUES (NULL, NOW(), ?, ?, ?, ?);");

$insertStatement->bindParam(1, $autor);
$insertStatement->bindParam(2, $email);
$insertStatement->bindParam(3, $tekst);
$insertStatement->bindParam(4, $novostId);

$rvalue = $insertStatement->execute();

//echo "Hello world!";
echo $rvalue;

?>