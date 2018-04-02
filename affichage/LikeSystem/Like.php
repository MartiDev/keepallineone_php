<?php
require_once ('fonction.php');
?>
<!doctype html>
<html>
	<head>
		<title> Cancer </title>
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="fonction.js"></script>
	</head>
	<body>
	<?php

		
		$articles = recup_articles();
		
		foreach($articles as $article)
		{
			echo '<div class= "wrapper-jaime" ><p>' . $article['article'] . "<div class=\"".$article['id_article']."\">Partager</div>(<span class= \"id".$article['id_article']."\">".$article['jaime']. '</span>) ont partagé</p> </div>';
		}
	?>
	</body>
</html>