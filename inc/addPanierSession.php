<?php 
session_start();


if(!isset($_SESSION['panier'])){
	$_SESSION['panier'] = array();
	$_SESSION['panier']['nomArticle'] = array();
	$_SESSION['panier']['quantite'] = array();
	$_SESSION['panier']['prixArticle'] = array();

}



if(isset($_GET) && !empty($_GET)){
	$nomarticle = (isset($_GET['nomproduit'])? $_GET['nomproduit']:null);
	$prixarticle = (isset($_GET['prixttc'])? $_GET['prixttc']:null);
	$quantite = (isset($_GET['q'])? $_GET['q']:null);

	$prixarticle = floatval($prixarticle);
	$quantite = intval($quantite);

	$articlepresent = array_search($nomarticle, $_SESSION['panier']['nomArticle']);
	if($articlepresent !== false){
		$_SESSION['panier']['quantite'][$articlepresent] += $quantite;
	}else{
		array_push($_SESSION['panier']['nomArticle'], $nomarticle);
		array_push($_SESSION['panier']['quantite'], $quantite);
		array_push($_SESSION['panier']['prixArticle'], $prixarticle);
		
	}
}

header('location: ../listeArticles.php');

?>