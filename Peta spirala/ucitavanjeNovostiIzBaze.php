<?php
// Ucitavanje novosti iz baze

require "dbkonekcija.php";

$novostiNiz = array();

$rezultat = $veza->query("SELECT id, datum, autor, naslov, slika, osnovniTekst, detaljniTekst FROM novosti");

if(!$rezultat){
	$greska = $veza->errorInfo();
	print "SQL greska: " . $greska[2];
	exit();	
}

foreach($rezultat as $row):
		//echo $row['naslov'] . " " . $row['autor'];
		$novost['id'] = $row['id'];
		$novost['datum'] = $row['datum'];
		$novost['autor'] = $row['autor'];
		$novost['naslov'] = $row['naslov'];
		$novost['slika'] = $row['slika'];
		$novost['osnovniTekst'] = $row['osnovniTekst'];
		$novost['detaljniTekst'] = $row['detaljniTekst'];
		array_push($novostiNiz, $novost);
endforeach;
?>
