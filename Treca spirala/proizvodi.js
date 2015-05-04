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

preuzmiPodatke();

var posaljiProizvod = function(akcija, proizvod){
	//akcija, proizvod	
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
		
	//var akcija = "dodavanje";
	//var proizvod = {naziv:"Naslov proizvoda 22222", opis:"Neki opis unesenog proizvoda 22222222"};
	var ime = "Neko";
	var prezime = "Nekic";
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4 && ajax.status == 200){
			console.log("Uspjesno: " + ajax.responseText);
			document.getElementById('sviProizvodi').innerHTML = "";
			preuzmiPodatke();
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

var izbrisiProizvod = function(){
	//akcija, proizvod	
	var ajax = new XMLHttpRequest();
	var student = {ime:"Edin", prezime:"Congo"};
	var akcija = "brisanje";
	var proizvod = {naziv:"Naslov proizvoda", opis:"Neki opis unesenog proizvoda"};
	var ime = "Neko";
	var prezime = "Nekic";
	ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("akcija=" + akcija + "&proizvod=" + JSON.stringify(proizvod) + "&brindexa=15515");
}


//http://zamger.etf.unsa.ba/wt/proizvodi.php