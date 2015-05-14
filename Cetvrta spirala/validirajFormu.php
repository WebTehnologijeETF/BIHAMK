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

$svaPolja = array($t_imeprezime, $t_datum, $t_kanton, $t_grad, 
					$t_postanskiBroj, $t_adresa, $t_telefon,
					$t_potvrda, $t_email, $t_broj,);
$sveGreske = array();
$formaValidna = true;

foreach($svaPolja as $indeks=>$trenutnoPolje):
	$sveGreske[$indeks] = "";
	$sadrzajPolja = preg_replace('/\s+/', '', $trenutnoPolje);
	// Polje broj nije obavezno, zato je indeks < 9
	if($sadrzajPolja == "" && $indeks < 9){
		$sveGreske[$indeks]  = "Polje ne smije biti prazno!";
	}
	// Provjeri da li je broj 
	if($indeks == 7 || $indeks == 6){
		if(!is_numeric($trenutnoPolje)) {
        	$sveGreske[$indeks]  = "Unesena vrijednost nije broj";
    	}
	}
	// Provjeri email
	if($indeks == 8){
		if(!filter_var($trenutnoPolje, FILTER_VALIDATE_EMAIL)) {
        	$sveGreske[$indeks]  = "E-mail adresa nije validna!";
    	}
	}
endforeach;

// Cross validacja telefona
if($svaPolja[6] != $svaPolja[7]){
	$sveGreske[7]  = "Broj ne odgovara prethodno unesenom broju";
}

foreach($sveGreske as $indeks=>$trenutnaGreska):
	if($trenutnaGreska != ""){
		$formaValidna = false;
	}
endforeach;

?>

<!DOCTYPE html>
<html>

<?php require "head.php"; ?>

<body>

	<?php require "header.php"; ?>
	
	<div class="sadrzaj">
		
	<?php require "navigacija.php"; ?>

		<div id="sadrzaj_tab">


<?php 
if($formaValidna){

 ?>

<h3>Provjerite da li ste ispravno popunili kontakt formu</h3>

<hr/>

<div class="formaKontejner">
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Ime i prezime:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_imeprezime ?>
		</div>
	</div>
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Datum:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_datum ?>
		</div>
	</div>

	<div class="formaRed">
		<div class="labelaZaRedForme">
			Kanton:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_kanton ?>
		</div>
	</div>
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Grad:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_grad ?>
		</div>
	</div>

	<div class="formaRed">
		<div class="labelaZaRedForme">
			Poštanski broj:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_postanskiBroj ?>
		</div>
	</div>
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Adresa:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_adresa ?>
		</div>
	</div>

	<div class="formaRed">
		<div class="labelaZaRedForme">
			Telefon:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_telefon ?>
		</div>
	</div>
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Potvrda telefona:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_potvrda ?>
		</div>
	</div>

	<div class="formaRed">
		<div class="labelaZaRedForme">
			Email:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_email ?>
		</div>
	</div>
	<div class="formaRed">
		<div class="labelaZaRedForme">
			Članski broj:
		</div>
		<div class="vrijednostRedaForme">
			<?= $t_broj ?>
		</div>
	</div>
</div>

<hr/>

<div>Da li ste sigurni da želite poslati ove podatke?</div>
</br>
<div>
	<input type="button" name="siguranSam" value="Siguran sam" onclick="posaljiMail();">
</div>
</br>
<div>
	Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke
</div>


<br/>


 <?php 
 }
 ?>

<div id="centriranNaslov">
	<p>Postani član BIHAMK-a</p>
</div>

<p id="tekstCentriran">
	Na jednostavan način postanite članom bosanskohercegovačkog auto-moto kluba BIHAMK ! <br>
	Dovoljno je samo da ispunite formu ispod, a za više informacija pročitajte <a href="http://www.bihamk.ba/index.php?option=com_content&amp;view=article&amp;id=91&amp;Itemid=125" target="_blank">Uslove korištenja</a>. 
	<!--link na uslove sa originalne stranice BIHAMK-a, zbog toga u validatoru ispisuju kao gresku-->
</p>

<br>
		

<form id="forma" method="POST" action="validirajFormu.php" onSubmit="ValidacijaForme();">
	<table id="formaClan">
		<tr>
			<td class="celijaLabel">Ime i prezime</td>
			<td class="celijaInput">
				<input type="text" id="imeprezime" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[0] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="imeprezime" value="<?= $t_imeprezime ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaIme"><?= $sveGreske[0]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Datum rođenja</td>
			<td class="celijaInput">
				<input type="text" id="datum"
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[1] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="datum" value="<?= $t_datum ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaDatum"><?= $sveGreske[1]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Kanton</td>
			<td class="celijaInput">
				<input type="text" id="kanton"
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[2] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="kanton" value="<?= $t_kanton ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaKanton"><?= $sveGreske[2]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Grad / mjesto</td> 
			<td class="celijaInput">
				<input type="text" id="grad" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[3] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>"name="grad" value="<?= $t_grad ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaGrad"><?= $sveGreske[3]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Poštanski broj</td> 
			<td class="celijaInput"><input type="text" id="postanskiBroj" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[4] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="postanskiBroj" value="<?= $t_postanskiBroj ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaPostanskiBroj"><?= $sveGreske[4]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Adresa</td> 
			<td class="celijaInput">
				<input type="text" name="adresa" id="adresa" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[5] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" value="<?= $t_adresa ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaAdresa"><?= $sveGreske[5]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Kontakt telefon</td>
			<td class="celijaInput"><input type="text" id="telefon" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[6] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="telefon" value="<?= $t_telefon ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaTelefon"><?= $sveGreske[6]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Potvrdi kontakt telefon</td>
			<td class="celijaInput">
				<input type="text" name="potvrda" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[7] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" id="potvrda" value="<?= $t_potvrda ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaTelefonP"><?= $sveGreske[7]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">E-mail</td>
			<td class="celijaInput">
				<input type="text" id="email" 
				class="
					<?php
					//setuj css za polje
					 if($sveGreske[8] != ""){
					 	echo "nevalidnoPoljeForme";
					 }
					 else{
					 	echo "validnoPoljeForme";	
					 }
				 	?>" name="email" value="<?= $t_email ?>">
			</td>
			<td class="celijaError greskaTekstForma"><div id="greskaEmail"><?= $sveGreske[8]; ?></div></td>
		</tr>
		<tr>
			<td class="celijaLabel">Članski broj</td>
			<td class="celijaInput"><input type="text" id="broj" name="broj" value="<?= $t_broj ?>"></td>
			<td class="celijaLabel"></td>
		</tr>
		<tr>
			<td class="celijaLabel">&nbsp;</td>
			<td class="celijaInput"><input type="submit" value="Šalji"> <input type="reset" value="Poništi"></td>
			<td class="celijaLabel"></td>
	</table>
</form>

</div>
</div>

<?php require "footer.php"; ?>

	<script src="skripta.js"></script>
</body>
</html>