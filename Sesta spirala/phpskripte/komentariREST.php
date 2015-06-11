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
		$trazeniKomentar = $veza->prepare("SELECT id,datum,autor,email,tekst,novost FROM `komentari` WHERE id = ?");
		$trazeniKomentar->bindParam(1, $indeks);
		$trazeniKomentar->execute();
		$komentarObjekat = $trazeniKomentar->fetch();

		if(!isset($komentarObjekat)){
			die("Indeks komentara ne postoji!");
		} 
		print "{ \"komentar\": " . json_encode($komentarObjekat) . "}";
	}
	else{
		$komentariNiz = array();

		$rezultat = $veza->query("SELECT id,datum,autor,email,tekst,novost FROM `komentari` ORDER BY datum DESC");

		if(!$rezultat){
			$greska = $veza->errorInfo();
			print "SQL greska: " . $greska[2];
			exit();	
		}

		foreach($rezultat as $row):
				$komentar['id'] = $row['id'];
				$komentar['datum'] = $row['datum'];
				$komentar['autor'] = $row['autor'];
				$komentar['email'] = $row['email'];
				$komentar['tekst'] = $row['tekst'];
				$komentar['novost'] = $row['novost'];
				array_push($komentariNiz, $komentar);
		endforeach;

		print "{ \"komentari\": " . json_encode($komentariNiz) . "}";
	}
}

function rest_post($request, $data){
	require "dbkonekcija.php";

	$autor = htmlentities($data['autor'], ENT_QUOTES);
	$email = htmlentities($data['email'], ENT_QUOTES);
	$tekst = htmlentities($data['tekst'], ENT_QUOTES);
	$novostId = htmlentities($data['idNovosti'], ENT_QUOTES);

	$insertStatement = $veza->prepare("INSERT INTO `wt_baza`.`komentari` (`id`, `datum`, `autor`, `email`, `tekst`, `novost`)
	 VALUES (NULL, NOW(), ?, ?, ?, ?);");

	$insertStatement->bindParam(1, $autor);
	$insertStatement->bindParam(2, $email);
	$insertStatement->bindParam(3, $tekst);
	$insertStatement->bindParam(4, $novostId);

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
	$indeks =  end($urlParams);

	$idKomentara = htmlentities($indeks, ENT_QUOTES);

	$deleteStatement = $veza->prepare("DELETE FROM komentari WHERE id = ?");
	$deleteStatement->bindParam(1, $idKomentara);

	$rvalueKomentar = $deleteStatement->execute();

	if($rvalueKomentar){
		echo "OK";
	}
}

function rest_put($request, $data){
	echo "Nije podržano.";
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