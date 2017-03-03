<?php 
require_once 'inc/connect.php';

// Créer un formulaire permettant de créer un produit (exemples : livre, objet divers, etc)

// Le formulaire contiendra les champs suivants : 

// - Libellé
// - Description
// - Référence
// - Tarif HT
// - Taux de TVA (5.5%, 10%, 20%)
// - Photo


// Sur chaque page "produit", un bouton permettra de stocker le produit en session.

// Une page affichera la liste des produits du panier à l'aide des sessions
//=========================================================================


#définition de quelques variabl pour gerer les images
$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];	


#verification de l'existance de l'envoi des données puis vérificatio de celle ci
if(!empty($_POST))
{
	foreach ($_POST as $key => $value)
	{
		$post[$key] = (trim(strip_tags($value))); 
	}
	if(strlen($post['Libelle'])<3)
	{
		$errors[] = 'Veuillez entrer un nom de plus de 3 caratères';
	}

	if(strlen($post['description'])<15)
	{
		$errors[] = 'Veuillez entrer une description plus longue (min 15 caracteres)';
	}

	if(empty($post['reference'])){
		$errors[] = 'Veuillez choisir la reference';
	}

	if(empty($post['tarifht'])){
		$errors[] = 'Veuillez entrer un tarif';
	}

	if(empty($post['tva'])){
		$errors[] = 'Veuillez choisir une tva';
	}
    

	if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){

		$finfo = new finfo(); //déclaration d'un objet de type finfo
		$mimeType = $finfo->file($_FILES['photo']['tmp_name'], FILEINFO_MIME_TYPE); // récuperation du type mime du fichier, cette façon de faire est la plus sécure

		$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);//Récuperer l'extension du ficher grace au path info

		if(in_array($mimeType, $mimeTypeAvailable)){

			if($_FILES['photo']['size'] <= $maxSize){

				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0755);//création du dossier via le CHmod, permet d'avoir les droit d'ecriture
				}

				$newPictureName = uniqid('avatar_').'.'.$extension;//changeent du nom du fichier avec le prefixe avatar et lui donnant un id unique. Adie les remplacement

				if(!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir.$newPictureName)){
					$errors[] = 'Erreur lors de l\'upload de la photo';
				}
			}else {
				$errors[] = 'La taille du fichier excède 2 Mo';
			}
		}else {
			$errors[] = 'Le fichier n\'est pas une image valide';
		}
	}else {
		$newPictureName = 'avatar.png';
	}

}
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Creation de produits</title>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	

</head>
<body>
	
		
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
		<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">MonCommerce</a>
				</div>
		
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div>
	</nav>


<div class="container">

	<form action="" method="POST" role="form" enctype="multipart/form-data">
		<legend>nouveau produit</legend>
	
		<div class="form-group">
			<label for="Libellé">Libellé</label>
			<input type="text" name="Libelle" class="form-control" id="Libelle" placeholder="Le nom du Produit">
		</div>

		<div class="form-group">
			<label for="Description">Description</label>
			<input type="text" name="description" class="form-control" id="Description" placeholder="Décrivez le Produit">
		</div>

		<div class="form-group">
			<label for="Reference">Reference</label>
			<input type="text" name="reference" class="form-control" id="Reference" placeholder="Reference du produit">
		</div>

		<div class="form-group">
			<label for="Tarifht">Tarif HT</label>
			<input type="text" name="tarifht" class="form-control" id="tarifht" placeholder="Prix Hors Taxe">
		</div>

		<div class="form-group">
			<label for="TVA">TVA a appliqué:</label>
			<select name="tva" id="TVA" class="form-control">
				<option value=""></option>
			</select>
		</div>

		<div class="form-group">
			<label for="Photo">Photo</label>
			<input type="file" name="photo" class="form-control" id="Photo" placeholder="Photo du Produit">
		</div>
	

		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

</div>






<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>

