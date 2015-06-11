<?php
session_start();
require 'ucitavanjeNovostiIzBaze.php';
?>


<?php 
// Ispis novosti
foreach($novostiNiz as $index=>$novostObjekat):

$brojKomentaraStmt = $veza->prepare("SELECT COUNT(*) FROM komentari where novost = ?;");
$brojKomentaraStmt->bindParam(1, $novostObjekat['id']);
$brojKomentaraStmt->execute();
$brojKomentaraRez = $brojKomentaraStmt->fetch();
$brojKomentara = $brojKomentaraRez['COUNT(*)'];

?>
<div class="novostKontejner">
	<div class="naslovNovosti">
		<?= ucfirst(mb_strtolower($novostObjekat['naslov'], 'UTF-8')) ?>
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
				<a class="dugmeDetalji" href="#" onclick="prikaziDetaljno(<?= $novostObjekat['id'] ?>);">Detaljnije...</a>
			</div>
			<?php
		}
	?>

	<div class="detaljniTekstNovosti">
		<a class="dugmeDetalji" href="#" onclick="prikaziDetaljno(<?= $novostObjekat['id'] ?>);">Komentari(<?= $brojKomentara ?>)</a>
	</div>
</div>
</br>
<?php 

//echo '<div>'.$novostObjekat['naslov'].'</div>';

endforeach; 

?>

<?php if(isset($_SESSION['login_user'])){
?>
	
<div class="novostKontejner">
	<div class="naslovNovosti">
		Unesi novost
	</div>
	<div id="unesiNovost">
		<div>
			<p>Autor:</p>
			<input type="text" id="novostAutor" name="novostAutor">
			<p>Naslov: </p>
			<input type="text" id="novostNaslov" name="novostNaslov">
			<p>Slika: </p>
			<input type="text" id="novostSlika" name="novostSlika">
			<p>Osnovni tekst: </p>
			<textarea id="naslovOsnovniTekst" rows="4" cols="50" maxlength="250"></textarea>
			<p>Detaljni tekst: </p>
			<textarea id="naslovDetaljniTekst" rows="10" cols="50" maxlength="2500"></textarea>
			<br/>
			<input type="submit" id="novostPosalji" name="novostPosalji" value="Unesi novost" onclick='unesiNovost();'>
		</div>
	</div>
</div>

<?php } ?>