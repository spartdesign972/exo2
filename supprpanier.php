<?php
session_start();


if(isset($_GET)){
	if(isset($_GET['valide']) && $_GET['valide'] == 'true'){
		
		unset($_SESSION['panier']);

		header('location: listeArticles.php');
	}
	if(isset($_GET['valide']) && $_GET['valide'] == 'false'){
		header('location: listeArticles.php');
	}

}

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Suppression du panier</title>
		
		<?php require_once 'inc/headerlink.php'; ?>
	</head>
	<body>
		
		<?php require_once 'inc/nav.php'; ?>
		<div class="container main">
			
			<div class="page-header">
				<h1>Supprimer le panier</h1>
			</div>
			
			<div class="row">
				<h3>Voulez-vous supprimer votre panier ?</h3>
				<div class="col-xs-12">
					<p>
						<a href="supprpanier.php?valide=true" class="btn btn-primary">OUI</a>
						<a href="supprpanier.php?valide=false" class="btn btn-primary">NON</a>
					</p>
				</div>
			</div>
		</div>
		
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JS -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>