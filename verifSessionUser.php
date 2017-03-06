<?php
session_start();



if(!empty($_SESSION['me']) || ($_SESSION['is_logged'] == true)){

	header('location: confirmCommand.php');

}else{
	header('location: login.php');
}





?>