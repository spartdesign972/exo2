<?php 
session_start();

require_once 'inc/connect.php';
require_once  'inc/calculePrix.php';
require_once 'inc/articleById.php';



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
	<title>Liste des Articles</title>
	
	<?php require_once 'inc/headerlink.php'; ?>

</head>
<body>
	
	<?php require_once 'inc/nav.php'; ?>


<div class="container main">
	<div class="page-header">
		<h1>Liste de nos articles</h1>
	</div>
	<div class="row">	
		<?php foreach ($list_arti as $key => $value): ?>

		  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
		    <div class="thumbnail">
		      <img src="assets/img/imgArticles/<?=$value['photo_url']?>" alt="<?=$list_arti['photo_url']?>"">
		      <div class="caption">
		        <h3><?=$value['libelle']?></h3>
		        <p class="desc"><?=substr($value['description'],0,20);?>...</p>
		        <p>Prix HT : <strong><?=$value['tarifht']?>€</strong></p>
		        <p>Prix TTC : <strong><?=prixttc($value['tarifht'], $value['tva'])?>€</strong></p>
		        <p>
				  		
				  		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-idart="<?=$value['id'];?>">+ plus de détails</button>
				  		<a href="suppArticle.php?idart=<?=$value['id'];?>&amp;unique=true" class="btn btn-primary">Supprimer cet article</a>
		        </p>
		      </div>
		    </div>
		  </div>
		<?php endforeach; ?>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
				
				<div class="thumbnail">
				  <div class="caption">
						
				  </div>
				</div>
		    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-left" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- script jq qui permet d'afficher les elements de l'article selectionner via le champ data-idart du boutton dans la fenetre modal -->
<script src="assets/js/affArticleToModal.js"></script>

</body>
</html>

