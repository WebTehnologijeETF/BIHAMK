<?php
// Ucitavanje novosti iz datoteke

$novostiTxt = glob('novosti/*.txt');
$novostiNiz = array();

foreach($novostiTxt as $indeks=>$nazivFajla):
	if (($nazivFajla == '.' || $nazivFajla == '..' )) { 
        continue;
    }
    else
    {
		$novostTxt = fopen($nazivFajla, "r") or die("Neuspješno otvaranje fajla!");
		$novost['datum'] = htmlentities(fgets($novostTxt), ENT_QUOTES);
		$novost['autor'] = htmlentities(fgets($novostTxt), ENT_QUOTES);
		$novost['naslov'] = htmlentities(fgets($novostTxt), ENT_QUOTES);
		$novost['slika'] = htmlentities(fgets($novostTxt), ENT_QUOTES);
		$novost['osnovniTekst'] = "";
		$novost['detaljniTekst'] = "";
		$osnovniTekstKraj = "false";
		while(!feof($novostTxt)) {
			$trenutniRed = fgets($novostTxt);
			$sadrzajReda = preg_replace('/\s+/', '', $trenutniRed);
			if($sadrzajReda == "--"){
				$osnovniTekstKraj = "true";
				continue;
			}
			if($osnovniTekstKraj == "false"){
				$novost['osnovniTekst'] = $novost['osnovniTekst'] . htmlentities($trenutniRed, ENT_QUOTES);
			}
			else{
				$novost['detaljniTekst'] = $novost['detaljniTekst'] . htmlentities($trenutniRed, ENT_QUOTES);
			}
		}
		array_push($novostiNiz, $novost);
		fclose($novostTxt);
    }
endforeach; 

//sortiranje po datumu, testirati jos malo

usort($novostiNiz, function($a, $b) {
  $ad = date_create_from_format('d.m.yy. h:m:s', $a['datum']);
  $bd = date_create_from_format('d.m.yy. h:m:s', $b['datum']);

  if ($ad == $bd) {
    return 0;
  }

  return $ad < $bd ? 1 : -1;
});

?>
