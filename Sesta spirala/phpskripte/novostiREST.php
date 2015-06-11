<?php

function zag(){
	header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
	header('Content-Type: text/html');
	header('Access-Control-Allow-Origin: *');
}

function rest_get($request, $data){
	require "dbkonekcija.php";

	$urlParams = explode('/',$request);
	$indeks =  end($urlParams);

	if ($indeks != null && $indeks > 0){
		$trazenaNovost = $veza->prepare("SELECT id, datum, autor, naslov, slika, osnovniTekst, detaljniTekst FROM novosti where id = ?");
		$trazenaNovost->bindParam(1, $indeks);
		$trazenaNovost->execute();
		$novostObjekat = $trazenaNovost->fetch();

		$komentariStmt = $veza->prepare("SELECT id,datum,autor,email,tekst,novost FROM `komentari` WHERE novost = ? ORDER BY datum DESC");
		$komentariStmt->bindParam(1, $indeks);
		$komentariStmt->execute();
		$komentari = $komentariStmt->fetchAll();

		$novostObjekat['komentari'] = $komentari;

		if(!isset($novostObjekat)){
			die("Indeks vijesti ne postoji!");
		} 
		print "{ \"novost\": " . json_encode($novostObjekat) . "}";
	}
	else{
		$novostiNiz = array();

		$rezultat = $veza->query("SELECT id, datum, autor, naslov, slika, osnovniTekst, detaljniTekst FROM novosti ORDER BY datum DESC");

		if(!$rezultat){
			$greska = $veza->errorInfo();
			print "SQL greska: " . $greska[2];
			exit();	
		}

		foreach($rezultat as $row):
				$novost['id'] = $row['id'];

				$komentariStmt = $veza->prepare("SELECT id,datum,autor,email,tekst,novost FROM `komentari` WHERE novost = ? ORDER BY datum DESC");
				$komentariStmt->bindParam(1, $novost['id']);
				$komentariStmt->execute();
				$novost['komentari'] = $komentariStmt->fetchAll();

				$novost['datum'] = $row['datum'];
				$novost['autor'] = $row['autor'];
				$novost['naslov'] = $row['naslov'];
				$novost['slika'] = $row['slika'];
				$novost['osnovniTekst'] = $row['osnovniTekst'];
				$novost['detaljniTekst'] = $row['detaljniTekst'];
				array_push($novostiNiz, $novost);
		endforeach;

		print "{ \"novosti\": " . json_encode($novostiNiz) . "}";
	}
}

function rest_post($request, $data){
	session_start();

	require "dbkonekcija.php";
	require "provjeriSesiju.php";

	$autor = htmlentities($data['autor'], ENT_QUOTES);
	$naslov = htmlentities($data['naslov'], ENT_QUOTES);
	$slika = htmlentities($data['slika'], ENT_QUOTES);
	$osnovniTekst = htmlentities($data['osnovniTekst'], ENT_QUOTES);
	$detaljniTekst = htmlentities($data['detaljniTekst'], ENT_QUOTES);

	$insertStatement = $veza->prepare("INSERT INTO `wt_baza`.`novosti` (`id`, `datum`, `autor`, `naslov`, `slika`, `osnovniTekst`, `detaljniTekst`)
	 VALUES (NULL, NOW(), ?, ?, ?, ?, ?);");

	$insertStatement->bindParam(1, $autor);
	$insertStatement->bindParam(2, $naslov);
	$insertStatement->bindParam(3, $slika);
	$insertStatement->bindParam(4, $osnovniTekst);
	$insertStatement->bindParam(5, $detaljniTekst);

	$rvalue = $insertStatement->execute();

	if($rvalue){
		echo "OK";
	}
}

function rest_delete($request){
	session_start();

	require "dbkonekcija.php";
	require "provjeriSesiju.php";

	$urlParams = explode('/',$request);
	$idNovosti =  end($urlParams);

	$deleteStatement = $veza->prepare("DELETE FROM komentari WHERE novost = ?");
	$deleteStatement->bindParam(1, $idNovosti);

	$rvalueKomentari = $deleteStatement->execute();

	$deleteStatement = $veza->prepare("DELETE FROM novosti WHERE id = ?");
	$deleteStatement->bindParam(1, $idNovosti);

	$rvalueNovosti = $deleteStatement->execute();

	if($rvalue){
		echo "OK";
	}
}

function rest_put($request, $data){
	session_start();

	require "dbkonekcija.php";
	require "provjeriSesiju.php";

	$autor = htmlentities($data['autor'], ENT_QUOTES);
	$naslov = htmlentities($data['naslov'], ENT_QUOTES);
	$slika = htmlentities($data['slika'], ENT_QUOTES);
	$osnovniTekst = htmlentities($data['osnovniTekst'], ENT_QUOTES);
	$detaljniTekst = htmlentities($data['detaljniTekst'], ENT_QUOTES);
	$idNovosti = htmlentities($data['idNovosti'], ENT_QUOTES);

	$updateStatement = $veza->prepare("UPDATE `wt_baza`.`novosti` SET `datum` = NOW(), `autor` = :autor, `naslov` = :naslov, `slika` = :slika, `osnovniTekst` = :osnovniTekst, `detaljniTekst` = :detaljniTekst WHERE `novosti`.`id` = :idNovosti;");

	echo "Autor: " . $autor. " ";
	echo "Naslov: " . $naslov . " ";
	echo "Slika: " . $slika . " ";
	echo "OTekst: " .  $osnovniTekst . " ";
	echo "DTekst: " .  $detaljniTekst . " ";
	echo "IDNovosti: " . $idNovosti . " ";

	$rvalue = $updateStatement->execute( array(":autor" => $autor, ":naslov" => $naslov, ":slika" => $slika, ":osnovniTekst" => $osnovniTekst, ":detaljniTekst" => $detaljniTekst, ":idNovosti" => $idNovosti ));

	if($rvalue){
		echo "OK";
	}
}

function rest_error($request){
		echo "Došlo je do greške.";
}

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

switch ($method) {
	case 'PUT':
		parse_str(file_get_contents('php://input'), $put_vars);
		zag();
		$data = $put_vars;
		rest_put($request, $data);
		break;
	case 'POST':
		zag();
		$data = $_POST;
		rest_post($request, $data);
		break;
	case 'GET':
		zag();
		$data = $_GET;
		rest_get($request, $data);
		break;
	case 'DELETE':
		zag();
		rest_delete($request);
		break;
	default:
		header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
		rest_error($request);
		break;
}

?>