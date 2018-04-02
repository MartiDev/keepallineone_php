<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User {
    private $keyConnect = '';
    private $pseudo='';
    private $blog=[];
    private $favoris = [];
    private $sources = [];
    
    public function __construct (){
        //$this->keyConnect = $_SESSION['KeyConnection'];
        $this->pseudo = $_SESSION['pseudo'];
        $this->testExistingDirectory();
        //new GestionSourceUser($this->pseudo);
        /*$this->blog = $this->generateBlog();
        $this->favoris = $this->generateFavoris();
        $this->sources = $this->generateSources();*/
    }
    
    private function testExistingDirectory(){
        if(!file_exists(__DIR__. '/' . $this->pseudo)){
            mkdir(__DIR__. '/' . $this->pseudo, 0700, true);
        }
    }

}