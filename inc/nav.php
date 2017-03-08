<?php 

// verification si le user a un panier sauvegarder
if(!empty($_SESSION['me']) || ($_SESSION['is_logged'] == true)){
	$req = $bdd->prepare('SELECT COUNT(*) FROM orders WHERE id_client = :idclient');

	$req->bindValue(':idclient',$_SESSION['me']['id'], PDO::PARAM_INT);

	if($req->execute()){
		$nbPanierSav = $req->fetchcolumn();
	}else{
		var_dump($req->errorInfos());
	}
}


// on calcule et affiche le nombre d'article
if(isset($_SESSION['panier'])){
	$nbart = 0;
	foreach ($_SESSION['panier']['quantite'] as $value) {
		$nbart += $value;
	}
}else{
	$nbart = 0;
}
$errors = [];

?>
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
								<li><a href="suppArticle.php?unique=false">Supprimer</a></li>
							</ul>
						</li>
						<li><a href="listeArticles.php">Liste des articles</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div>
	</nav>
	<div class="cartouchePanier">
		<?php if(isset($_SESSION['me'])):?>
			<p>Bonjour: <?=$_SESSION['me']['firstname']?> <?=$_SESSION['me']['lastname']?></p>
			<a href="logout.php">Me Déconnecter</a><br>
		<?php else: ?>
			<a href="login.php">Me Connecter</a><br>
		<?php endif; ?>

		<?php if(!empty($_SESSION['panier'])):?>
			<a href="panier.php">Mon panier <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;<?=$nbart?>&nbsp;Article(s)</a>
		<?php endif; ?>

		<?php if(isset($nbPanierSav)):?>
			<br><a href="././mescommandeEnregistrer.php?id=<?=$_SESSION['me']['id']?>">Vous avez <?=$nbPanierSav ?> panier sauvegarder</a>
		<?php endif; ?>
	</div>