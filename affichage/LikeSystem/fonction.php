<?php
session_start();

$_SESSION['id']=2;
require('article.php');

function get_jaime($id_article)
{
	$connect = mysqli_connect('mysql-darksya.alwaysdata.net','darksya','cancerino') or die (mysql_error());
	mysqli_select_db($connect, 'darksya_bd') or die ('Pb de sélection BD');
	
	$id_article = (int)$id_article;
	$query =  "SELECT jaime FROM articles WHERE id_article='$id_article'";
	$result = mysqli_query($connect,$query);

	while ($rows= mysqli_fetch_assoc($result)) 
	{
		echo $rows['jaime'];
	}
	return $articles;
}
// Ca récup le nombre de jaime qu'il y a dans la bd youhou

function add_jaime($id_article)
{
	$id_article=(int)$id_article;
	$connect = mysqli_connect('mysql-darksya.alwaysdata.net','darksya','cancerino') or die (mysql_error());
	mysqli_select_db($connect, 'darksya_bd') or die ('Pb de sélection BD');
	$query =  "UPDATE articles SET jaime=jaime+1 WHERE id_article ='$id_article'";
	mysqli_query($connect,$query);
	$query = "INSERT INTO Jaime(id_article,id_membre) VALUES ('$id_article','{$_SESSION['id']}')";
	mysqli_query($connect,$query);
}
// On incrémente le jaime quand le gars appuie sur le bouton, on modifie aussi la table Jaime (Lannister)

function jaime_deja($id_article)
{
	$id_article=(int)$id_article;
	$connect = mysqli_connect('mysql-darksya.alwaysdata.net','darksya','cancerino') or die (mysql_error());
	mysqli_select_db($connect, 'darksya_bd') or die ('Pb de sélection BD');
	$query =  "SELECT * FROM Jaime WHERE id_article='$id_article' AND id_membre='{$_SESSION['id']}'";
	$result = mysqli_query($connect,$query);
	$rows= mysqli_fetch_assoc($result);
	if($rows == 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}
//Ca renvoie un boolean: vrai si on aime déjà ( la relation jaime existe) faux sinon

?>