<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'AlwaysNeeded.php';

if (isset($_POST['categorie'])){
    $whattoshow = 'categorie';
    $type = $_POST['categorie'];
} else {
    $whattoshow = 'source';
    $type = preg_replace('/ ♥ /', '', $_POST['source']);
}

echo affichercontenu($type, 0, $whattoshow, '');