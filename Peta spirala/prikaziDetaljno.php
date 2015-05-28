<?php 
session_start();
require "dbkonekcija.php";

$indeks =  $_REQUEST['indeks'];

$trazenaNovost = $veza->prepare("SELECT id, datum, autor, naslov, slika, osnovniTekst, detaljniTekst FROM novosti where id = ?");
$trazenaNovost->bindParam(1, $indeks);
$trazenaNovost->execute();
$novostObjekat = $trazenaNovost->fetch();

$komentariStmt = $veza->prepare("SELECT id,datum,autor,email,tekst,novost FROM `komentari` WHERE novost = ?");
$komentariStmt->bindParam(1, $indeks);
$komentariStmt->execute();
$komentari = $komentariStmt->fetchAll();


if(!isset($novostObjekat)){
	die("Indeks vijesti ne postoji!");
} 
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
	<div class="detaljniTekstNovosti">
		<?= $novostObjekat['detaljniTekst'] ?>
	</div>
	<div class="detaljniTekstNovosti">
		<a class="dugmeDetalji" href="#" onclick="navigacija('naslovnica.html');">Nazad na naslovnu</a>
	</div>
	<?php if(isset($_SESSION['login_user'])){
	?>
		
	<div class="detaljniTekstNovosti">
		<a class="dugmeDetalji" href="#" onclick="obrisiNovost('<?= $novostObjekat['id'] ?>');">Obriši novost</a>
	</div>

	<?php } ?>
</div>

</br>

<div class="novostKontejner">
	<div class="naslovNovosti">
		Komentari(<?= count($komentari) ?>)
	</div>

<?php
	if(count($komentari) > 0){
		foreach($komentari as $indeks=>$komentar): 
?>	
		<div class ="autorIDatumNovosti">
			<?= $komentar['autor'] ?> - <?= $komentar['datum'] ?>
<?php
				$eMail = $komentar['email'];
				if($eMail != null && $eMail != ""){
					
					echo " - " . "<a href='mailto:$eMail'>$eMail</a>";
				}
?>
		</div>
		<div class="osnovniTekstNovosti">
				<?= $komentar['tekst'] ?>
		</div>
	</br>
		
		<?php if(isset($_SESSION['login_user'])){
		?>
			
		<div class="detaljniTekstNovosti">
			<a class="dugmeDetalji" href="#" onclick="obrisiKomentar('<?= $komentar['id'] . ', ' . $novostObjekat['id'] ?>');">Obriši komentar</a>
		</div>

		<?php } ?>

	</div>	
		
<?php
		endforeach;
	}
	else{
		echo "Nema komentara.";
	}
?>
	


</div>

</br>

<div class="novostKontejner">
	<div class="naslovNovosti">
		Dodaj Komentar
	</div>
	<div id="dodajKomentar">
		<div>
			<p>Autor:</p>
			<input type="text" id="komentarAutor" name="komentarAutor">
			<p>Email: </p>
			<input type="text" id="komentarEmail" name="komentarEmail">
			<p>Tekst: </p>
			<textarea id="komentarTekst" rows="4" cols="50" maxlength="250"></textarea>
			<br/>
			<input type="submit" id="komentarPosalji" name="komentarPosalji" value="Unesi" onclick='unesiKomentarNaNovost(<?= $novostObjekat['id'] ?>);'>
		</div>
	</div>
</div>

</br>


<?php if(isset($_SESSION['login_user'])){
?>
<div class="novostKontejner">
	<div class="naslovNovosti">
		Uredi novost
	</div>
	<div id="urediNovost">
		<div>
			<p>Autor:</p>
			<input type="text" id="novostAutor" name="novostAutor" value="<?= $novostObjekat['autor'] ?>">
			<p>Naslov: </p>
			<input type="text" id="novostNaslov" name="novostNaslov" value="<?= ucfirst(mb_strtolower($novostObjekat['naslov'], 'UTF-8')) ?>">
			<p>Slika: </p>
			<input type="text" id="novostSlika" name="novostSlika" value="<?= $novostObjekat['slika'] ?>">
			<p>Osnovni tekst: </p>
			<textarea id="naslovOsnovniTekst" rows="4" cols="50" maxlength="250"><?= $novostObjekat['osnovniTekst'] ?></textarea>
			<p>Detaljni tekst: </p>
			<textarea id="naslovDetaljniTekst" rows="10" cols="50" maxlength="2500"><?= $novostObjekat['detaljniTekst'] ?></textarea>
			<br/>
			<input type="hidden" id="idNovosti" name="idNovosti" value="<?= $novostObjekat['id'] ?>">
			<input type="submit" id="novostPosalji" name="novostPosalji" value="Spremi izmjene" onclick="urediNovost('<?= $novostObjekat['id'] ?>');">
		</div>
	</div>
</div>
<?php } ?>