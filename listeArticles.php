<?php 
require_once 'inc/connect.php';
require_once  'inc/calculePrixTtc.php';
require_once 'inc/articleById.php';


$errors = [];	


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
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	
	

</head>
<body>
	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Catégorie/Articles<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="addCatArt.php">ajouter</a></li>
								<li><a href="#">Modifier</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">Supprimer</a></li>
							</ul>
						</li>
						<li><a href="listeArticles.php">Liste des articles</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#">Mon panier <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div>
	</nav>


<div class="container main">
	<div class="page-header">
		<h1>Liste de nos articles</h1>
	</div>
	<div class="row">	
		<?php foreach ($list_arti as $key => $value): ?>

		  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
		    <div class="thumbnail">
		      <img src="assets/img/imgArticles/<?=$value['photo_url']?>" alt="<?=$list_arti['photo_url']?>">
		      <div class="caption">
		        <h3><?=$value['libelle']?></h3>
		        <p class="desc"><?=substr($value['description'],0,20);?>...</p>
		        <p>Prix HT : <strong><?=$value['tarifht']?>€</strong></p>
		        <p>Prix TTC : <strong><?=prixttc($value['tarifht'], $value['tva'])?>€</strong></p>
		        <p>
				  		
				  		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-idart="<?=$value['id']?>">+ plus de détails</button>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

