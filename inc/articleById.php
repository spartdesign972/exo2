<?php 

require_once 'connect.php';
require_once 'calculePrixTtc.php';

$affArticle = $bdd->prepare('SELECT * FROM produits WHERE id = :idarticle');

if(isset($_GET['idarticle']) && !empty($_GET['idarticle'])){
	
	$idArticle = (int)$_GET['idarticle'];
	

	$affArticle->bindValue(':idarticle', $idArticle, PDO::PARAM_INT);

	if($affArticle->execute()){
		$articleSel = $affArticle->fetch(PDO::FETCH_ASSOC);
		$prixttc = prixttc($articleSel['tarifht'], $articleSel['tva']);
		$articleSel['prixttc'] = $prixttc;
		echo json_encode($articleSel);
		
	}else{
		var_dump($affArticle->errorInfo());
	}
}

?>