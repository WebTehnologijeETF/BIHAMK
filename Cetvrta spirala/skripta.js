var sadrzaj = document.getElementById("sadrzaj_tab");

var navigacija = function(tab){
	var ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			sadrzaj.innerHTML = ajax.responseText;
			if(tab=="proizvodi.html")
				preuzmiPodatke();
			if(tab=="naslovnica.html")
				preuzmiNovosti();
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			sadrzaj.innerHTML = "Error";
		}
	};
	
	ajax.open("GET", "/"+tab, true);
	ajax.send();
};

if(window.location.pathname == "/"){
	navigacija("naslovnica.html");
}


// Tree struktura pocetak
function prviNivo(nivo, link, naziv) {
	var id = "tema"+nivo
	var tema = naziv
	if (document.getElementById(id).style.display === 'none') {
		document.getElementById(id).style.display = 'block'
		link.innerHTML = "<img src=\"images/arrow2.png\"/>"  + naziv
	} else {
		document.getElementById(id).style.display = 'none'
		link.innerHTML = "<img src=\"images/arrow.png\"/>" + naziv
	}
	return false
}

function drugiNivo(nivo, link, naziv) {
	var id = "tema"+nivo
	var tema = naziv
	if (document.getElementById(id).style.display === 'none') {
		document.getElementById(id).style.display = 'block'
		link.innerHTML = "<img src=\"images/plus2.png\"/>"  + naziv
	} else {
		document.getElementById(id).style.display = 'none'
		link.innerHTML = "<img src=\"images/plus.gif\"/>" + naziv
	}
	return false
}

function treciNivo(nivo, link, naziv) {
	var id = "tema"+nivo
	var tema = naziv
	if (document.getElementById(id).style.display === 'none') {
		document.getElementById(id).style.display = 'block'
		link.innerHTML = "<img src=\"images/bullet2.png\"/>"  + naziv
	} else {
		document.getElementById(id).style.display = 'none'
		link.innerHTML = "<img src=\"images/bullet.png\"/>" + naziv
	}
	return false
}

//

var provjeraPostanskogBroja = function(mjesto, postanskiBroj){
		
	if (postanskiBroj=="" || postanskiBroj.length<5){
		document.getElementById("postanskiBroj").style.backgroundImage="url(images/invalid.gif)";
		document.getElementById("postanskiBroj").style.backgroundPosition="right top";
		document.getElementById("postanskiBroj").style.backgroundRepeat="no-repeat";
		document.getElementById("greskaPostanskiBroj").innerHTML+="Neispravan unos za poštanski broj !";
		if (sveIspravno==true) document.getElementById("postanskiBroj").focus();
		sveIspravno=false;
		return;
	}
	
	var ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			var result = JSON.parse(ajax.responseText);
			if (result.greska){
				if(result.greska == "Nepostojeće mjesto"){
					document.getElementById("grad").style.backgroundImage="url(images/invalid.gif)";
					document.getElementById("grad").style.backgroundPosition="right top";
					document.getElementById("grad").style.backgroundRepeat="no-repeat";
					document.getElementById("greskaGrad").innerHTML=result.greska;
					if (sveIspravno==true) document.getElementById("grad").focus();
					sveIspravno=false;
				}
				if(result.greska == "Nepostojeći poštanski broj"){
					document.getElementById("postanskiBroj").style.backgroundImage="url(images/invalid.gif)";
					document.getElementById("postanskiBroj").style.backgroundPosition="right top";
					document.getElementById("postanskiBroj").style.backgroundRepeat="no-repeat";
					document.getElementById("greskaPostanskiBroj").innerHTML=result.greska;
					if (sveIspravno==true) document.getElementById("postanskiBroj").focus();
					sveIspravno=false;
				}
			}
			else {
				document.getElementById("grad").style.backgroundImage="url(images/valid.png)";
				document.getElementById("grad").style.backgroundPosition="right top";
				document.getElementById("grad").style.backgroundRepeat="no-repeat";
				document.getElementById("postanskiBroj").style.backgroundImage="url(images/valid.png)";
				document.getElementById("postanskiBroj").style.backgroundPosition="right top";
				document.getElementById("postanskiBroj").style.backgroundRepeat="no-repeat";
			}
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			return "Error";
		}
	};
	
	ajax.open("GET", "http://zamger.etf.unsa.ba/wt/postanskiBroj.php?mjesto=" + mjesto + "&postanskiBroj=" + postanskiBroj, true);
	ajax.send();
};



