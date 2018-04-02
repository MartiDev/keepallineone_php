<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ShowExtractSource {

    private $name = '';
    private $ID = '';
    private $IDUser = '';

    public function __construct($nameUnique) {
        $this->name = $nameUnique;
        //var_dump($this->name);
        $this->IDUser = $this->extractIDuser();
        $this->ID = $this->extractIDSource();

    }

    private function extractIDUser(){
        $query = 'SELECT ID FROM User WHERE pseudo ="\'' . $_SESSION['pseudo'] . '\'"';
        $prepareQuery = SPDO::getInstance()->prepare($query);
        $prepareQuery->execute();
        return $prepareQuery->fetch(PDO::FETCH_ASSOC);
    }
    
    public function extractIDSource() {
        $query = 'SELECT ID FROM Source WHERE nomuniquesource ="' . $this->name . '"';
        $prepare = SPDO::getInstance()->prepare($query);
        $prepare->execute();
        return $prepare->fetch(PDO::FETCH_NUM);
    }
    
    private function extractIDSourceFromCategorie() {
        $query = 'SELECT IDsource FROM userfollowsource WHERE categorie ="' . $this->name . '" AND IDuser ="' . $this->IDUser['ID'] . '"';
        $prepare = SPDO::getInstance()->prepare($query);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_NUM);
    }

    public function extractAllArticlesWithCategories() {
        $result = [];
        foreach ($this->extractIDSourceFromCategorie() as $sources) {
            foreach ($sources as $source) {
                $query = 'SELECT ID FROM Article WHERE IDsource = "' . $source . '"';
                $prepare = SPDO::getInstance()->prepare($query);
                $prepare->execute();
                $result [] = $prepare->fetchAll(PDO::FETCH_NUM);
            }
        }
        return $result;
    }
    
    public function sortAllArticle() {
        $allArticles = $this->extractAllArticlesWithCategories();
        $articles = [];
        foreach ($allArticles as $allarticles) {
                foreach ($allarticles as $article) {
                    if ($article > 0) {
                        $articles[] = $article[0];
                     }
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
    
    public function sortAllArticleWithID() {
        $articlesExtract = $this->extractAllArticlesWithSource();
        //var_dump($articlesExtract);
        $articles = [];
        foreach ($articlesExtract as $article) {
            if ($article > 0) {
                $articles[] .= $article[0];
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

    public function extractAllArticlesWithSource(){
        $query = 'SELECT ID FROM Article WHERE IDsource ="' . $this->ID[0] . '"';
        $prepare = SPDO::getInstance()->prepare($query);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_NUM);
    }

}
