<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionSourceUser {
    
    private $categorie = '';
    private $nameSourceFile;
    private $nameArticles;
    private $directoryURL; 
    private $fileXMLDirectory;
    private $allIdSources=[];
    private $allArticles = [];
    private $allCategories = [];
    private $allSourceName = [];
    private $AllCategoriesWithSource = [];

    
    public function __construct($name, $categorie='') {
        $this->categorie = $categorie;
        $this->nameSourceFile = $name;
        $this->nameArticles = $name . '_Articles.xml';
        $this->fileXMLDirectory = __DIR__ . '/'. $name .'/' . $this->nameSourceFile;
        $this->ID = $this->extractIDUser();
        $this->allIdSources = $this->extractAllIdSource();
        $this->allCategories = $this->extractAllCategories();
        $this->allSourceName = $this->extractAllSourceName();
        $this->extractAllSourceByCategorie();
        //$this->AllSourceNameWithCategorie = $this->extractAllSourceNameWithCategorie();
        //var_dump($this->AllSourceNameWithCategorie);
        //var_dump($this->AllCategoriesWithSource);
        //var_dump($this->allCategories);
        //var_dump($this->allIdSources);
        //var_dump($this->allSourceName);
        //var_dump($this->allArticles);
        /*if ($this->isDirectory()){
            new GestionFluxFileUser($name, $this->SourcesUser);
        */
        //$this->allIdSources = $this->extractAllIdSource();
    }
    
     public function updateSource(){
         echo '<br/>' . $this->ID['ID'] . '<br/>';
         echo $this->nameSourceFile. '<br/>';
         echo $this->categorie;
            $query ='UPDATE userfollowsource SET Categorie = "' . $this->categorie . '" WHERE IDuser = "' . $this->ID['ID'] . '" AND IDsource="' . $this->extractIDSource()['ID'] .'"';
            $prepare = SPDO::getInstance()->prepare($query);
            $prepare->execute();
            
        }
    
    public function doesUserhaveSource(){
        $query = 'SELECT IDuser FROM userfollowsource WHERE IDuser ="' . $this->ID['ID'] .'"';
        $prepare = SPDO::getInstance()->prepare($query);
        $prepare->execute();
        return $prepare->fetch(PDO::FETCH_ASSOC);
    }
    
    public function extractIDSource(){
        $query = 'SELECT ID FROM Source WHERE nomuniquesource ="' . $this->nameSourceFile .'"';
        $prepareQuery = SPDO::getInstance()->prepare($query);
        $prepareQuery->execute();
        return $prepareQuery->fetch(PDO::FETCH_ASSOC);
    }
    
    public function extractIDUser(){
        $query = 'SELECT ID FROM User WHERE pseudo ="\'' . $_SESSION['pseudo'] . '\'"';
        $prepareQuery = SPDO::getInstance()->prepare($query);
        $prepareQuery->execute();
        return $prepareQuery->fetch(PDO::FETCH_ASSOC);
    }
    
    public function extractAllIdSource(){
        $extractAllSources = 'SELECT IDsource FROM userfollowsource WHERE IDuser ="' . $this->ID['ID'] . '"';
        $prepareExtractAllSource = SPDO::getInstance()->prepare($extractAllSources);
        $prepareExtractAllSource->execute();
        $resultExtractAllSource = $prepareExtractAllSource->fetchAll();
        return $resultExtractAllSource;
    }
    
    public function extractAllCategories(){
        $queryAllCategories = 'SELECT DISTINCT Categorie FROM userfollowsource WHERE IDuser ="' . $this->ID['ID'] . '"';
        $prepareQueryCategories = SPDO::getInstance()->prepare($queryAllCategories);
        $prepareQueryCategories->execute();
        return $prepareQueryCategories->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function extractAllSourceByCategorie(){
        foreach ($this->allCategories as $categorie){
            $queryAllSourceByCategorie = 'SELECT IDsource FROM userfollowsource WHERE Categorie ="' . $categorie['Categorie'] . '" AND IDuser ="' . $this->ID['ID'] .'"';
            $prepareAllSourceByCategorie = SPDO::getInstance()->prepare($queryAllSourceByCategorie);
            $prepareAllSourceByCategorie->execute();
            $this->AllCategoriesWithSource[$categorie['Categorie']] = $prepareAllSourceByCategorie->fetchAll(PDO::FETCH_NUM);
        }
    }
    
    public function extractAllSourceName(){
        $allSourceName =[];
        foreach ($this->allIdSources as $idSource){
        $queryAllSourceName = 'SELECT nomuniquesource FROM Source WHERE ID = "' . $idSource['IDsource'] .'"';
        $prepareAllSourceName = SPDO::getInstance()->prepare($queryAllSourceName);
        $prepareAllSourceName->execute();
        $resultAllSourceName = $prepareAllSourceName->fetch(PDO::FETCH_NUM);
        $allSourceName[$idSource['IDsource']] = $resultAllSourceName[0];
        }
        return $allSourceName;
    }
    
    public function getIDSourceFromNomUniq($sourceName){
         //echo $sourceName ;
        $querySourceID = 'SELECT ID FROM Source WHERE nomuniquesource ="' . $sourceName . '"';
        $prepareQuerySourceID = SPDO::getInstance()->prepare($querySourceID);
        $prepareQuerySourceID->execute();
        $resultSourceID = $prepareQuerySourceID->fetch(PDO::FETCH_ASSOC);
        return $resultSourceID;
    }
    
    public function isFavorite($sourceName){
       
        $ID = $this->getIDSourceFromNomUniq($sourceName)['ID'];
        $query = 'SELECT IDsource FROM Favori WHERE IDsource ="' . $ID .'"';
        $prepareQuery = SPDO::getInstance()->prepare($query);
        $prepareQuery->execute();
        $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
        if(empty($result['IDsource'])){
            return false;
        }
        return true;
    }
    
    public function abonneUserASource($sourceName) {
        $queryUserID = 'SELECT ID FROM User WHERE pseudo = "\'' . $_SESSION['pseudo'] . '\'"';
        $prepareQueryUserID = SPDO::getInstance()->prepare($queryUserID);
        $prepareQueryUserID->execute();
        $resultUserID = $prepareQueryUserID->fetch(PDO::FETCH_ASSOC);
        $resultSourceID = $this->getIDSourceFromNomUniq($sourceName);
        //var_dump($resultSourceID);
        $queryVerif = 'SELECT IDsource, IDuser FROM userfollowsource WHERE IDsource ="' . $resultSourceID['ID'] . '" AND IDuser = "' . $resultUserID['ID'] . '"';
        $prepareQueryVerif = SPDO::getInstance()->prepare($queryVerif);
        $prepareQueryVerif->execute();
        $resultVerif = $prepareQueryVerif->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($resultVerif) > 0) {
            throw new Exception('Vous êtes déjà abonné !');
        } else {
              $Query = 'INSERT INTO userfollowsource (IDsource, IDuser, Categorie) VALUES (:idsource, :iduser, :categorie)';
              $PrepareQuery = SPDO::getInstance()->prepare($Query);
              $PrepareQuery->bindValue(':idsource', $resultSourceID['ID'], PDO::PARAM_INT);
              $PrepareQuery->bindValue(':iduser', $resultUserID['ID'], PDO::PARAM_INT);
              $PrepareQuery->bindValue(':categorie', $this->categorie, PDO::PARAM_STR);
              $PrepareQuery->execute();
        }
    }

    public function extractAllArticles() {
        $allArticles = [];
        foreach ($this->allIdSources as $idSource) {
            $queryGetAllArticles = 'SELECT ID FROM Article WHERE IDsource = "' . $idSource['IDsource'] . '"'; 
            $prepareGetAllArticles = SPDO::getInstance()->prepare($queryGetAllArticles);
            $prepareGetAllArticles->execute();
            $resultGetAllArticle = $prepareGetAllArticles->fetchall();
            $allArticles[] = $resultGetAllArticle;
        }
        $this->allArticles = $allArticles;
    }

    public function addNewSource($nameSource) {
        if (file_exists($this->fileXMLDirectory)) {

            $OrgSourcesUser = new DOMDocument('1.0', 'UTF-8');
            $OrgSourcesUser->load($this->fileXMLDirectory);

            $newdoc = new DOMDocument('1.0', 'utf-8');
            $sources = $newdoc->createElement('Sources', '');
            $infos = $newdoc->createElement('Infos', '');
            $source = $newdoc->createElement('Source', $nameSource);
            $infos->appendChild($source);
            $urlDirectory = $newdoc->createElement('filePath', $this->directoryURL);
            $infos->appendChild($urlDirectory);
            $sources->appendChild($infos);
            $newdoc->appendChild($sources);
            $isAlready = $OrgSourcesUser->getElementsByTagName('Source');
            if ($isAlready->length > 0){
                foreach ($isAlready as $itemOld) {
                    if ($itemOld->nodeValue == $nameSource) {
                        throw new Exception('Tu as déjaaa la souuuurce');
                    }
                }
            }
            $node = $OrgSourcesUser->getElementsByTagName('Infos');
            if ($node->length > 0) {
                foreach ($node as $itemOld) {
                    $node = $newdoc->importNode($itemOld, true);
                    $newdoc->documentElement->appendChild($node);
                }
            }
            $newdoc->save($this->fileXMLDirectory);
        } else {
            $newdoc = new DOMDocument('1.0', 'utf-8');
            $sources = $newdoc->createElement('Sources', '');
            $source = $newdoc->createElement('Source', $nameSource);
            $sources->appendChild($source);
            $newdoc->appendChild($sources);
            $newdoc->save($this->fileXMLDirectory);
        }
    }

    
    public function sortAllArticle() {
        $this->extractAllArticles();
        $articles = [];
        foreach ($this->allArticles as $idArticles) {
            foreach ($idArticles as $idArticle) {
                $articles[] = $idArticle['ID'];
            }
        }
        $easyTableauArticles = [];
        foreach($articles as $article){
            $queryGetPubDate = 'SELECT Date FROM Article WHERE ID ="' . $article .'"';
            $prepareGetPubDate = SPDO::getInstance()->prepare($queryGetPubDate);
            $prepareGetPubDate->execute();
            $result = $prepareGetPubDate->fetch(PDO::FETCH_ASSOC);
            $easyTableauArticles[$article] = (int) $result['Date'];
        }
        arsort($easyTableauArticles);
        return $easyTableauArticles;
    }

    public function getAllIdArticles() {
        return $this->allArticles;
    }

    public function getAllSourceName() {
        return $this->allSourceName;
    }

    public function getAllSourcesByCategorie() {
        return $this->AllCategoriesWithSource;
    }

}
