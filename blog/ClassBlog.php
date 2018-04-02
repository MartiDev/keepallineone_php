<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Blog {

        private $idUser;
        private $partage;

        public function __construct($partage=false)
        {
            $this->idUser = $this->extractpseudoUser();
            $this->partage = $partage;//Faut get partage du xml
        }
        
        private function extractpseudoUser(){
            $queryIDuser = 'SELECT ID FROM User WHERE pseudo =  "\'' . $_SESSION['pseudo'] . '\'"';
            $prepareIDuser = SPDO::getInstance()->prepare($queryIDuser);
            $prepareIDuser->execute();
            $IDuserResult = $prepareIDuser->fetch(PDO::FETCH_ASSOC);
            return $IDuserResult['ID'];
        }

        public function deleteArticle($idA){
            $querySupprimeArticleBlog = 'DELETE FROM Blog WHERE IDUser ="'. $this->idUser .'" AND IDArticle ="' . $idA .'"';
            $prepareSupprimeArticleBlog = SPDO::getInstance()->prepare($querySupprimeArticleBlog);
            $prepareSupprimeArticleBlog->execute();
            
            $queryDecremente =  'UPDATE Article SET NbPartage=NbPartage - 1 WHERE ID ="' . $idA . '"';
            $prepareDecremente = SPDO::getInstance()->prepare($queryDecremente);
            $prepareDecremente->execute();
            
            echo"remove";

        }

        public function addArticle($idA){
            $queryAjouterArticleDansBlog ='INSERT INTO Blog (IDuser, IDarticle, Date) VALUES (:iduser, :idarticle, :date)';
            $prepareAjouterArticleDansBlog = SPDO::getInstance()->prepare($queryAjouterArticleDansBlog);
            $prepareAjouterArticleDansBlog->bindValue(':iduser', $this->idUser, PDO::PARAM_INT);
            $prepareAjouterArticleDansBlog->bindValue(':idarticle', $idA, PDO::PARAM_STR);
            $prepareAjouterArticleDansBlog->bindValue(':date', time(), PDO::PARAM_INT);
            $prepareAjouterArticleDansBlog->execute();
            
            $queryIncremente =  'UPDATE Article SET NbPartage=NbPartage + 1 WHERE ID ="' .$idA .'"';
            $prepareIncremente = SPDO::getInstance()->prepare($queryIncremente);
            $prepareIncremente->execute();
            
            echo "add";
        }

        public function getPartage($idA)
        {
            $querygetNbPartage =  'SELECT NbPartage FROM Article WHERE ID="' . $idA . '"';
            $preparegetNbPartage = SPDO::getInstance()->prepare($querygetNbPartage);
            $preparegetNbPartage->execute();
            $nbPartage=$preparegetNbPartage->fetchAll(PDO::FETCH_COLUMN, 0);
            
            if (count($nbPartage) > 0){
                return $nbPartage[0];
            }
            else {
                return 0;
            }
        }

        public function getIdU()
        {
            return $this->idUser;
        }

        public function getIdArticles(){

            //selection de tous les id Articles    d'un blog    d'un id User
            $QueryIdArticle = 'SELECT IDarticle FROM Blog WHERE IDuser ="' . $this->idUser .'"';

            //On execute la commande
            $prepareIdArticle = SPDO::getInstance()->prepare($QueryIdArticle);
            $prepareIdArticle->execute();

           $IdArticles = $prepareIdArticle->fetchAll();
           return $IdArticles;
        }
    }