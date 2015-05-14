<?php
require 'ucitavanjeNovosti.php';
?>


<?php 
// Ispis novosti
foreach($novostiNiz as $index=>$novostObjekat):

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

	<?php
	//ako postoji detaljni tekst, prikazi dugme
	//$novostObjekat['detaljniTekst'] 
		if(preg_replace('/\s+/', '', $novostObjekat['detaljniTekst']) != "")
		{
			?>
			<div class="detaljniTekstNovosti">
				<a class="dugmeDetalji" href="#" onclick="prikaziDetaljno(<?= $index ?>);">Detaljnije...</a>
			</div>
			<?php
		}
	?>
</div>

<?php 

//echo '<div>'.$novostObjekat['naslov'].'</div>';

endforeach; 

?>
