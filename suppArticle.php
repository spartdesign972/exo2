<?php 
session_start();

require_once 'inc/connect.php';
require_once  'inc/calculePrixTtc.php';
require_once 'inc/articleById.php';


if(isset($_GET)){
	if(!isset($_GET['idart']) && $_GET['unique'] == 'false'){	// Listing de toutes les produits
		$affArtUnique = false;

		$arti = $bdd->prepare('SELECT * FROM produits');

		if($arti->execute()){
			$list_arti = $arti->fetchAll(PDO::FETCH_ASSOC);
		}else{
			var_dump($arti->errorInfo());
		}
	}
	if(isset($_GET['idart']) && $_GET['unique'] == 'true'){	// Listing de toutes les produits
		$idart = (int)$_GET['idart'];
		$affArtUnique = true;

		$arti = $bdd->prepare('SELECT * FROM produits WHERE id = :idart');

		$arti->bindValue(':idart', $idart, PDO::PARAM_INT);

		if($arti->execute()){
			$list_arti = $arti->fetch(PDO::FETCH_ASSOC);
		}else{
			var_dump($arti->errorInfo());
		}
	}
	if(isset($_GET['idart']) && isset($_GET['suppr'])){

		$idart = (int)$_GET['idart'];

		$req = $bdd->prepare('DELETE FROM produits WHERE id = :idart');

		$req->bindValue(':idart', $idart, PDO::PARAM_INT);

		if($req->execute()){
			header('location: listeArticles.php');
		}else{
			var_dump($arti->errorInfo());
		}

	}
}


?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Suppression d'un Article</title>
	
	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
	
	<?php require_once 'inc/nav.php'; ?>


<div class="container main">
	
	<div class="page-header">
		<h1>Supprimer un Article</h1>
	</div>
	
	<div class="row">	
		
		<?php if($affArtUnique): ?>
			<h3>Voulez-vous supprimer cet article ?</h3>
			<div class="col-xs-12">
				<div class="thumbnail text-center">
			      <img src="assets/img/imgArticles/<?=$list_arti['photo_url'];?>" alt="<?=$list_arti['photo_url'];?>">
			      <div class="caption">
			        <h3><?=$list_arti['libelle'];?></h3>
			        <p class="desc"><?=$list_arti['description'];?></p>
			        <p>Prix HT : <strong><?=$list_arti['tarifht'];?>€</strong></p>
			        <p>Prix TTC : <strong><?=prixttc($list_arti['tarifht'], $list_arti['tva']);?>€</strong></p>
			        <p>
				  			
	  					<a href="suppArticle.php?idart=<?=$list_arti['id'];?>&amp;suppr=true" class="btn btn-primary">oui</a>
		        	</p>
		      	</div>
		    </div>
		  </div>
		<?php endif; ?>

	</div>
		
	<?php if(!$affArtUnique): ?>
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Nom de l'article</th>
					<th>Prix HT</th>
					<th>Prix TTC</th>
					<th>supprimer</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach($list_arti as $value): ?>
				<tr>
					<td><?=$value['libelle'];?></td>
					<td><?=$value['tarifht'];?></td>
					<td><?=prixttc($value['tarifht'], $value['tva']);?>€</td>
					<td><a href="suppArticle.php?idart=<?=$value['id'];?>&amp;unique=true" class="btn btn-primary">Supprimer cet article</a></td>
				</tr>
				<?php endforeach; ?>

			</tbody>
		</table>
	<?php endif; ?>
</div>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


</body>
</html>