<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=exo_produits;charset=utf8', 'root', '');
}catch(PDOException $e){
	echo 'Echec de la connection a la base de donnée'.$e->getMessage();
	die;
}