<?php 
session_start();
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
$uploadDir = '/assets/img/imgArticles/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];	

#verification de l'existance de l'envoi des données puis vérificatio de celle ci
if(!empty($_POST))
{
	if(isset($_POST['produit'])){ // le submit a ete validé sur produit
		foreach ($_POST as $key => $value)
		{
			$post[$key] = (trim(strip_tags($value))); 
		}
		if(strlen($post['Libelle'])<3)
		{
			$errors[] = 'Veuillez entrer un nom de plus de 3 caratères';
		}

		if(strlen($post['description'])<10)
		{
			$errors[] = 'Veuillez entrer une description plus longue (min 15 caracteres)';
		}

		if(empty($post['reference'])){
			$errors[] = 'Veuillez choisir la reference';
		}

		if(empty($post['tarifht']) || !is_numeric($post['tarifht'])){
			$errors[] = 'Veuillez entrer un tarif en chiffre';
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

					$newPictureName = uniqid('produits_').'.'.$extension;//changeent du nom du fichier avec le prefixe avatar et lui donnant un id unique. Adie les remplacement

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
			$newPictureName = 'default-image.png';
		}

		if(count($errors) > 0){
			$errorsText = implode('<br>', $errors);
		}else{

			// Insertion des categories dans la BDD
			$insert_prod = $bdd->prepare('INSERT INTO produits (libelle, description, categorie, ref, tarifht, tva, photo_url) VALUES (:libelle, :description, :categorie, :ref, :tarifht, :tva, :photo_url)');

			$insert_prod->bindValue(':libelle', $post['Libelle']);
			$insert_prod->bindValue(':description', $post['description']);
			$insert_prod->bindValue(':categorie', $post['cat'], PDO::PARAM_INT);
			$insert_prod->bindValue(':ref', $post['reference']);
			$insert_prod->bindValue(':tarifht', $post['tarifht'], PDO::PARAM_INT);
			$insert_prod->bindValue(':tva', $post['tva'], PDO::PARAM_INT);
			$insert_prod->bindValue(':photo_url', $newPictureName);

			if($insert_prod->execute()){
				$success = 'Produit ajouter avec succés';
			}else{
				var_dump($insert_prod->errorInfo());
			}
		}
	
	}


	if(isset($_POST['categorie'])){ // le submit a ete validé sur catégorie
		foreach ($_POST as $key => $value)
		{
			$post[$key] = (trim(strip_tags($value))); 
		}
		if(strlen($post['name'])<3)
		{
			$errors[] = 'Veuillez entrer un nom de plus de 3 caratères';
		}

		if(strlen($post['description'])<10)
		{
			$errors[] = 'Veuillez entrer une description plus longue (min 15 caracteres)';
		}
		// Insertion des categories dans la BDD
		if(count($errors) > 0){
			$errorsText = implode('<br>',$errors);
		}else{
			$insert_cat = $bdd->prepare('INSERT INTO categorie (name, description_cat) VALUES (:dataname, :datadescription)');
			
			$insert_cat->bindValue(':dataname', $post['name'], PDO::PARAM_STR);
			$insert_cat->bindValue(':datadescription', $post['description'], PDO::PARAM_STR);

			if($insert_cat->execute()){
				$success = 'Nouvelle categorie ajouter a la base de donnée';
			}else{
				var_dump($insert_cat->errorInfo());
			}

		}//====================================
	}
}
	// Listing de toutes les catégorie
	$categ = $bdd->prepare('SELECT id, name FROM categorie');

	if($categ->execute()){
		$list_categ = $categ->fetchAll(PDO::FETCH_ASSOC);
	}else{
		var_dump($categ->errorInfo());
	}


?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Creation de produits</title>
	
	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
	
	<?php require_once 'inc/nav.php'; ?>

<div class="container main">
	<?php if(isset($errorsText)): ?>
	    <div class="alert alert-danger alert-dismissible" role="alert"">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
	        <span class="sr-only">Error:</span>
	        <?= $errorsText; ?>
	    </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
	    <div class="alert alert-success alert-dismissible divfade" role="alert"">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<span class="glyphicon glyphicon-okn" aria-hidden="true"></span>
	        <span class="sr-only">Error:</span>
	        <?= $success; ?>
	    </div>
    <?php endif; ?>
	<div class="row">
		<div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">

			<!--=============== Formulaire pour ajouter une catégorie ===============-->
			<form method="POST" class="form-horizontal" role="form">
						<legend>Nouvelle Catégorie</legend>
					<div class="form-group">
						<label for="name">Nom de la Catégorie</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Nom de la catégorie">
					</div>

					<div class="form-group">
						<label for="description">Description de la Catégorie</label>
						<input type="text" name="description" class="form-control" id="description" placeholder="Description de la catégorie">
					</div>

					<div class="form-group">
						<div class="col-xs-12 text-center">
							<button type="submit" class="btn btn-primary" name="categorie">Nouvelle Catégorie</button>
						</div>
					</div>
			</form>
		</div>
		<!--======================== Fin form catégorie ====================-->

		<!--=============== Formulaire pour ajouter un Produit ===============-->
		<div class="col-sm-8 col-xs-10 col-xs-offset-1 col-sm-offset-0">
			<form method="POST" class="form-horizontal form-horizontal-border-right" role="form" enctype="multipart/form-data">
				<legend>Nouvelle Article</legend>
			
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
					<label for="TVA">Catégorie:</label>
					<select name="cat" id="cat" class="form-control">
						<?php foreach ($list_categ as $value):?>
							<option value="<?=$value['id']?>"><?=$value['name']?></option>
						<?php endforeach; ?>
						
					</select>
				</div>


				<div class="form-group">
					<label for="Tarifht">Tarif HT</label>
					<input type="text" name="tarifht" class="form-control" id="tarifht" placeholder="Prix Hors Taxe">
				</div>

				<div class="form-group">
					<label for="TVA">TVA a appliqué:</label>
					<select name="tva" id="TVA" class="form-control">
						<option value="0.055">5.5%</option>
						<option value="0.1">10%</option>
						<option value="0.2">20%</option>
					</select>
				</div>

				<div class="form-group">
					<label for="Photo">Photo</label>
					<input type="file" name="photo" class="form-control" id="Photo" placeholder="Photo du Produit">
				</div>

				<div class="col-xs-12 text-center">
					<button type="submit" class="btn btn-primary" name="produit">Nouveau Produit</button>
				</div>
			</form>
			<!--======================== Fin form Produit ====================-->
		</div>
	</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script>
	$(function(){
		$('.divfade').fadeOut(6000);
	});
</script>
</body>
</html>

