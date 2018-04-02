<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Article {

    private $idArticle = null;
    private $titre = null;
    private $pubDate = '';
    private $partage = false;
    //private $linkArticle = null;
    private $lien = 'WWW.SAMARCHEPAS.COM';
    //private $guid = null;
    private $image = null;
    private $sourceName = '';
    private $nbPartage = null;
    private $contenu = null;
    private $isFavorite = false;

    public function __construct($idArticle, $contenu) {
        /* $this->idArticle = $idArticle;
          $this->titre = $titre;
          $this->pubDate = $pubDate;
          $this->linkArticle = $linkArticle;
          //$this->guid = $guid;
          $this->image = $image;
          $this->sourceName = $sourceName; */
        //$this->isFavorite = $isfavorite;
        $this->idArticle = $idArticle;
        $this->lien = 'http://www.keepallinone.com/Extraction/Sources/Articles/' . $this->idArticle . '.html';

        $this->contenu = $contenu;
        $this->sourceName = $this->gextractNameSource();
        $this->isFavorite = $this->isFavorite();
        $this->extractImageAndTitleFromBDD();
        $this->partage = $this->isPartage();
    }
    
    

    private function isPartage() {
        $queryIDuser = 'SELECT ID FROM User WHERE pseudo =  "\'' . $_SESSION['pseudo'] . '\'"';
        $prepareIDuser = SPDO::getInstance()->prepare($queryIDuser);
        $prepareIDuser->execute();
        $IDuserResult = $prepareIDuser->fetch(PDO::FETCH_ASSOC);
        $queryIsPartage = 'SELECT ID FROM Blog WHERE IDarticle = "' . $this->idArticle . '" AND IDuser = "' . $IDuserResult['ID'] . '"';
        $prepareIsPartage = SPDO::getInstance()->prepare($queryIsPartage);
        $prepareIsPartage->execute();
        $resultIsPartage = $prepareIsPartage->fetchAll();
        //var_dump($resultIsPartage);
        if (count($resultIsPartage) > 0) {
            return true;
        } else {
            return false;
        }
    }
   
    
    private function extractIDSource(){
        $queryIDSource = 'SELECT IDsource FROM Article WHERE ID ="' . $this->idArticle . '"'; 
        $prepareIDSource = SPDO::getInstance()->prepare($queryIDSource);
        $prepareIDSource->execute();
        $resultIDSource = $prepareIDSource->fetch(PDO::FETCH_ASSOC);
        return $resultIDSource;
    }
    
    private function isFavorite(){
        $IDsource = $this->extractIDSource();
        $query = 'SELECT IDsource FROM Favori WHERE IDsource ="' . $IDsource['IDsource'] .'"';
        $prepare = SPDO::getInstance()->prepare($query);
        $prepare->execute();
        return (!empty($prepare->fetch(PDO::FETCH_ASSOC)));
    }
    
    public function gextractNameSource(){
        $queryNameSource = 'SELECT nomuniquesource FROM Source WHERE ID ="' . $this->extractIDSource()['IDsource'] . '"'; 
        $prepareNameSource = SPDO::getInstance()->prepare($queryNameSource);
        $prepareNameSource->execute();
        return $prepareNameSource->fetch(PDO::FETCH_ASSOC);
    }
    
    public function extractImageAndTitleFromBDD(){
        $queryImageAndArticle = 'SELECT Date, image, titre, NbPartage FROM Article WHERE ID="' . $this->idArticle .'"';
        $prepareImageAndArticle = SPDO::getInstance()->prepare($queryImageAndArticle);
        $prepareImageAndArticle->execute();
        $resultImageAndArticle = $prepareImageAndArticle->fetch(PDO::FETCH_ASSOC);
        $this->pubDate = $resultImageAndArticle['Date'];
        $this->image = $resultImageAndArticle['image'];
        $this->titre = $resultImageAndArticle['titre'];
        $this->nbPartage = $resultImageAndArticle['NbPartage'];
    }
    
    public function afficherTemps() {
        $heureTweet = time() - $this->pubDate; //le nombre de secondes depuis le 1er Janvier 1970 à 00:00:00 du temps actuel - la publication du tweet
        $publishDate = 'just now';
        $secondesArray = array('ans' => 31556926, 'moi' => 2629744, 'semaine' => 604800, 'jour' => 86400, 'heure' => 3600, 'minute' => 60, 'seconde' => 1);
        foreach ($secondesArray as $unite => $secondes) {
            if ($secondes <= $heureTweet) { //On cherche si on a affaire à une année, un moins, une semaine, un jour ou une minute
                $valeurDeLunite = floor($heureTweet / $secondes); // floor arrondi à l'entier inférieur, on s'arrête pour avoir l'unité et v vaut le nombre d'unité
                $publishDate = 'il y a ' . $valeurDeLunite . ' ' . $unite . ($valeurDeLunite == 1 ? '' : 's'); //On affiche le temps
                return $publishDate;
            }
        }
    }

    public function afficher_Article() {
        $affichage = '<div class = "articles"  onClick="afficher_cacher(\'' . $this->idArticle . '\')">' . "\n" ;
        if ($this->isFavorite == true) {
            $affichage .= '    <h2 class="fav">  ♥ ' . $this->sourceName['nomuniquesource'] . ', ' . $this->afficherTemps() . '</h2>' . "\n";
        } else {
            $affichage .= '    <h2>' . $this->sourceName['nomuniquesource'] . ', ' . $this->afficherTemps() . '</h2>' . "\n";
        }
        $affichage .= '        <img class= "image-article" src="' . $this->image . '" alt="article" title="Image article">' . "\n";
        $affichage .= '			<div class = "article" ' . 'id=a'. $this->idArticle. '>' . "\n";
        if ($this->partage === true) {
            $affichage .= '				<h4 class = "like" >' . $this->titre . '</h4>' . "\n";
        } else {
            $affichage .= '				<h4>' . $this->titre . '</h4>' . "\n";
        }
        $affichage .= '            <p class = "texte">' . substr(strip_tags(preg_replace('#<h[1-6]?[^>]*?>.+?</h[1-6]>#', '', $this->contenu)), 0, 280) . '... <br/>(Cliquez pour lire plus) </p>' . "\n";
        if ($this->partage === true) {
            $affichage .= '            <p class="like"><i><span class="id' . $this->idArticle . '"> ' . $this->nbPartage . '</span> ont partagé </i></p>' . "\n"; // Faut trouver x
        } else {
            $affichage .= '            <p><i><span class="id' . $this->idArticle . '"> ' . $this->nbPartage . '</span> ont partagé </i></p>' . "\n"; // Faut trouver x
        }
        $affichage .= '            </div>' . "\n";
        $affichage .= '        </div>' . "\n";
        $affichage .= '    <div class="article-complet" id="' . $this->idArticle . '">' . "\n";
        $affichage .= $this->contenu;
        $affichage .= '        <div class="footer-article-wrapper">' . "\n";
        $affichage .= '        <div class="permalien" >' . "\n";
        $affichage .= '            <a href="' . $this->lien . '">Lien permanent </a>';
        $affichage .= '        </div>' . "\n";
        $affichage .= '        <div class="wrapper-jaime';
        if ($this->partage === true){
            $affichage .=' wrapper-jaime-partage';
        }
        $affichage .= '">' . "\n";
        $affichage .= '             <div class="' . $this->idArticle . '">Partager</div> <span class="id' . $this->idArticle . '">' . $this->nbPartage. ' </span><p> ont partagé</p>' . "\n";
        $affichage .= '        </div>' . "\n";
        $affichage .= '    </div>' . "\n";
        $affichage .= '</div>' . "\n";

        return $affichage;
    }
    
    function getIdArticle() {
        return $this->idArticle;
    }

    function getTitre() {
        return $this->titre;
    }

    function getPubDate() {
        return $this->pubDate;
    }

    function getLinkArticle() {
        return $this->linkArticle;
    }

    function getLien() {
        return $this->lien;
    }

    function getGuid() {
        return $this->guid;
    }

    function getImage() {
        return $this->image;
    }

    function getSourceName() {
        return $this->sourceName;
    }

    function getNbPartage() {
        return $this->nbPartage;
    }

    function getContenu() {
        return $this->contenu;
    }

}
