<?php 

// Fonction qui calcule le prix ttc avec comme argument le prix hors taxe et la tva
function prixttc($prixht, $tva){
	$prix_ht = (float)$prixht;
	$tvaAppliquer = (float)$tva;

	return round($prixttc = $prix_ht + ($prix_ht * $tvaAppliquer),1, PHP_ROUND_HALF_EVEN);
}


function montanTotal(){

	$total = 0;
	if(isset($_SESSION['panier'])){
		$nbprix=count($_SESSION['panier']['prixArticle']);
		for ($i = 0; $i < $nbprix; $i++){
			$total += $_SESSION['panier']['prixArticle'][$i]*$_SESSION['panier']['quantite'][$i];
		}
	}
	return $total;
}

?>