<?php 
if(!isset($_SESSION['login_user'])){
	header('HTTP/1.1 401 Unauthorized', true, 401);
	echo "Nemate pristup.";
	exit();
}
?>