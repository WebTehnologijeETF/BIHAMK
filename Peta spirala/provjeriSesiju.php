<?php 
if(!isset($_SESSION['login_user'])){
	echo "Nemate pristup.";
	header('HTTP/1.1 401 Unauthorized', true, 401);
	exit();
}
?>