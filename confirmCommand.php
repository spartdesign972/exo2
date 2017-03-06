<?php 
session_start();

require_once 'inc/connect.php';
require_once  'inc/calculePrix.php';
require_once 'inc/articleById.php';

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] === 'buy'){
		$req = $bdd->prepare('INSERT INTO orders (product, id_client, date_create) VALUES (:product, :id_client, now())');
		
		$req->bindValue(':product', json_encode($_SESSION['panier']));
		$req->bindValue(':id_client', $_SESSION['me']['id'], PDO::PARAM_INT);

		if($req->execute()){
			
			$success = 'panier sauvegarder';
			unset($_SESSION['panier']);

		}else{
			var_dump($req->errorInfo());
		}

	}
}

	// Listing de toutes les produits
	$arti = $bdd->prepare('SELECT * FROM produits');

	if($arti->execute()){
		$list_arti = $arti->fetchAll(PDO::FETCH_ASSOC);
	}else{
		var_dump($arti->errorInfo());
	}


?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Confirmer votre commande</title>
	
	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
	
	<?php require_once 'inc/nav.php'; ?>


<div class="container main">
	<div class="page-header">
		<h1>Liste de vos articles séléctionner !</h1>
	</div>
	<?php if(isset($success)): ?>
	    <div class="alert alert-success alert-dismissible divfade" role="alert"">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<span class="glyphicon glyphicon-okn" aria-hidden="true"></span>
	        <span class="sr-only">Error:</span>
	        <?= $success; ?>
	    </div>
    <?php endif; ?>
	<div class="row">	
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Nom de l'article</th>
					<th>Quantité</th>
					<th>Prix(unitaire)</th>
					<th>Prix total</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(isset($_SESSION['panier'])):
					$nbArticles=count($_SESSION['panier']['nomArticle']);
				   if ($nbArticles <= 0)
				   		echo "<tr><td>Votre panier est vide </ td></tr>";
					?>
					<?php for ($i = 0; $i < $nbArticles; $i++): ?>
					<tr>
						<td><?=$_SESSION['panier']['nomArticle'][$i]?></td>
						<td><?=$_SESSION['panier']['quantite'][$i]?></td>
						<td><?=$_SESSION['panier']['prixArticle'][$i]?>€</td>
						<td><?=($_SESSION['panier']['prixArticle'][$i]*$_SESSION['panier']['quantite'][$i])?>€</td>
					</tr>
				<?php endfor;
					endif;
				?>
					<tr>
						<td>Total de la commande : </td>
						<td colspan="3" class="text-center"><strong><?=montanTotal(); ?>€</strong></td>
					</tr>

			</tbody>
		</table>
	</div>
	<div class="row">
		<form method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-xs-12 text-center">
						<button type="button" onclick="javascript:history.back();" class="btn btn-primary">Annuler</button>
						<input type="hidden" name="action" value="buy">
						<button type="submit" class="btn btn-primary">valider la commande</button>
					</div>
				</div>
		</form>
	</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- script jq qui permet d'afficher les elements de l'article selectionner via le champ data-idart du boutton dans la fenetre modal -->
<script src="assets/js/affArticleToModal.js"></script>

</body>
</html>
