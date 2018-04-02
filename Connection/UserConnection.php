<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../AlwaysNeeded.php';
require_once '../User/User.php';

class UserConnection {
    
    public function __construct($login, $password) {
        $this->validateConnection($login, $password);
        new User();
    }
    
    private function validateConnection($login, $password){
        $connect = $this->queryConnect($login);
        if ($connect->rowCount() != 0) {
            foreach ($connect as $row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['keyConnection'] = md5(microtime() . rand() * $row['ID']);
                    //$this->InsertKeyConnection($_SESSION['keyConnection'], $row['ID']);
                    $_SESSION['ID'] = $row['ID'];
                    $_SESSION['pseudo'] = trim($row['pseudo'], '\'');
                    /* header('Location: index.php'); */
                }else {
                    throw new ConnectionException('Mauvais Identifiant ou mot de passe');
                }
            }
        } else {
            throw new ConnectionException('Mauvais Identifiant ou mot de passe');
        }
    }

    private function queryConnect($login) {
        $QueryConnect = 'SELECT ID, pseudo, password FROM User WHERE pseudo="' . $login . '"';
        return SPDO::getInstance()->query($QueryConnect);
    }
    
    private function InsertKeyConnection($key, $id) {
        $QueryConnect = 'UPDATE User SET KeyConnection = "' . $key . '" WHERE ID = "' . $id . '" ';
        return SPDO::getInstance()->query($QueryConnect);
    }

}