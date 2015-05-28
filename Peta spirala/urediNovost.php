<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$autor = htmlentities($_REQUEST['autor'], ENT_QUOTES);
$naslov = htmlentities($_REQUEST['naslov'], ENT_QUOTES);
$slika = htmlentities($_REQUEST['slika'], ENT_QUOTES);
$osnovniTekst = htmlentities($_REQUEST['osnovniTekst'], ENT_QUOTES);
$detaljniTekst = htmlentities($_REQUEST['detaljniTekst'], ENT_QUOTES);
$idNovosti = htmlentities($_REQUEST['idNovosti'], ENT_QUOTES);

$updateStatement = $veza->prepare("UPDATE `wt_baza`.`novosti` SET `datum` = NOW(), `autor` = :autor, `naslov` = :naslov, `slika` = :slika, `osnovniTekst` = :osnovniTekst, `detaljniTekst` = :detaljniTekst WHERE `novosti`.`id` = :idNovosti;");

echo "Autor: " . $autor. " ";
echo "Naslov: " . $naslov . " ";
echo "Slika: " . $slika . " ";
echo "OTekst: " .  $osnovniTekst . " ";
echo "DTekst: " .  $detaljniTekst . " ";
echo "IDNovosti: " . $idNovosti . " ";

$rvalue = $updateStatement->execute( array(":autor" => $autor, ":naslov" => $naslov, ":slika" => $slika, ":osnovniTekst" => $osnovniTekst, ":detaljniTekst" => $detaljniTekst, ":idNovosti" => $idNovosti ));

echo "Hello world!";
echo $rvalue;

?>