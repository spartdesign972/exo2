<?php 

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
								<li><a href="#">Supprimer</a></li>
							</ul>
						</li>
						<li><a href="listeArticles.php">Liste des articles</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="panier.php">Mon panier <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;<?=$nbart?>&nbsp;Article(s)</a>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div>
	</nav>