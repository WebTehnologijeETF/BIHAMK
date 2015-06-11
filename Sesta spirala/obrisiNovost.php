<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$idNovosti = htmlentities($_REQUEST['id'], ENT_QUOTES);

$deleteStatement = $veza->prepare("DELETE FROM komentari WHERE novost = ?");
$deleteStatement->bindParam(1, $idNovosti);

$rvalueKomentari = $deleteStatement->execute();

$deleteStatement = $veza->prepare("DELETE FROM novosti WHERE id = ?");
$deleteStatement->bindParam(1, $idNovosti);

$rvalueNovosti = $deleteStatement->execute();

//echo "Hello world!";
echo "Izbrisano je : " . $rvalueKomentari . " komentara i " . $rvalueNovosti . " novost(i).";
?>