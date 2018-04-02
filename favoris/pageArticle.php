<?php
require_once 'AlwaysNeeded.php';
require_once 'Favori.php';
require_once 'Blog.php';


//On test si l'user est connecté ou non
if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {

    //On recupere le type d'action, ID article et ID Source par la méthode POST
    $action = $_POST['Action'];
    $IDArticle = $_POST['IDArticle'];
    $IDSource = $_POST['idSource'];

    //AJOUT ARTICLE
    if($action == 'Ajouter Article') {

        //ATTENTION on ne peux insérer un couple (USER, ARTICLE) qui existe déjà !!
        //AJOUT ARTICLE
        $blog = new Blog($_SESSION['pseudo']);
        $blog->addArticle($IDArticle);
    }
    //SUPPRIMER ARTICLE
    elseif($action == 'Supprimer Article') {
        $blog = new Blog($_SESSION['ID']);
        $blog->deleteArticle($IDArticle);
    }
    //ATTENTION on ne peut insérer un couple(USER,SOURCE) qui existe déjà !!
    //AJOUT SOURCE
    elseif($action == 'Ajouter Source') {

        $Fav = new Favori($IDSource);
        $Fav->addSource();

    }
    //SUPPRIMER SOURCE
    elseif($action == 'Supprimer Source') {

        $Fav = new Favori($IDSource);
        $Fav->deleteSource();
    }


//--------------------------------------------------------------------------------------------------------------------------------
    //_____
    //requete qui prend SEULEMENT les articles présent dans le Blog de l'user
    //_____

    $queryBlog = 'SELECT idArticle FROM Blog WHERE idUser =\'' . $_SESSION['ID'] .'\'';

    $prepareBlog = SPDO::getInstance()->prepare($queryBlog);
    $prepareBlog->execute();

    $idBlog = $prepareBlog->fetchall(PDO::FETCH_ASSOC);


    //_____
    //requete qui prend SEULEMENT les sources présentent dans les Favoris de l'user
    //_____
    $queryFav = 'Select idSource FROM Favori WHERE idUser =\'' . $_SESSION['ID'] .'\'';

    $prepareFav = SPDO::getInstance()->prepare($queryFav);
    $prepareFav->execute();

    $idFav = $prepareFav->fetchall(PDO::FETCH_ASSOC);


    //_____
    //Requete qui affiche TOUS les articles existant
    //_____
    $queryArticle = 'SELECT *  FROM Article ';

    $prepare = SPDO::getInstance()->prepare($queryArticle);
    $prepare->execute();


    //_____
    //Affichage des resultats de la requete dans une boucle
    //_____
    while ($Article = $prepare->fetch(PDO::FETCH_OBJ)) {
        $ArticleInBlog = false;
        $SourceInFavori = false;

        echo '<form action="pageArticle.php" method="post">';

        echo    '<input type="hidden" name="IDArticle" value ="'. $Article->idArticle . '"> '; // INPUT Cacher pour recuper l'ID de l'article courant pour la methode POST !!!
        echo    '<input type="hidden" name="idSource" value ="'. $Article->idSource . '"> '; // INPUT Cacher pour recuper le nom de la source

        echo    'ID de l\'article : '. $Article->idArticle . '</p> .
                Contenu de l\'article : ' . $Article->Content . ' Source : '. $Article->Source . '<br> ';

        //_____
        //On parcours tous les ARTICLES du BLOG de l'USER
        //_____
        foreach($idBlog as $idb => $link) {
            if ($link['idArticle'] == $Article->idArticle) {// SI un article est déjà présent dans le BLOG
                $ArticleInBlog = true;
            }

        }

        //_____
        //On parcours toutes les SOURCES des FAVORIS de l'USER
        //_____
        foreach($idFav as $idf => $link) {
            if ($link['idSource'] == $Article->idSource) // SI une source d'un article est deja present dans les FAVORIS
                $SourceInFavori = true;

        }

        //_____
        //On affiche le bouton SUPPRIMER ou AJOUTER
        //_____

        //BLOG ARTICLE

        if ($ArticleInBlog)
            echo '<input type="submit" name="Action" value="Supprimer Article">';
        else
            echo '<input type="submit" name="Action" value="Ajouter Article">';

        //FAVORI SOURCE

        if ($SourceInFavori)
            echo '<input type="submit" name="Action" value="Supprimer Source">';
        else
            echo '<input type="submit" name="Action" value="Ajouter Source">';

        echo '</form>';
    }
}
else {
    echo 'Connectez-vous !';
}

?>