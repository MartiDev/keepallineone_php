<?php
require('fonction.php');

	if(isset($_POST['id_article'],$_SESSION['id']))
	{
		$id_article = $_POST['id_article'];
		echo get_jaime($id_article);
	}
?>