// Tree struktura kraj

	//validacija forme
	var sveIspravno=true;
	
	var provjeriGreske = function(greske){
		for (var i = 0; i < greske.length; i++){
			if(greske[i].innerHTML != "  "){
				sveIspravno = false;
				return;
			}
		}
		sveIspravno = true;
	};
	
	function ValidacijaForme(){
		//varijable za provjeru ispravnosti
		var datumRodjenja=document.getElementById("datum").value;
		var nazivGrada=document.getElementById("grad").value;
		var postanskiBrojPotvrda=document.getElementById("postanskiBroj").value;
		var nazivAdrese=document.getElementById("adresa").value;
		var brojTelefona=document.getElementById("telefon").value;
		var imePrezime=document.getElementById("imeprezime").value;
		var potvrdaTelefon=document.getElementById("potvrda").value;
		var emailAdresa=document.getElementById("email").value;
		var clanskiBroj=document.getElementById("broj").value;
		var nazivKantona=document.getElementById("kanton").value;
		
		
		
		//varijable za ispis greske
		var imeLabel = document.getElementById("greskaIme");
		imeLabel.innerHTML="  "; //ciscenje ispisa greske zbog dupliciranja
		var datumLabel = document.getElementById("greskaDatum");
		datumLabel.innerHTML="  ";
		var kantonLabel = document.getElementById("greskaKanton");
		kantonLabel.innerHTML="  ";
		var gradLabel = document.getElementById("greskaGrad");
		gradLabel.innerHTML="  ";
		var postanskiBrojLabel = document.getElementById("greskaPostanskiBroj");
		postanskiBrojLabel.innerHTML="  ";
		var adresaLabel = document.getElementById("greskaAdresa");
		adresaLabel.innerHTML="  ";
		var emailLabel = document.getElementById("greskaEmail");
		emailLabel.innerHTML="  ";
		var telefonLabel = document.getElementById("greskaTelefon");
		telefonLabel.innerHTML="  ";
		var potvrdaLabel = document.getElementById("greskaTelefonP");
		potvrdaLabel.innerHTML="  ";
		
		//provjera ispravnosti imena i prezimena
		//provjerava se da ime i prezime pocinju velikim slovom, ostala slova su mala, te da duzina rijeci nije manja od 3 slova
		//VAZNA NAPOMENA: regex ne prepoznaje afrikate (UTF-8)
		if (imePrezime=="" || !imePrezime.match(/^[A-Z][a-z]{3,40} [A-Z][a-z]{3,40}$/) ) {
			document.getElementById("imeprezime").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("imeprezime").style.backgroundPosition="right top";
			document.getElementById("imeprezime").style.backgroundRepeat="no-repeat";
			imeLabel.innerHTML +="Neispravan unos!";
			if (sveIspravno==true) document.getElementById("imeprezime").focus();
			sveIspravno=false;
			
		}
		else {
			document.getElementById("imeprezime").style.backgroundImage="url(images/valid.png)";
			document.getElementById("imeprezime").style.backgroundPosition="right top";
			document.getElementById("imeprezime").style.backgroundRepeat="no-repeat";
		}
		
		//provjera ispravnosti datuma (format: DD-MM-YYYY ili DD.MM.YYYY ili DD/MM/YYYY)
		if (datumRodjenja=="" || !datumRodjenja.match(/^(0?[1-9]|[12][0-9]|3[01])[\/\-\.](0?[1-9]|1[012])[\/\-\.](\d{4})$/)){
			document.getElementById("datum").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("datum").style.backgroundPosition="right top";
			document.getElementById("datum").style.backgroundRepeat="no-repeat";
			datumLabel.innerHTML +="Dozvoljeni format: DD-MM-YYYY ili DD.MM.YYYY ili DD/MM/YYYY !";
			if (sveIspravno==true) document.getElementById("datum").focus();
			sveIspravno=false;
		}
		else {
			document.getElementById("datum").style.backgroundImage="url(images/valid.png)";
			document.getElementById("datum").style.backgroundPosition="right top";
			document.getElementById("datum").style.backgroundRepeat="no-repeat";
		}
		
		//provjera da li uneseni naziv odgovara jednom od deset kantona Federacije BiH
		if (nazivKantona=="" ||  !(nazivKantona=="Kanton Sarajevo" || nazivKantona=="Unsko-sanski kanton" || nazivKantona=="Posavski kanton" || nazivKantona=="Tuzlanski kanton" || nazivKantona=="Zeničko-dobojski kanton" || nazivKantona=="Bosansko-podrinjski kanton" || nazivKantona=="Srednjobosanski kanton" || nazivKantona=="Hercegovačko-neretvanski kanton" || nazivKantona=="Zapadnohercegovački kanton" || nazivKantona=="Kanton 10")){				
			document.getElementById("kanton").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("kanton").style.backgroundPosition="right top";
			document.getElementById("kanton").style.backgroundRepeat="no-repeat";
			kantonLabel.innerHTML +="Ne postoji taj kanton !";
			sveIspravno=false;
		}
		else {
			document.getElementById("kanton").style.backgroundImage="url(images/valid.png)";
			document.getElementById("kanton").style.backgroundPosition="right top";
			document.getElementById("kanton").style.backgroundRepeat="no-repeat";
		}		

	//provjera ispravno unesenog grada (minimalna duzina 4 i da sadrzi samo mala/velika slova)
		if (!nazivGrada.match(/^[a-zA-Z]+$/) || nazivGrada=="" || nazivGrada.length<4){
			document.getElementById("grad").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("grad").style.backgroundPosition="right top";
			document.getElementById("grad").style.backgroundRepeat="no-repeat";
			gradLabel.innerHTML+="Neispravan unos grada !";
			if (sveIspravno==true) document.getElementById("grad").focus();
			sveIspravno=false;
		}
		else {
			document.getElementById("grad").style.backgroundImage="url(images/valid.png)";
			document.getElementById("grad").style.backgroundPosition="right top";
			document.getElementById("grad").style.backgroundRepeat="no-repeat";
		}
		
	//provjera AJAX za postanski Broj	
		provjeraPostanskogBroja(nazivGrada, postanskiBrojPotvrda);
		
	//provjera ispravno unesene adrese (provjereno na regex101, sto znaci da se moze sastojati iz vise rijeci, a na kraju mora da sadrzi broj)
		if (!nazivAdrese.match(/\w (\d+)/) || nazivAdrese.length<3 || nazivAdrese =="") {
			document.getElementById("adresa").style.backgroundImage               ="url(images/invalid.gif)";
			document.getElementById("adresa").style.backgroundPosition            ="right top";
			document.getElementById("adresa").style.backgroundRepeat              ="no-repeat";
			adresaLabel.innerHTML +="Neispravan unos adrese ! Mora sadržavati i broj.";
			if (sveIspravno                                                       ==true) document.getElementById("adresa").focus();
			sveIspravno                                                           =false;
		}
		else {
			document.getElementById("adresa").style.backgroundImage="url(images/valid.png)";
			document.getElementById("adresa").style.backgroundPosition="right top";
			document.getElementById("adresa").style.backgroundRepeat="no-repeat";
		}
		
	//provjera unesenog kontakt telefona (format: 061-123-456 ili 061123456 ili (061)-123-456 )
		if (!brojTelefona.match(/^\(?(\d{3})\)?[-]?(\d{3})[-]?(\d{3})$/) || brojTelefona=="") {
			document.getElementById("telefon").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("telefon").style.backgroundPosition="right top";
			document.getElementById("telefon").style.backgroundRepeat="no-repeat";
			telefonLabel.innerHTML +="Dozvoljeni format: 061-123-456 ili 061123456 ili (061)-123-456 ";
			if (sveIspravno==true) document.getElementById("telefon").focus();
			sveIspravno=false;
		}
		else {
			document.getElementById("telefon").style.backgroundImage="url(images/valid.png)";
			document.getElementById("telefon").style.backgroundPosition="right top";
			document.getElementById("telefon").style.backgroundRepeat="no-repeat";
		}
		
	//cross validacija (provjera podudaranja brojeva telefona)
		if (!potvrdaTelefon.match(/^\(?(\d{3})\)?[-]?(\d{3})[-]?(\d{3})$/) || potvrdaTelefon!=brojTelefona || potvrdaTelefon=="") {
			document.getElementById("potvrda").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("potvrda").style.backgroundPosition="right top";
			document.getElementById("potvrda").style.backgroundRepeat="no-repeat";
			potvrdaLabel.innerHTML +="Broj ne odgovara prethodno unesenom broju !";
			if (sveIspravno==true) document.getElementById("potvrda").focus();
			sveIspravno=false;
		}
		else {
			document.getElementById("potvrda").style.backgroundImage="url(images/valid.png)";
			document.getElementById("potvrda").style.backgroundPosition="right top";
			document.getElementById("potvrda").style.backgroundRepeat="no-repeat";
		}
			
	//provjera ispravnosti unesene email adrese (mora da sadrzi @ i poslije toga ekstenziju sa najmanje 2 slova)
		if (!emailAdresa.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) || emailAdresa=="") {
			document.getElementById("email").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("email").style.backgroundPosition="right top";
			document.getElementById("email").style.backgroundRepeat="no-repeat";
			emailLabel.innerHTML +="E-mail adresa nije validna!";
			if (sveIspravno==true) document.getElementById("email").focus();
			sveIspravno=false;
		}
		else {
			document.getElementById("email").style.backgroundImage="url(images/valid.png)";
			document.getElementById("email").style.backgroundPosition="right top";
			document.getElementById("email").style.backgroundRepeat="no-repeat";
		}

	//provjera ako je unesen clanski broj da bude duzina broja u intervalu [3,5]
		if (clanskiBroj!=""){
			if (clanskiBroj.length<3 || clanskiBroj.length>5 ) {
				document.getElementById("broj").style.backgroundImage="url(images/invalid.gif)";
				document.getElementById("broj").style.backgroundPosition="right top";
				document.getElementById("broj").style.backgroundRepeat="no-repeat";
				if (sveIspravno==true) document.getElementById("broj").focus();
				sveIspravno=false;
			}
			else {
				document.getElementById("broj").style.backgroundImage="url(images/valid.png)";
				document.getElementById("broj").style.backgroundPosition="right top";
				document.getElementById("broj").style.backgroundRepeat="no-repeat";
			}
		}
		
		var sveGreske = [greskaAdresa, greskaDatum, greskaEmail, greskaGrad, greskaIme, greskaKanton, greskaPostanskiBroj, greskaTelefon, greskaTelefonP];
		
		provjeriGreske(sveGreske);
			
		if(sveIspravno==true)
			document.getElementById("forma").submit();
		else
			return false;
	}
	
