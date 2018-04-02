<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionUser{
    private $pathname ='';
    
    public function __construct() {
        $this->pathname = 'AllUser.xml';
        if(!file_exists('/home/keepalliin/www/User/' . $this->pathname)){
            $newAllUser = new DOMDocument('1.0', 'utf-8');
            $users = $newAllUser->createElement('Users', '');
            $newAllUser->appendChild($users);
            $newAllUser->save('/home/keepalliin/www/User/' .$this->pathname);
        }
    }
    
    public function addNewUser($pseudo){
        $newUser = new DOMDocument('1.0', 'utf-8');
        $users = $newUser->createElement('Users','');
        $user = $newUser->createElement('User', $pseudo);
        $users->appendChild($user);
        $newUser->appendChild($users);
        $orgDoc = new DOMDocument('1.0', 'utf-8');
        $orgDoc->load('/home/keepalliin/www/User/AllUser.xml'); //CACAAAAAAAAAAA
        $allUser = $orgDoc->getElementsByTagName('User');
        if ($allUser->length > 0){
            $node = $newUser->importNode($allUser, true);
            $newUser->documentElement->appendChild($node);
        } 
        $newUser->save('/home/keepalliin/www/User/AllUser.xml'); //CACAAAAAAAAAAAAA
    }
}

$gestionuser = new GestionUser();
echo __DIR__;
$gestionuser->addNewUser('tatatatatatata');