<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../AlwaysNeeded.php';
include '../User/GestionSourceUser.php';
include 'Favori.php';

$sourcename = '';
foreach($_POST as $key => $value) {
    $sourcename = $key;
    echo $sourcename;
}
$Favori = new Favori($sourcename);
if($_POST[$sourcename] == 'Ajouter Favoris' ){
    $Favori->addSource();
} elseif ($_POST[$sourcename] == 'Supprimer Favoris') {
    $Favori->deleteSource();
} elseif ($_POST[$sourcename] == 'Supprimer Source'){
    $Favori->deletefollowing();
}