// Proizvodi

var sviProizvodiSaServera = null;

var validirajUnosProizvoda = function(indeksProizv){
	if(indeksProizv == null) {
		console.log("validira se dodaj novi forma");
		var ispravnost = true;
		var tmpNaziv = document.getElementById("proizvodNaslov").value;
		var tmpOpis = document.getElementById("proizvodOpis").value;
		
		if(tmpNaziv == null || tmpNaziv == ""){
			document.getElementById("proizvodNaslov").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("proizvodNaslov").style.backgroundPosition="right top";
			document.getElementById("proizvodNaslov").style.backgroundRepeat="no-repeat";
			ispravnost = false;
		}
		if(tmpOpis == null || tmpOpis == ""){
			document.getElementById("proizvodOpis").style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("proizvodOpis").style.backgroundPosition="right top";
			document.getElementById("proizvodOpis").style.backgroundRepeat="no-repeat";
			ispravnost = false;
		}

		if(tmpNaziv != null && tmpNaziv != ""){
			document.getElementById("proizvodNaslov").style.backgroundImage="url(images/valid.png)";
			document.getElementById("proizvodNaslov").style.backgroundPosition="right top";
			document.getElementById("proizvodNaslov").style.backgroundRepeat="no-repeat";
		}
		if(tmpOpis != null && tmpOpis != ""){
			document.getElementById("proizvodOpis").style.backgroundImage="url(images/valid.png)";
			document.getElementById("proizvodOpis").style.backgroundPosition="right top";
			document.getElementById("proizvodOpis").style.backgroundRepeat="no-repeat";
		}
		
		return ispravnost;
	}
	else{
		console.log("validira se edit forma " + indeksProizv);
		var ispravnost = true;
		var tmpNaziv = document.getElementById("proizvodNazivPolje"+indeksProizv).value;
		var tmpOpis = document.getElementById("proizvodOpisPolje"+indeksProizv).value;
		
		if(tmpNaziv == null || tmpNaziv == ""){
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundPosition="right top";
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundRepeat="no-repeat";
			ispravnost = false;
		}
		if(tmpOpis == null || tmpOpis == ""){
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundImage="url(images/invalid.gif)";
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundPosition="right top";
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundRepeat="no-repeat";
			ispravnost = false;
		}
		if(tmpNaziv != null && tmpNaziv != ""){
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundImage="url(images/valid.png)";
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundPosition="right top";
			document.getElementById("proizvodNazivPolje"+indeksProizv).style.backgroundRepeat="no-repeat";
		}
		if(tmpOpis != null && tmpOpis != ""){
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundImage="url(images/valid.png)";
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundPosition="right top";
			document.getElementById("proizvodOpisPolje"+indeksProizv).style.backgroundRepeat="no-repeat";
		}
		
		return ispravnost;
	}
};

