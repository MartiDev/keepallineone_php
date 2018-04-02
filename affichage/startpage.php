<?php

function startPage($titre, $articlesaAfficher = null, $Repertory = null) {
    $contenu = '<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>' . $titre . '</title>
	<link rel="stylesheet" href="' . $Repertory . '/affichage/CSS/style.css">
	<link rel="icon" type="image/png" href="' . $Repertory . 'affichage/images/fav96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="' . $Repertory . 'affichage/images/fav16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="' . $Repertory . 'affichage/images/fav32.png" sizes="32x32">
	<link rel="apple-touch-icon" href="' . $Repertory . 'affichage/images/fav60.png" sizes="60x60" >
	<meta name="description" content="Keep All In One, Agrégateur de flux, Aaron">
	<meta name="keywords" content="actualité, blog, connexion, favoris, articles, Keep All In One, Aaron">
	<meta name="author" content="Mathieu Martinez, Maxime Martinez, Jean-Adam Puskaric, Raphael Ostrov">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="' . $Repertory . 'affichage/Js/afficher_cacher_div.js"></script>
    <script type="text/javascript" src="' . $Repertory . 'affichage/Js/VerifyInput.js"></script>
	<script type="text/javascript" src="' . $Repertory . 'affichage/Js/iscroll.js"></script>
    <script type="text/javascript" src="' . $Repertory . 'affichage/Js/blog_inc.js"></script>
	<script type="text/javascript">
	function loaded() {';
	if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {
	$contenu .= '
		myScroll = new IScroll(\'#wrapper\', {
			mouseWheel: true,
			scrollbars: \'custom\'
		});';
	}
        
        /*if(isset($articlesaAfficher)){
            foreach ($articlesaAfficher as $article){
                echo 'afficher_cacher(\'' . article.getId
            }
        }*/
    	$contenu .= '
	$("a[href=\'#top\']").click(function() {
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		}); 
	}
	</script>
</head>
<body onload="loaded()">';
    
    return $contenu;
}

?>
