<?php
	require 'ucitavanjeNovosti.php';
?>

<?php 
	$indeks =  $_REQUEST['indeks'];
	if(!($indeks > count($novostiNiz)) && !($indeks < 0)){
		$novostObjekat = $novostiNiz[$indeks];
	}
	else{
		die("Indeks vijesti ne postoji!");
	} 
?>

<div class="novostKontejner">
	<div class="naslovNovosti">
		<?= ucfirst(strtolower($novostObjekat['naslov'])) ?>
	</div>
	<div class="autorIDatumNovosti">
		<?= $novostObjekat['autor'] ?> - <?= $novostObjekat['datum'] ?>
	</div>

	<?php
	//ako postoji slika, prikazi je
		if(preg_replace('/\s+/', '', $novostObjekat['slika']) != "")
		{
			?>
			<div class="slikaNovosti">
				<img src="<?= $novostObjekat['slika'] ?>" height="250" width="250">
			</div>
			<?php
		}
	?>
	<div class="osnovniTekstNovosti">
		<?= $novostObjekat['osnovniTekst'] ?>
	</div>
	<div class="detaljniTekstNovosti">
		<?= $novostObjekat['detaljniTekst'] ?>
	</div>
	<div class="detaljniTekstNovosti">
		<a class="dugmeDetalji" href="#" onclick="navigacija('naslovnica.html');">Nazad na naslovnu</a>
	</div>
</div>