var spasiProizvod = function(proizv, indexProizvoda){
	console.log("spasio si " + proizv.naziv + " " + proizv.opis);
	var tmpNazivEdit = document.getElementById("proizvodNazivPolje"+indexProizvoda).value;
	var tmpOpisEdit = document.getElementById("proizvodOpisPolje"+indexProizvoda).value;
	proizv.naziv = tmpNazivEdit;
	proizv.opis = tmpOpisEdit;
	posaljiProizvod("promjena", proizv);
}

var obrisiProizvod = function(proizv){
	console.log("obrisao si " + proizv.naziv + " " + proizv.opis);
	posaljiProizvod("brisanje", proizv);
}

var procesirajRezultat = function(rezultat){
	sviProizvodiSaServera = rezultat;
	
	for(var i = 0; i < rezultat.length; i++){
		var proizvodSadrzajDiv = document.createElement('div');
		
		proizvodSadrzajDiv.id = 'proizvodSadrzaj' + i;
		proizvodSadrzajDiv.className = 'proizvodSadrzaj';	
			
		var nazivProizvodaDiv = document.createElement('div');
		
		nazivProizvodaDiv.id = 'proizvodNaziv' + i;
		nazivProizvodaDiv.className = 'naslovProizvoda';
		nazivProizvodaDiv.innerHTML = rezultat[i].naziv;
		
		var opisProizvodaDiv = document.createElement('div');
		
		opisProizvodaDiv.id = 'proizvodOpis' + i;
		opisProizvodaDiv.className = 'opisProizvoda';
		opisProizvodaDiv.innerHTML = rezultat[i].opis;
		
		var adminDugmadDiv = document.createElement('div');
		adminDugmadDiv.className = "adminDugmad";
		
		var urediDugme = document.createElement('input');
		urediDugme.type="button";
		urediDugme.value="Uredi";
		urediDugme.id="urediProizvod" + i;
		urediDugme.onclick = function(){ document.getElementById("editGrupa" + this.id.slice(-1)).style.display = 'block' };

		var obrisiDugme = document.createElement('input');
		obrisiDugme.type="button";
		obrisiDugme.value="Obriši";
		obrisiDugme.id="obrisiProizvod" + i;
		obrisiDugme.onclick = function(){obrisiProizvod(sviProizvodiSaServera[(this.id.slice(-1))])};	
		
		adminDugmadDiv.appendChild(urediDugme);
		adminDugmadDiv.appendChild(obrisiDugme);
		
		// Edit dio
		var editKontejner = document.createElement('div');
		editKontejner.id = "editGrupa" + i;
		editKontejner.className = "editGrupa";
		
		var labela1 = document.createElement('p');
		labela1.innerHTML = "Naziv:";
		
		var nazivInputPolje = document.createElement('input');
		nazivInputPolje.type="text";
		nazivInputPolje.id="proizvodNazivPolje" + i;
		nazivInputPolje.value=rezultat[i].naziv;
		
		var labela2 = document.createElement('p');
		labela2.innerHTML = "Opis:";
		
		var opisInputPolje = document.createElement('textarea');
		opisInputPolje.rows="4";
		opisInputPolje.cols="50";
		opisInputPolje.id="proizvodOpisPolje" + i;
		opisInputPolje.value=rezultat[i].opis;
		
		var prelom = document.createElement('br');
		
		var spasiDugme = document.createElement('input');
		spasiDugme.type="button";
		spasiDugme.value="Spasi";
		spasiDugme.id="proizvodSpasi" + i;
		spasiDugme.onclick = function(){
			if(validirajUnosProizvoda((this.id.slice(-1))))
				spasiProizvod(sviProizvodiSaServera[(this.id.slice(-1))], (this.id.slice(-1)));
			else{
				alert("Unijeli ste pogrešne podatke! 'Naslov' i 'Opis ne smiju biti prazni.'");
				return;
			}	
		};
		
		editKontejner.appendChild(labela1);
		editKontejner.appendChild(nazivInputPolje);
		editKontejner.appendChild(labela2);
		editKontejner.appendChild(opisInputPolje);
		editKontejner.appendChild(prelom);
		editKontejner.appendChild(spasiDugme);
		
		proizvodSadrzajDiv.appendChild(nazivProizvodaDiv);
		proizvodSadrzajDiv.appendChild(opisProizvodaDiv);
		proizvodSadrzajDiv.appendChild(adminDugmadDiv);
		proizvodSadrzajDiv.appendChild(editKontejner);
		
		document.getElementById('sviProizvodi').appendChild(proizvodSadrzajDiv);		
	}
};

