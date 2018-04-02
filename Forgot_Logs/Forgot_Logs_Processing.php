<?php
require_once '../AlwaysNeeded.php';
require_once 'Forgot_Logs_Inc_Processing.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

try {
    $mailForRegex = Securite::outputData($_POST['mail']);
    $mail = Securite::inputData($mailForRegex);
    $pseudo = Securite::outputData($_POST['pseudoForgot']);
    $password = Securite::outputData($_POST['passwordForgot']);
    askEmail($mail, $mailForRegex);
    sendEmailRecup($mailForRegex, $mail, $pseudo, $password);
    echo affichercontenu('Connexion', 0,'', '<div id = "phrase-cont">Infos envoyés. <br /> <a href="../index.php">Index</a> </div>', '../'); 
} catch (Exception $e) {
    echo affichercontenu('Connexion', 0,'', $e->getMessage() , '../' );
}
