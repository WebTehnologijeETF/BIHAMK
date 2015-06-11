<div id="glavniFooter">
	<div id="logovaniUser">
		Trenutno ste logovani kao:
		<?php
		if(isset($_SESSION['login_user'])){
			echo $_SESSION['login_user'];
			?>
			<a id="administracijaLink" href="#administracija" onclick="navigacija('logout.php');">Odjavi se</a>
			</br>
			<a id="administracijaLink" href="#korisnici" onclick="navigacija('korisnici.php');">Svi korisnici</a>
			</br>
			<a id="administracijaLink" href="#resetujSifru" onclick="navigacija('resetujSifru.php');">Resetuj šifru</a>
			<?php
		}
		else{
			echo "Anonimni korisnik";
		}
		?>
	</div>
	<div id="footer">
		<p> Copyright © 2015 BIHAMK Sarajevo | Design by Edin Čongo | Sva prava zadržana. </p>
		<a id="administracijaLink" href="#administracija" onclick="navigacija('login.php');">ADMINISTRACIJA</a>
	</div>
</div>