var preuzmiPodatke = function(){
	var ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			procesirajRezultat(JSON.parse(ajax.responseText));
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			document.getElementById("polje").innerHTML = "Error";
		}
	};
	
	ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15515", true);
	ajax.send();
}

var preuzmiNovosti = function(){
	var ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			sadrzaj.innerHTML = ajax.responseText;
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			document.getElementById("polje").innerHTML = "Error";
		}
	};
	
	ajax.open("GET", "novosti.php", true);
	ajax.send();
}

var posaljiProizvod = function(akcija, proizvod){
	var ajax = new XMLHttpRequest();
	
	if(akcija == "dodavanje" && proizvod == null){
		if (validirajUnosProizvoda(null))
		{
			var tmpNaziv = document.getElementById("proizvodNaslov").value;
			var tmpOpis = document.getElementById("proizvodOpis").value;
			proizvod = {
				naziv: tmpNaziv,
				opis: tmpOpis
			};
		}
		else{
			alert("Unijeli ste pogrešne podatke! 'Naslov' i 'Opis ne smiju biti prazni.'");
			return;
		}
			
	}
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			console.log("Uspjesno: " + ajax.responseText);
			document.getElementById('sviProizvodi').innerHTML = "";
			preuzmiPodatke();
			document.getElementById("proizvodNaslov").value="";
			document.getElementById("proizvodOpis").value="";
			document.getElementById("proizvodNaslov").style.backgroundImage="";
			document.getElementById("proizvodOpis").style.backgroundImage="";
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			console.log("Neuspjesno: " + ajax.responseText);
		}
	};
	
	ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	if(akcija == "dodavanje")
		ajax.send("akcija=" + akcija + "&proizvod=" + JSON.stringify(proizvod) + "&brindexa=15515");
	else if(akcija == "promjena")
		ajax.send("akcija=" + akcija + "&proizvod=" + JSON.stringify(proizvod) + "&brindexa=15515");
	else if(akcija == "brisanje")
		ajax.send("akcija=" + akcija + "&proizvod=" + JSON.stringify(proizvod) + "&brindexa=15515");
}

var prikaziDetaljno = function(index){
	var ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			sadrzaj.innerHTML = ajax.responseText;
		}
		
		if(ajax.readyState == 4 && ajax.status == 404){
			document.getElementById("polje").innerHTML = "Error";
		}
	};
	
	ajax.open("GET", "prikaziDetaljno.php?indeks=" + index, true);
	ajax.send();
}

var posaljiMail = function(){
	var formaZaKontakt = document.getElementById('forma');
	formaZaKontakt.action = "posaljiMail.php"; //will retrieve it
	formaZaKontakt.submit();
}