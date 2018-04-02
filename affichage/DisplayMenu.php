<?php


function DisplayMenu() {

    // 
    // liens à mettre
    //
	
    $contenu = "\n\t" . '<div id="header">'
            . "\n\t\t" . '<div id="wrapper-header">';
    if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {
        $contenu .=
                "\n\t\t\t" . '<p>Bonjour ' . trim($_SESSION['pseudo'], "'") . '</p>' .
                "\n\t\t\t" . '<div id="wrapper-compte">' .
                "\n\t\t\t\t" . '<a class="compte" href="/Change_Information/Change_Information.php" ></a>' .
                "\n\t\t\t\t" . '<a class="deco" href="/deconnection/Deconnection.php" ></a>' .
                "\n\t\t\t" . '</div>';
    } else {
        $contenu .=
                "\n\t\t\t" . '<p>Bonjour invité</p>' .
                "\n\t\t\t" . '<div id="wrapper-compte">' .
                "\n\t\t\t\t" . '<a class="inscription" href="../inscription.php" ></a>' .
                "\n\t\t\t\t" . '<a class="connexion" href="../connection.php" ></a>' .
                "\n\t\t\t" . '</div>';
    }
    $contenu .=
            "\n\t\t" . '</div>' .
            "\n\t" . '</div>';

    return $contenu;
}

function DisplayLeftMenu($lieuconnexion, $repertory) {

    // $lieudeconnexion : "Actualités","Monblog","Mesfavoris"
    // liens à mettre
    // affichage des sources à mettre
    $contenu = '';
    if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {
        $contenu = "\n\t" . '<nav>' .
                "\n\t\t" . '<div id ="espace-haut"></div>' .
                "\n\t\t" . '<ul>' .
                "\n\t\t\t" . '<li class= "boutton-espace"><a class = "menu-boutton';
        if ($lieuconnexion == "Actualités") {
            $contenu .= ' actif';
        }
        $contenu .= '" href="' . $repertory . 'index.php"><p>Actualités</p></a></li>' .
                "\n\t\t\t" . '<li class= "boutton-espace"><a class = "menu-boutton';
        if ($lieuconnexion == "MonBlog") {
            $contenu .= ' actif';
        }
        $contenu .= '" href="' . $repertory . 'blog.php"><p>Mon blog</p></a></li>' .
                "\n\t\t\t" . '<li><a class = "menu-boutton';
        if ($lieuconnexion == "MesFavoris") {
            $contenu .= ' actif';
        }
        $contenu .= '" href="' . $repertory . 'MesFavoris.php"><p>Mes favoris</p></a></li>' .
                "\n\t\t" . '</ul>' .
                "\n\t\t" . '<hr class= "menu-division" >' .
                "\n\t\t" . '<ul>' .
                "\n\t\t\t" . '<li><a class = "menu-boutton" id = "boutton-sources" href="' . $repertory . 'gererMesSources.php"><p>Gérer mes sources</p></a></li>' .
                "\n\t\t" . '</ul>' .
                "\n\t\t" . '<hr class= "menu-division" ><br/>';
        // TODO
        // Condition Si on a des sources
        //
		$contenu .=
                "\n\t\t" . '<div id="wrapper">' .
                "\n\t\t\t" . '<div id="scroller">';

        // Ca c'est la partie statique, il faut changer l'action du form mais ca restera toujours pareil

        $contenu .= "\n\t\t\t" . '<form class="categorie" action="' . $repertory . 'action.php" method="post">';
        $contenu .= "\n\t\t\t\t" . '<input class="categorie" type="button" value="RSS">';
        $contenu .= "\n\t\t\t" . '</form>';
        $contenu .= "\n\t\t\t" . '<form class="categorie" action="' . $repertory . 'mail.php" method="post">';
        $contenu .= "\n\t\t\t\t" . '<input class="categorie" type="submit" value="Emails">';
        $contenu .= "\n\t\t\t" . '</form>';
        $contenu .= "\n\t\t\t" . '<form class="categorie" action="' . $repertory . 'action.php" method="post">';
        $contenu .= "\n\t\t\t\t" . '<input class="categorie" type="button" value="Tweets">';
        $contenu .= "\n\t\t\t" . '</form>';
        $contenu .= "\n\t\t\t" . '<br/><hr class= "menu-division" ><br/>';

        // IL VA FALLOIR CLASSER LES CATEGORIE.
        // Je te donne le code il faut juste les extraires et classer les sources dedans:
        // Pour chaque catégorie
        //      $contenu .= "\n\t\t\t" . '<form class="categorie" action="action.php" method="post">';
        //		$contenu .= "\n\t\t\t\t" . '<input class="categorie" type="button" value="' . $categorie->nodeValue .' :">';
        //		$contenu .= "\n\t\t\t" . '</form>';
        // Ca il faut l'afficher si des sources sont non classées

        include_once $repertory . 'User/GestionSourceUser.php';

        $gestionSourceUser = new GestionSourceUser($_SESSION['pseudo']);
        $allCategoriesWithSource = $gestionSourceUser->getAllSourcesByCategorie();
        $allSourceName = $gestionSourceUser->getAllSourceName();

        

        /*$allSources = new DOMDocument('1.0', 'utf-8');
        $allSources->load(__DIR__ . '/../User/' . $_SESSION['pseudo'] . '/' . $_SESSION['pseudo'] . '_Sources.xml');
        $allSources = $allSources->getElementsByTagName('Source');*/
        foreach ($allCategoriesWithSource as $key => $Categories) {
                 $contenu .= "\n\t\t\t" . '<form class="categorie" action="' . $repertory . 'action.php" method="post">';
                $contenu .= "\n\t\t\t\t" . '<input class="categorie" type="submit" name ="categorie" value="' . $key . '">';
                $contenu .= "\n\t\t\t" . '</form>';
            foreach ($Categories as $categorie) { // En théorie c'est ça
                foreach($categorie as $source)
                //faut que $sources soit classé alphabétique avec les favoris d'abord
                if ($gestionSourceUser->isFavorite($allSourceName[$source])) {
                    $contenu .= "\n\t\t\t" . '<form class="source" action="' . $repertory . 'action.php" method="post">';
                    $contenu .= "\n\t\t\t\t" . '<input class="source" name ="source" type="submit" value=" ♥ ' . $allSourceName[$source] . '">';
                    $contenu .= "\n\t\t\t" . '</form>';
                } else {
                    $contenu .= "\n\t\t\t" . '<form class="source" action="' . $repertory . 'action.php" method="post">';
                    $contenu .= "\n\t\t\t\t" . '<input class="source" type="submit" name ="source" value="' . $allSourceName[$source] . '">';
                    $contenu .= "\n\t\t\t" . '</form>';
                }
            }
        }

        $contenu .=
                "\n\t\t\t" . '</div>' .
                "\n\t\t" . '</div>' .
                "\n\t" . '</nav>';
    }
    return $contenu;
}

?>
