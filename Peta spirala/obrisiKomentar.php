<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$idKomentara = htmlentities($_REQUEST['id'], ENT_QUOTES);

$deleteStatement = $veza->prepare("DELETE FROM komentari WHERE id = ?");
$deleteStatement->bindParam(1, $idKomentara);

$rvalueKomentar = $deleteStatement->execute();

//echo "Hello world!";
echo "Izbrisano je : " . $rvalueKomentar . " komentar(a)";
?>