<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateEmail() {
    $login = $_GET['log'];
    $cle = $_GET['cle'];

    $prepare = SPDO::getInstance()->prepare("SELECT validationKey, activeMail FROM User WHERE pseudo = :login ");
    if ($prepare->execute(array(':login' => $login)) && $row = $prepare->fetch()) {
        $clebdd = $row['validationKey'];
        $actif = $row['activeMail'];
    }

    if ($actif == '1') {
        Display('<div id = "phrase-cont">Votre compte est déjà actif !</div>');
    } else {
        if ($cle == $clebdd) {
            $gestionuser = new GestionUser();
            echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">' . $login . '</div>');
            $gestionuser->addNewUser($login);
            echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">Votre compte a bien été activé !<br /> Redirection en cours ....</div>');
            header('Refresh:2;url=../index.php');
            $prepare = SPDO::getInstance()->prepare("UPDATE User SET activeMail = 1 WHERE pseudo = :login ");
            $prepare->bindParam(':login', $login);
            $prepare->execute();
        } else {
            echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">Erreur ! Votre compte ne peut être activé...</div>');
        }
    }
}
