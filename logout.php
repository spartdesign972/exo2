<?php
session_start();

require_once 'inc/connect.php';

if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false){
 	// Redirection vers la page de connexion si non connecté
 	header('Location: login.php');
 	die; 
}

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] === 'disconnect'){
		// L'internaute à cliquer sur "se deconnecter"
		
		unset($_SESSION['me']); // Détruit uniquement la clé "me" et sa valeur de $_SESSION
		unset($_SESSION['is_logged']);
		// Détruit tout ce qui est relatif à la session

	 	header('Location: login.php');
 		die; 
	}
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Déconnexion</title>
	<?php require_once 'inc/headerlink.php'; ?>
	
</head>
<body>
	 
	<?php require_once 'inc/nav.php'; ?>

	<div class="container main">
	<div class="page-header">
		<h1>Vous Déconnecter ?</h1>

	<form method="post" class="form-horizontal">
		<input type="hidden" name="action" value="disconnect">

		<!-- history.back() permet de revenir à la page précédente -->
		<button type="button" onclick="javascript:history.back();" class="btn btn-primary">Annuler</button>
		<input type="submit" value="Se déconnecter" class="btn btn-primary">
	</form>

</body>
</html>