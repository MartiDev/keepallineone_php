<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../AlwaysNeeded.php';
require_once 'GestionSourceUser.php';
require_once '../Extraction/Sources/GestionSource.php';


try {
    if (!isset($_POST['ChangementCategorie'])) {
        if (strlen($_POST['Categorie']) > 0 && $_POST['OldCategorie'] == 'Nouvelle') {
            $gestionSource = new GestionSourceUser($_SESSION['pseudo'], $_POST['OldCategorie']);
        } elseif ($_POST['OldCategorie'] != 'Nouvelle' && strlen($_POST['Categorie']) == 0) {
            $gestionSource = new GestionSourceUser($_SESSION['pseudo'], $_POST['OldCategorie']);
        } else {
            throw new Exception('Erreure');
        }
        $newSource = new GestionSource($_POST['Source']);
        $gestionSource->abonneUserASource($newSource->getNameSource());
        header('Refresh:2;url=../index.php');
    } else {
        if($_POST['OldCategorie'] == 'Nouvelle' && strlen($_POST['NewCategorie']) > 1){
       
            $gestionSource = new GestionSourceUser($_POST['OldPosition'], $_POST['NewCategorie']);
            $gestionSource->updateSource();
        } elseif ($_POST['OldCategorie'] != 'Nouvelle' && strlen($_POST['NewCategorie']) == 0) {
            $gestionSource = new GestionSourceUser($_POST['OldPosition'], $_POST['OldCategorie']);
            $gestionSource->updateSource();
        } else{
             throw new Exception('Erreure');
        }
        header('Refresh:2;url=../index.php');
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    header('Refresh:2;url=../index.php');
}