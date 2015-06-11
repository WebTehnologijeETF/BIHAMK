<?php


function zag(){
	header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
	header('Content-Type: text/html');
	header('Access-Control-Allow-Origin: *');
}

function rest_get($request, $data){
	require "dbkonekcija.php";

	$novostiNiz = array();

	$rezultat = $veza->query("SELECT id, datum, autor, naslov, slika, osnovniTekst, detaljniTekst FROM novosti ORDER BY datum DESC");

	if(!$rezultat){
		$greska = $veza->errorInfo();
		print "SQL greska: " . $greska[2];
		exit();	
	}

	foreach($rezultat as $row):
			//echo $row['naslov'] . " " . $row['autor'];
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

function rest_post($request, $data) { echo "POST Uspjesan";}
function rest_delete($request) {echo "DELETE Uspjesan";}
function rest_put($request, $data) { echo "PUT Uspjesan";}
function rest_error($request) { echo "Došlo je do greške.";}

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