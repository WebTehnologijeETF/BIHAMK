<?php
session_start();

require "dbkonekcija.php";

$error='';

if (empty($_POST['username']) || empty($_POST['password'])) {
	$error = "Username ili Password nije validan";

	if(empty($_POST['submit'])){
		$error = '';
	}
}
else{

	$username = htmlentities($_POST['username'], ENT_QUOTES);
	$password = htmlentities($_POST['password'], ENT_QUOTES);

	$userIzBaze = $veza->prepare("SELECT id, username, password, email FROM korisnici WHERE username = ? AND password = ?");
	$userIzBaze->bindParam(1, $username);
	$userIzBaze->bindParam(2, $password);
	$userIzBaze->execute();
	$userObjekat = $userIzBaze->fetch();

	// unistava konekciju
	$userIzBaze = null;
	$veza = null;


	if($username == $userObjekat['username'] && $password == $userObjekat['password']){
		$_SESSION['login_user'] = $username;
		header("location: novosti.php");
	} 
	else{
		$error = "Username ili Password nije validan";
	}
}

echo $error;

?>

<div id="main">
	<h1>Unesite administratorski username i password:</h1>
	<div id="login">
		<h2>Login Forma</h2>
		<div id="loginKontejner">
			<label>Username :</label>
			<input id="username" name="username" placeholder="username" type="text">
			<label>Password :</label>
			<input id="password" name="password" placeholder="**********" type="password">
			<input name="submit" type="submit" value=" Login " onclick="posaljiLoginPodatke();">
			<span><?php echo $error; ?></span>
		</div>
	</div>
</div>