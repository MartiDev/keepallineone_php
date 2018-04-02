<?php

require('fonction.php');
if(isset($_POST['id_article'],$_SESSION['id']))
{
	$id_article=$_POST['id_article'];
	
	if(jaime_deja($id_article) == true)
	{
		echo'nope';
		// sinon non
	}
	else
	{	
		add_jaime($id_article);
		echo'ok';
		//On fait appel à la fonction qui ajoute visuiellement un jaime ( javascript )
	}
}
// Si la fonction renvoie ok on a un traitement différent dans fonction.js
?>