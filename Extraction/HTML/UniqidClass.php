<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UniqidClass {
    private $uniqid = '';
    
    public function __construct() {
        $this->uniqid = uniqid();
    }
    
    public function getUniqId(){
        return $this->uniqid;
    }
}