<?php

require_once 'DisplayMenu.php';
require_once 'startpage.php';
require_once 'endpage.php';

function affichercontenu($nomDePage, $articleaAfficher, $lieudeconnexion, $contenu, $Repertory = null) {
    $allInclude = '';
    // $lieudeconnexion : Actualités, Mamessagerie, Monblog, Mesfavoris, Moncompte, Messources
    // Faut choper l'username du mec qui fait le blog ou on va 
    // La mise en page pour le contenu de 'Messources', 'Moncompte' 'Mamessagerie' est pas finalisée'
    // Un petit lien à rajouter

    $vue = startPage($nomDePage, $articleaAfficher, $Repertory);
    $vue .= DisplayMenu();
    $vue .= DisplayLeftMenu($lieudeconnexion, $Repertory);

    if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {

        $allInclude = "\n\t" . '<div id = "conteneur-logo" >' .
                "\n\t\t" . '<a href="' . $Repertory . 'index.php" ><img src="' . $Repertory . 'affichage/images/Logo2.png" alt="Logo" title="Keep All In One"/></a>' .
                "\n\t" . '</div>' .
                "\n\t" . '<div id = "fond" >' .
                "\n\t\t" . '<div id = "contenu" >' .
                "\n\t\t\t" . '<br/>';

        if ($lieudeconnexion == "Actualités") {
            
            include 'affichage/Article.php';
            $gestionSource = new GestionSourceUser($_SESSION['pseudo']);
            if (!empty($gestionSource->doesUserhaveSource()['IDuser'])) {
                $allInclude .=
                        "\n\t\t\t" . '<h1> Actualités </h1> <br/>' .
                        "\n\t\t\t" . '<h3> Tous vos flux </h3>';
                //include 'User/GestionSourceUser.php';
                $gestionSource->extractAllIdSource();
                //$gestionSource->extractAllArticles();
                //var_dump($gestionSource->sortAllArticle());
                //var_dump($gestionSource->getAllIdArticles());
                //foreach ($gestionSource->getAllIdArticles() as $idArticles) {
                    foreach ($gestionSource->sortAllArticle() as $key => $idArticle) {
                        //echo $key . '<br/>';
                        if ($key > 1) {
                            $article = new Article($key, file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $key  . '.html'));
                            $allInclude .= $article->afficher_Article();
                        }
                    }
               // }
            } else {
                $allInclude .=
                        "\n\t\t\t" . '<div class = "articles"  id="mode-emploi-haut" onClick="afficher_cacher(\'mode-emploi\')">' .
                        "\n\t\t\t\t" . '<h2>Bienvenue sur KeepAllInOne </h2>' .
                        "\n\t\t\t\t" . '<img class= "image-article" src="affichage/images/Background.png" alt="article" title="Image article">' .
                        "\n\t\t\t\t" . '<div class = "article">' .
                        "\n\t\t\t\t\t" . '<h4 class="like"> Mode d\'emploi du site </h4>' .
                        "\n\t\t\t\t\t" . '<p class = "texte">Vous n\'avez pas encore ajouté de sources, cliquez içi pour en savoir plus sur notre site et comment naviguer, gérer vos sources, ajouter vos flux et bien plus de fonctionnalités !</p>' .
                        "\n\t\t\t\t" . '</div>' .
                        "\n\t\t\t" . '</div>' .
                        "\n\t\t\t" . '<div class="article-complet" id="mode-emploi">' .
                        "\n\t\t\t\t" . '<img src="affichage/images/mode_emploi.png" alt="mode d\'emploi" title="mode d\'emploi">' .
                        "\n\t\t\t" . '</div>';
            }
        } elseif ($lieudeconnexion == "Mes favoris") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Favoris </h1> <br/>';

            include 'favoris/GestionFavori.php';
            include 'affichage/ShowExtractSource.php';
            include 'affichage/Article.php';

            $gestionFavori = new GestionFavori();
            $allInclude .= $gestionFavori->showAllSources() . '<br />';
            $arrayForALLLLLLL = [];
            foreach ($gestionFavori->getAllSourceName() as $sourceName) {
                $showExtract = new ShowExtractSource($sourceName);
// var_dump($showExtract->sortAllArticleWithID());
                foreach ($showExtract->sortAllArticleWithID() as $key => $idArticle) {
//echo $key . '<br/>';
                    if ($key > 1) {
                        /* $article = new Article($key, file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $key . '.html'));
                          $allInclude .= $article->afficher_Article(); */
                        $arrayForALLLLLLL[$key] = $idArticle;
                    }
                }
            }
            array_merge($arrayForALLLLLLL);
            arsort($arrayForALLLLLLL);
            //var_dump($arrayForALLLLLLL);
            foreach ($arrayForALLLLLLL as $key => $idArticle) {
//echo $key . '<br/>';
                if ($key > 1) {
                    $article = new Article($key, file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $key . '.html'));
                    $allInclude .= $article->afficher_Article();
                }
            }
        } elseif ($lieudeconnexion == "MonBlog") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Bienvenue' . /* Mettre le nom du créateur du blog ici */ '</h1> <br/>';
            include 'blog/ClassBlog.php';
            include 'affichage/Article.php';
            $blog = new Blog();
            foreach ($blog->getIdArticles() as $article) {
                if (count($article) > 0) {
                    $article = new Article($article['IDarticle'], file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $article['IDarticle'] . '.html'));
                    $allInclude .= $article->afficher_Article();
                }
			}
		} elseif ($lieudeconnexion == 'gererMesSources') {
			include_once 'favoris/GestionFavori.php';
			$gestionSourceUser = new GestionSourceUser($_SESSION['pseudo']);
			$allInclude .= '
			<div id="contact-form">
				<h1 class="titre-a-propos">Ajouter une source</h1>
				<h2>http://www..., Flux rss, #tweets, @twitterUser</h2>
				<form method="post" action="User/gererMesSources_Processing.php" id="form-appear">
					<label>
							<p class="label" >Nom: <span class="required">*</span></p>
					</label>
					<input type="text" name="Source" id="nom" size=40 maxlength="250" value="" /> <br/>
					<br />
					<label>
							<p class="label" >Catégorie: <span class="required">*</span></p>
					</label>
					<select name="OldCategorie"><option name="OldCategorie" value="Nouvelle"> Nouvelle Catégorie</option> ';
			foreach($gestionSourceUser->extractAllCategories() as $categories){
				$allInclude .= '
					<option name="OldCategorie" value="' . $categories['Categorie'].'">'. $categories['Categorie'] . '</option>';
			}
			$allInclude .='
					</select> 
						<label class="label">
								Nouvelle Catégorie: <span class="required">*</span>
						</label>
						<input type="text" name="Categorie" id="nom" size=40 maxlength="250" value="" /> <br/>
						<br />
						<input type="submit" value="Envoyer" id="submit-button" />
						<p id="req-field-desc"><span class="required">*</span> <label class="label">Champs requis</label>
				</form>
			</div>
			<div id="contact-form">
				<h1 class="titre-a-propos">Gérer mes sources</h1>
				<h2>Supprimer / ajouter aux favoris</h2> ';

            
            $allCategoriesWithSource = $gestionSourceUser->getAllSourcesByCategorie();
            $allSourceName = $gestionSourceUser->getAllSourceName();

            /* $allSources = new DOMDocument('1.0', 'utf-8');
              $allSources->load(__DIR__ . '/../User/' . $_SESSION['pseudo'] . '/' . $_SESSION['pseudo'] . '_Sources.xml');
              $allSources = $allSources->getElementsByTagName('Source'); */
                $allInclude .= '
				<form action="User/gererMesSources_Processing.php" method="post">
						<label class="label" >Changer une source de catégorie<span class="required">*</span></label>
							<select name="OldCategorie"><option name="OldCategorie" value="Nouvelle"> Nouvelle Catégorie</option> ';
										foreach($gestionSourceUser->extractAllCategories() as $categories){
											$allInclude .= '<option value="' . $categories['Categorie'].'">'. $categories['Categorie'] . '</option>';
										}
										 $allInclude .='</select>
							<select name="OldPosition">';
										foreach($gestionSourceUser->extractAllSourceName() as $categories){
											$allInclude .= '<option value="' . $categories .'">'. $categories . '</option>';
										}
										$allInclude .=
							'</select>
							<label class="label">
								Nouvelle Catégorie: <span class="required">*</span>
							</label>
					<input type="text" name="NewCategorie" id="nom" size=40 maxlength="250" value="" /> <br/>
					<br />
					<input type="submit" value="Envoyer" name="ChangementCategorie" id="submit-button" /></form><br/><br/>';
								 
                                             
                                             
            foreach ($allCategoriesWithSource as $key => $Categories) {
                $allInclude .= '<br/><br/><h2>Catégorie: ' . $key . '</h2>';
                foreach ($Categories as $categorie) { // En théorie c'est ça
                    foreach ($categorie as $source)
                    //faut que $sources soit classé alphabétique avec les favoris d'abord
                    /* if ($source->nodeName == 'Favoris') {
                      $contenu .= "\n\t\t\t" . '<form class="source" action="action.php" method="post">';
                      $contenu .= "\n\t\t\t\t" . '<input class="source" type="button" value=" ♥ ' . $source . '">';
                      $contenu .= "\n\t\t\t" . '</form>';
                      } else { */
                        $allInclude .= '<h3 class="nom-source">Source: ' . $allSourceName[$source] . '</h3>';
                    if (!$gestionSourceUser->isFavorite($allSourceName[$source])) {
                        $allInclude .= "\n\t\t\t\t" . '<form action="favoris/GestionSource.php" method="post">';
                        $allInclude .= "\n\t\t\t\t\t" . '<input type="submit" name ="' . $gestionSourceUser->getIDSourceFromNomUniq($allSourceName[$source])['ID'] . '" value="Ajouter Favoris">';
                        $allInclude .= "\n\t\t\t\t" . '</form>';
                    } else {
                        $allInclude .= "\n\t\t\t\t" . '<form action="favoris/GestionSource.php" method="post">';
                        $allInclude .= "\n\t\t\t\t\t" . '<input type="submit" name ="' . $gestionSourceUser->getIDSourceFromNomUniq($allSourceName[$source])['ID'] . '" value="Supprimer Favoris">';
                        $allInclude .= "\n\t\t\t\t" . '</form>';
                    }
                    $allInclude .= "\n\t\t\t\t" . '<form action="favoris/GestionSource.php" method="post">';
                    $allInclude .= "\n\t\t\t\t\t" . '<input type="submit" name ="' . $gestionSourceUser->getIDSourceFromNomUniq($allSourceName[$source])['ID'] . '" value="Supprimer Source">';
                    $allInclude .= "\n\t\t\t\t" . '</form><br/><br/>';

                    //}
                }
            }


            $allInclude .= '
           	</div>';
        } elseif ($lieudeconnexion == "Moncompte") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Mon compte </h1> <br/>' .
                    "\n\t\t\t" . '<h3> Modifier mes informations </h3>';
        } elseif ($lieudeconnexion == "MesSources") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Mes sources </h1> <br/>' .
                    "\n\t\t\t" . '<h3> Gérer mes sources </h3>';
        } elseif ($lieudeconnexion == "MaMessagerie") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Ma messagerie </h1> <br/>' .
                    "\n\t\t\t" . '<h3> Mes mails </h3>';
        } elseif ($lieudeconnexion == "categorie") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Catégorie : ' . $nomDePage . ' </h1> <br/>';
            include 'affichage/ShowExtractSource.php';
            include 'affichage/Article.php';
            $showExtract = new ShowExtractSource($nomDePage);
            foreach ($showExtract->sortAllArticle() as $key => $idArticle) {
                //echo $key . '<br/>';
                if ($key > 1) {
                    $article = new Article($key, file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $key . '.html'));
                    $allInclude .= $article->afficher_Article();
                }
            }
        } elseif ($lieudeconnexion == "source") {
            $allInclude .=
                    "\n\t\t\t" . '<h1> Source : ' . $nomDePage . ' </h1> <br/>';
            include 'affichage/ShowExtractSource.php';
            include 'affichage/Article.php';
            $showExtract = new ShowExtractSource($nomDePage);
            foreach ($showExtract->sortAllArticleWithID() as $key => $article) {
                if ($article > 0) {
                    $Newarticle = new Article($key, file_get_contents('/home/keepalliin/www/Extraction/Sources/Articles/' . $key . '.html'));
                    $allInclude .= $Newarticle->afficher_Article();
                }
            }
        }
    } else {

        //
        // Il faut mettre le lien de connexion dans le a class sinscrire
        //
        $allInclude .=
                "\n\t" . '<div id = "conteneur-logo" >' .
                "\n\t\t" . '<a href="../index.php"><img src="' . $Repertory . 'affichage/images/Logo2.png" alt="Logo" title="Keep All In One"></a>' .
                "\n\t\t" . '<a class= "sinscrire" href ="../inscription.php" ></a>' .
                "\n\t" . '</div>' .
                "\n\t" . '<div id = "fond" >' .
                "\n\t\t" . '<div id = "contenu" >' .
                "\n\t\t\t" . '<br/><br/><br/><h2 class="teaser">Inscrivez vous, c\'est gratuit et rapide! <br/><br/></h2> ';
        "\n\t\t" . '</div>' .
                "\n\t" . '</div>';
    }



    $vue .= $allInclude;
    $vue .=$contenu;
    $vue .= endpage($Repertory);
    return $vue;
}

?>
