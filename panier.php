<?php 
session_start();

require_once 'inc/connect.php';
require_once 'inc/calculePrix.php';

	
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Liste des Articles</title>
	
	<?php require_once 'inc/headerlink.php'; ?>
	
</head>
<body>
	 
	<?php require_once 'inc/nav.php'; ?>

	<div class="container main">
	<div class="page-header">
		<h1>Votre Panier</h1>
	</div>
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
		<div class="row text-center">
			<a href="supprpanier.php" class="btn btn-primary">Supprimer le panier</a>
			<a href="verifSessionUser.php" class="btn btn-primary">Commander !</a>
		</div>

	</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


</body>
</html>


