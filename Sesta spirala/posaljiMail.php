<?php
session_start(); 
?>
<html>

<?php require "head.php"; ?>
<body>

<?php require "header.php"; ?>

<div class="sadrzaj">

	<?php require "navigacija.php"; ?>

	<div id="sadrzaj_tab">

<?php 

$t_imeprezime = htmlentities($_REQUEST['imeprezime'], ENT_QUOTES);
$t_datum = htmlentities($_REQUEST['datum'], ENT_QUOTES);
$t_kanton = htmlentities($_REQUEST['kanton'], ENT_QUOTES);
$t_grad = htmlentities($_REQUEST['grad'], ENT_QUOTES);
$t_postanskiBroj = htmlentities($_REQUEST['postanskiBroj'], ENT_QUOTES);
$t_adresa = htmlentities($_REQUEST['adresa'], ENT_QUOTES);
$t_telefon = htmlentities($_REQUEST['telefon'], ENT_QUOTES);
$t_potvrda = htmlentities($_REQUEST['potvrda'], ENT_QUOTES);
$t_email = htmlentities($_REQUEST['email'], ENT_QUOTES);
$t_broj = htmlentities($_REQUEST['broj'], ENT_QUOTES);

$message =
"Poslani su sljedeći podaci sa kontakt forme: \r\n\r\n
\tIme i prezme: " . $t_imeprezime . "\r\n
\tDatum rođenja: " . $t_datum . "\r\n
\tKanton: " . $t_kanton . "\r\n
\tGrad / Mjesto: " . $t_grad . "\r\n
\tPoštanski broj: " . $t_postanskiBroj . "\r\n
\tAdresa: " . $t_adresa . "\r\n
\tTelefon: " . $t_telefon . "\r\n
\tPotvrda telefona: " . $t_potvrda . "\r\n
\tEmail: " . $t_email . "\r\n
\tČlanski broj: " . $t_broj . "\r\n";

$message = wordwrap($message, 70, "\r\n");

$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/plain; charset=UTF-8";
$headers[] = "From: Edin Congo <EdinCongo@domain.com>";
$headers[] = "CC: Vedran Ljubović <vljubovic@etf.unsa.ba>";
$headers[] = "Reply-To: ".$t_imeprezime." <".$t_email.">";
$headers[] = "Subject: Kontakt forma zahtjev";

$posnlanMail = mail('econgo1@etf.unsa.ba', 'Kontakt forma zahtjev', $message, implode("\r\n", $headers));
if($posnlanMail){
	echo "<br/> <br/> Zahvaljujemo se što ste nas kontaktirali <br/> <br/>";
}
else{
	echo "<br/> <br/> Greška u slanju maila. <br/> <br/>";
}

?>
	</div>
</div>

<?php require "footer.php"; ?>

<script src="skripta.js"></script>

</body>
</html>


