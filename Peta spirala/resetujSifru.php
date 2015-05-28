<?php
session_start();

require "dbkonekcija.php";

require "provjeriSesiju.php";

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$novaSifra = generateRandomString();
echo "Vaša nova šifra: " . $novaSifra;

$promjeniSifrustmt = $veza->prepare("UPDATE `wt_baza`.`korisnici` SET `password` = ? WHERE `korisnici`.`username` = ?;");
$promjeniSifrustmt->bindParam(1, $novaSifra);
$promjeniSifrustmt->bindParam(2, $_SESSION['login_user']);
$rezultatPromjene = $promjeniSifrustmt->execute();

if($rezultatPromjene){
	$userIzBaze = $veza->prepare("SELECT id, username, password, email FROM korisnici WHERE username = ?;");
	$userIzBaze->bindParam(1, $_SESSION['login_user']);
	$userIzBaze->execute();
	$userObjekat = $userIzBaze->fetch();

	$message = "Vaša nova šifra je :" . $novaSifra;
	$message = wordwrap($message, 70, "\r\n");

	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=UTF-8";
	$headers[] = "From: Edin Congo <EdinCongo@domain.com>";
	$headers[] = "CC: Vedran Ljubović <vljubovic@etf.unsa.ba>";
	$headers[] = "Subject: Promjena passworda";

	$posnlanMail = mail($userObjekat['email'], 'Promjena passworda', $message, implode("\r\n", $headers));	
}

?>

<div class="detaljniTekstNovosti">
	<a class="dugmeDetalji" href="#" onclick="navigacija('logout.php');">Nazad na naslovnu</a>
</div>