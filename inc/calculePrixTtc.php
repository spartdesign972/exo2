<?php 

// Fonction qui calcule le prix ttc avec comme argument le prix hors taxe et la tva
function prixttc($prixht, $tva){
	$prix_ht = (float)$prixht;
	$tvaAppliquer = (float)$tva;

	return round($prixttc = $prix_ht + ($prix_ht * $tvaAppliquer),1, PHP_ROUND_HALF_EVEN);
}

?>