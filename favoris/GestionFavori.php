<?php
require_once 'Favori.php';
class GestionFavori {

    private $idUser;
    private $allSourceName;

    public function __construct()
    {
        $this->idUser = $this->extractpseudoUser();
    }

    private function extractpseudoUser() {
        $queryIDuser = 'SELECT ID FROM User WHERE pseudo =  "\'' . $_SESSION['pseudo'] . '\'"';
        $prepareIDuser = SPDO::getInstance()->prepare($queryIDuser);
        $prepareIDuser->execute();
        $IDuserResult = $prepareIDuser->fetch(PDO::FETCH_ASSOC);
        return $IDuserResult['ID'];
    }

    public function extractIDsource() {
        $QueryIdSources = 'SELECT IDsource FROM Favori WHERE IDuser = "' . $this->idUser . '"';
        //On execute la commande
        $prepareIdSources = SPDO::getInstance()->prepare($QueryIdSources);
        $prepareIdSources->execute();
        return $prepareIdSources->fetchAll(PDO::FETCH_NUM);
    }

    //Affiche toutes les sources de l'user
    public function showAllSources() {
        $allSources = '';
        //selection de tous les id Sources   des favoris   d'un id User
        $allIdSources = $this->extractIDsource();
        //var_dump($IdSources);
        $allSources .= 'Voici vos sources : <br><br>';

        //Pour chaque ID Source des favoris, on affiche la source.
        foreach ($allIdSources as $idSources) {
            foreach ($idSources as $idSource)
            $FavSource = new Favori($idSource);
            //Affiche une source en particulier
            $actualSource = $FavSource->showSource();
            $this->allSourceName[] = $actualSource;
            $allSources .= $actualSource . '<br/>';
            
        }
        return $allSources;
    }
    
    public function getAllSourceName(){
        return $this->allSourceName;
    }

}
