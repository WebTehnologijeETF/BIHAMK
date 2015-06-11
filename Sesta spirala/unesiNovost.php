<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

$autor = htmlentities($_REQUEST['autor'], ENT_QUOTES);
$naslov = htmlentities($_REQUEST['naslov'], ENT_QUOTES);
$slika = htmlentities($_REQUEST['slika'], ENT_QUOTES);
$osnovniTekst = htmlentities($_REQUEST['osnovniTekst'], ENT_QUOTES);
$detaljniTekst = htmlentities($_REQUEST['detaljniTekst'], ENT_QUOTES);

//$autor = 'Edin Čongo PHP';
//$naslov = 'M17 Udes iz koda';
//$slika = 'http://3.imimg.com/data3/VO/XH/MY-3971701/road-construction-work-service-250x250.jpg';
//$osnovniTekst = 'Iz koda: Usljed saobraćanje nezgode, saobraćaj se odvija usporeno.';
//$detaljniTekst = 'Iz koda: Poteškoće u saobraćaju. Trenutno se saobraćaj odvija otežano u oba pravca. Molimo vozače na dodatni oprez i smirenost. MUP KS obavlja uviđaj.';

$insertStatement = $veza->prepare("INSERT INTO `wt_baza`.`novosti` (`id`, `datum`, `autor`, `naslov`, `slika`, `osnovniTekst`, `detaljniTekst`)
 VALUES (NULL, NOW(), ?, ?, ?, ?, ?);");

$insertStatement->bindParam(1, $autor);
$insertStatement->bindParam(2, $naslov);
$insertStatement->bindParam(3, $slika);
$insertStatement->bindParam(4, $osnovniTekst);
$insertStatement->bindParam(5, $detaljniTekst);

// insert one row
//$name = 'one';
//$value = 1;
$rvalue = $insertStatement->execute();

echo "Hello world!";
echo $rvalue;

?>