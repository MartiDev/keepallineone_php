<?php

function recup_articles()
{
	$connect = mysqli_connect('mysql-darksya.alwaysdata.net','darksya','cancerino') or die (mysql_error());
	mysqli_select_db($connect, 'darksya_bd') or die ('Pb de sélection BD');
	// A mettre tout les trucs de BD en pdo après
	
	$article = array();
	
	$query =  "SELECT * FROM articles";
	$result = mysqli_query($connect,$query);

	while ($rows= mysqli_fetch_assoc($result)) 
	{
		$articles[] = $rows;
	}
	return $articles;
	// Basiquement on met tout les articles dans un tableau pour les récup après
}

?>