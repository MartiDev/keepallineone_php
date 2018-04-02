<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class AbstractSource {
    private $qualificatif;
    
    public function __construct($qualificatif) {
        $this->qualificatif = $qualificatif;
        new GestionSourceUser($this->qualificatif);
    }
}