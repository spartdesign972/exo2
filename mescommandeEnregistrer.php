<?php 
session_start();

require_once 'inc/connect.php';
require_once 'inc/calculePrix.php';

if(!empty($_GET['idsuppr'])){

	$id = (int)$_GET['idsuppr'];

	$req = $bdd->prepare('DELETE FROM orders WHERE id = :idsuppr');

	$req->bindValue(':idsuppr', $id, PDO::PARAM_INT);

	if($req->execute()){
		$success = 'Panier supprimer';
	}else{
		var_dump($req->errorInfo());
	}
}



if(!empty($_GET['id'])){

	$idclient = (int)$_GET['id'];

	$req = $bdd->prepare('SELECT * FROM orders WHERE id_client = :idclient');

	$req->bindValue(':idclient', $idclient, PDO::PARAM_INT);

	if($req->execute()){
		$panierSav = $req->fetchAll();
	}else{
		var_dump($req->errorInfo());
		die;
	}

}

?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Mes commandes enregistrer</title>
	
	<?php require_once 'inc/headerlink.php'; ?>
	
</head>
<body>
	 
	<?php require_once 'inc/nav.php'; ?>

	<div class="container main">
	<div class="page-header">
		<h1>Mes commandes enregistrées</h1>
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
		<?php print_r(count($panierSav)); ?>
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Nom de l'article</th>
					<th class="text-right">Quantité</th>
					<th class="text-right">Prix(unitaire)</th>
					<th class="text-right">Prix total</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if(isset($panierSav)):
				// on calcule la taille total du tableau 
				for($i=0; $i < count($panierSav); $i++){
					// définition de la variable pour stocker les sommes des differnetes "lignes" d'articles
					$somTot = [];
					echo '<tr><td colspan="4" class="text-center"><strong>Commande N° : '.($i + 1).'</strong> (en date du : '.$panierSav[$i]['date_create'].')</td> </tr>';
					// parse du JSON en tableau associatif sur le champ product (parse avec json_encode a la sauvegarde) 
					$product[$i] = json_decode($panierSav[$i]['product'], true);
					print_r(count($product[$i]));
					
					// on calcule la taille de CE (JSON) tableau associatif	
					for($j=0; $j < count($product[$i]); $j++){
					echo '<tr>';
						echo '<td>'.$product[$i]['nomArticle'][$j].'</td>';
						echo '<td class="text-right">'.$product[$i]['quantite'][$j].'</td>';
						echo '<td class="text-right">'.$product[$i]['prixArticle'][$j].'</td>';
						echo '<td class="text-right">'.($product[$i]['quantite'][$j] * $product[$i]['prixArticle'][$j]).'</td>';
					echo '</tr>';

					// stockage des "sommes d'article" dans le tableau
					array_push($somTot, floatval(($product[$i]['quantite'][$j] * $product[$i]['prixArticle'][$j])));
					}
					echo '<tr>';
						echo '<td>Montant total de la commande : </td>';
						// Calcule et affichage de la somme du tableau qui correspond donc a la somme totale de la commande.
						echo '<td colspan="3" class="text-right"><strong>'.array_sum($somTot).'</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td colspan="4" class="text-right"><a href="mescommandeEnregistrer.php?idsuppr='.$panierSav[$i]['id'].'" class="btn btn-primary">Supprimer ce panier</a></td>';
					echo '</tr>';
				}
			endif;
			?>
			</tbody>
		</table>

	</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


</body>
</html>