<?php
session_start();

require "dbkonekcija.php";

if(!isset($_SESSION['login_user'])){
	echo "Nemate pristup.";
	header('HTTP/1.1 401 Unauthorized', true, 401);
	exit();
}

$korisniciStmt = $veza->prepare("SELECT id, username, password, email FROM `korisnici`;");
$korisniciStmt->execute();
$korisnici = $korisniciStmt->fetchAll();

?>
<div class="novostKontejner">
	<div class="naslovNovosti">
		Korisnici(<?= count($korisnici) ?>)
	</div>
</br>
	<?php foreach($korisnici as $indeks=>$korisnik): 
    ?>
	
	<div>
	<?= $korisnik['username'] ?> 

	<?php
	if($indeks!=0){
	?>
	<a class="dugmeDetalji" href="#" onclick="obrisiKorisnika('<?= $korisnik['username'] ?>');">Obriši</a>
	<?php
	}
	?>
</div>
</br>
<?php

endforeach;
?>
</div>



<div class="detaljniTekstNovosti">
	<a class="dugmeDetalji" href="#" onclick="navigacija('naslovnica.html');">Nazad na naslovnu</a>
</div>

<div class="novostKontejner">
	<div class="naslovNovosti">
		Unesi korisnika
	</div>
	<div id="unesiNovost">
		<div>
			<p>Username:</p>
			<input type="text" id="korisnikUsername" placeholder="username" name="korisnikUsername">
			<p>Password: </p>
			<input type="password" id="korisnikPassword" placeholder="********" name="korisnikPassword">
			<p>Email: </p>
			<input type="text" id="korisnikEmail" placeholder="someone@example.ba" name="korisnikEmail">
			</br>
			</br>
			<input type="submit" id="posaljiKorisnika" name="posaljiKorisnika" value="Unesi korisnika" onclick='unesiKorisnika();'>
		</div>
	</div>
</div>

