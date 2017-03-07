<?php 
session_start();

require_once 'inc/connect.php';
require_once 'inc/calculePrix.php';

if(!empty($_GET['id'])){

	$idclient = (int)$_GET['id'];

	$req = $bdd->prepare('SELECT product FROM orders WHERE id_client = :idclient');

	$req->bindValue(':idclient', $idclient, PDO::PARAM_INT);

	if($req->execute()){
		$panierSav = $req->fetchAll(PDO::FETCH_ASSOC);
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
		<h1>Mes commandes enregistrer</h1>
		<?php var_dump($panierSav); ?>
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
			if(isset($panierSav)):
				for($i=0; $i < count($panierSav); $i++){
					$product[$i] = json_decode($panierSav[$i]['product'], true);
					for($j=0; $j < count($product[$i]); $j++){
					echo $product[$i]['nomArticle'][$j].' '.$product[$i]['quantite'][$j].' '.$product[$i]['prixArticle'][$j].'<br>';
					}
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