<?php

class Favori {

    private $idUser;
    private $idSource;

    public function __construct($idS){
        $this->idUser   = $this->extractpseudoUser();
        $this->idSource = $idS;

    }
    
    private function extractpseudoUser(){
            $queryIDuser = 'SELECT ID FROM User WHERE pseudo =  "\'' . $_SESSION['pseudo'] . '\'"';
            $prepareIDuser = SPDO::getInstance()->prepare($queryIDuser);
            $prepareIDuser->execute();
            $IDuserResult = $prepareIDuser->fetch(PDO::FETCH_ASSOC);
            return $IDuserResult['ID'];
        }

        public function deletefollowing(){
             $querySupprimerSource = 'DELETE FROM userfollowsource WHERE IDuser =\''. $this->idUser .
            '\' AND idSource =\'' . $this->idSource . '\'';

        $prepareSupprimerSource = SPDO::getInstance()->prepare($querySupprimerSource);
        $prepareSupprimerSource->execute();
        }
        
       
        
    public function deleteSource(){
        $querySupprimerSource = 'DELETE FROM Favori WHERE IDuser =\''. $this->idUser .
            '\' AND idSource =\'' . $this->idSource . '\'';

        $prepareSupprimerSource = SPDO::getInstance()->prepare($querySupprimerSource);
        $prepareSupprimerSource->execute();
    }

    public function addSource(){
        $queryAjouterSource = 'INSERT INTO Favori (IDuser, IDsource)  VALUES (\'' . $this->idUser .
            '\', \''. $this->idSource . '\') ';

        if(!($prepareAjouterSource = SPDO::getInstance()->prepare($queryAjouterSource))) return;
        $prepareAjouterSource->execute();
    }

    public function showSource(){
        $infosSource = '';
        //Selection d'un seul Article en particulier qui correspond au blog de l'user
        $QuerySource = 'SELECT * FROM Source WHERE ID ="' . $this->idSource .'"';

        //On execute la commande
        $prepareSource = SPDO::getInstance()->prepare($QuerySource);
        $prepareSource->execute();
        $Source = $prepareSource->fetch(PDO::FETCH_ASSOC);

        //Affichage de la source
        $infosSource .= $Source['nomuniquesource'];
        return $infosSource;
    }
    

}