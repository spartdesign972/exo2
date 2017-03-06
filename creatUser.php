<?php 
session_start();

require_once 'inc/connect.php';

$errors = [];
$post = []; // Contiendra les données épurées <3 <3


if(!empty($_POST)){

	// équivalent au foreach de nettoyage
	$post = array_map('trim', array_map('strip_tags', $_POST)); 

	if(strlen($post['lastname']) < 2) {
		$errors[] = "Le champ Nom doit avoir au minimum 2 caractères";
	}

	if(strlen($post['firstname']) < 2) {
		$errors[] = "Le champ Prénom doit avoir au minimum 2 caractères";
	}

	if(strlen($post['password']) < 8 || strlen($post['password']) > 20) {
		$errors[] = "Le champ Password doit avoir au minimum 8 caractères";
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Le champ Email n'est pas conforme";
	}

	if(!is_numeric($post['phone']) || strlen($post['phone']) != 10) {
		$errors[] = "Le champ Téléphone doit avoir 10 chiffres";
	}

	if(strlen($post['address']) < 2) {
		$errors[] = "Le champ Adresse doit avoir au minimum 2 caractères";
	}

	if(!is_numeric($post['zipcode']) || strlen($post['zipcode']) != 5) {
		$errors[] = "Le champ Code Postal doit avoir 5 chiffres";
	}

	if(strlen($post['city']) < 2) {
		$errors[] = "Le champ Ville doit avoir au minimum 2 caractères";
	}

	if(count($errors) === 0)
	{
		$insert = $bdd->prepare('INSERT INTO users (lastname, firstname, password, email, phone, address, zipcode, city) VALUES (:lastname, :firstname, :password, :email, :phone, :street, :zipcode, :city)');
		$insert->bindValue(':lastname', $post['lastname']);
		$insert->bindValue(':firstname', $post['firstname']);
		$insert->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$insert->bindValue(':email', $post['email']);
		$insert->bindValue(':phone', $post['phone']);
		$insert->bindValue(':street', $post['address']);
		$insert->bindValue(':zipcode', $post['zipcode']);
		$insert->bindValue(':city', $post['city']);

		if($insert->execute())
		{
			$success = 'Félicitations vous êtes inscrit';
		}else{
			var_dump($insert->errorInfo());
		}
	}else{
		$textErrors = implode('<br>', $errors);
	}

}

?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Ajouter un utilisateur</title>

	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
<?php require_once 'inc/nav.php'; ?>

<div class="container main">
	<?php if(isset($textErrors)): ?>
	    <div class="alert alert-danger alert-dismissible" role="alert"">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
	        <span class="sr-only">Error:</span>
	        <?= $textErrors; ?>
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
		<div class="col-xs-8 col-xs-offset-2">

	<form method="post" class="form-horizontal" role="form">
		<legend>Veuillez vous inscrire</legend>
		<div class="form-group">
			<label for="firstname">Prénom</label>
			<input type="text" name="firstname" id="firstname" class="form-control">
		</div>

		<div class="form-group">
			<label for="lastname">Nom</label>
			<input type="text" name="lastname" id="lastname" class="form-control">
		</div>


		<div class="form-group">
			<label for="password">Mot de passe</label>
			<input type="password" name="password" id="password" class="form-control">
		</div>

		<div class="form-group">
			<label for="email">Adresse email</label>
			<input type="email" name="email" id="email" class="form-control">
		</div>

		<div class="form-group">
			<label for="phone">Téléphone</label>
			<input type="text" name="phone" id="phone" class="form-control">
		</div>

		<div class="form-group">
			<label for="address">Adresse</label>
			<input type="text" name="address" id="address" class="form-control">
		</div>

		<div class="form-group">
			<label for="zipcode">Code postal</label>
			<input type="text" name="zipcode" id="zipcode" class="form-control">
		</div>

		<div class="form-group">
			<label for="city">Ville</label>
			<input type="text" name="city" id="city" class="form-control">
		</div>

		<input type="submit" value="Ajouter le membre" class="btn btn-primary">

	</form>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>