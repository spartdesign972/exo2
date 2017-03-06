<?php
session_start();
require_once 'inc/connect.php';

$post = [];
$errors = [];

if(!empty($_POST)){
	// Nettoyage des données
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(!filter_var($post['ident'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'L\'adresse email est invalide';
	}
	if(empty($post['password'])){
		$errors[] = 'Le mot de passe doit être complété';
	}

	if(count($errors) === 0){
		
		$select = $bdd->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
		$select->bindValue(':email', $post['ident']);
		
		if($select->execute()){
			// Permet de stocker l'utilisateur correspondant à l'email dans $user
			$user = $select->fetch(PDO::FETCH_ASSOC);

			if(!empty($user)){
				if(password_verify($post['password'], $user['password'])){
					// Ici le mot de passe saisi correspond à celui en base de données
					$_SESSION['is_logged'] = true;
					$_SESSION['me'] = [
						'id' 		=> $user['id'],
						'firstname'	=> $user['firstname'],
						'lastname'	=> $user['lastname'],
						'email'		=> $user['email'],
					];

					header('Location: listeArticles.php'); // Redirection vers l'ajout de recette
					die;
				}
				else { // password_verify
					$errors[] = 'Le couple identifiant/mot de passe est invalide';
				}
			}
			else { // utilisateur inexistant, donc email inexistant en bdd
				$errors[] = 'Le couple identifiant/mot de passe est invalide';
			}
		}
	}
	if(!empty($errors)){
		$texterrors = implode('<br>', $errors);
	}
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

	<title>Connexion</title>
	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
<?php require_once 'inc/nav.php'; ?>

<div class="container main">

	<?php if(isset($texterrors)): ?>
	    <div class="alert alert-danger alert-dismissible" role="alert"">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
	        <span class="sr-only">Error:</span>
	        <?=$texterrors; ?>
	    </div>
    <?php endif; ?>

	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">

	<form method="POST" class="form-horizontal" role="form">
	
		<div class="form-group">
			<label for="ident">Identifiant</label>
			<input type="email" name="ident" id="ident" class="form-control">
		</div>

		
		<div class="form-group">
			<label for="password">Mot de passe</label>
			<input type="password" name="password" id="password" class="form-control"> 
		</div>

		<div class="row">
			<div class="col-xs-6 text-left">
				<button type="submit" class="btn btn-primary">Se connecter</button>
			</div>
			<div class="col-xs-6  text-right">
				<a href="creatUser.php" class="btn btn-primary" >pas encore membre ?</a>
			</div>
		</div>
	</form>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</body>
</html>