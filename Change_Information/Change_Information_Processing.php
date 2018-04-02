<?php

require_once '../AlwaysNeeded.php';
require_once 'Change_Information_Inc_Function.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$nom = Securite::inputData($_POST['changenom']);
$password = Securite::inputData($_POST['changepassword']);
$repassword = Securite::inputData($_POST['changerepassword']);
$lastpassword = Securite::inputData($_POST['lastpassword']);
$prenom = Securite::inputData($_POST['changeprenom']);
$pseudo = Securite::inputData($_POST['changepseudo']);
$mail = Securite::inputData($_POST['changemail']);
$mailForRegex = Securite::outputData($_POST['changemail']);
$remail = Securite::inputData($_POST['changeremail']);
$Hashpassword = password_hash($password, PASSWORD_DEFAULT);

try {
    if (strlen($nom) > 2) {
        VerifyInput::isNameOk($nom);
        updateName ($nom);
    }
    if (strlen($prenom) > 2) {
        VerifyInput::isNameOk($prenom);
        updatePrenom ($prenom);
    }
    if (strlen($pseudo) > 2) {
        VerifyInput::isNameOk($pseudo);
        VerifyInput::isAlreadyPseudo($pseudo);
        updatePseudo ($pseudo);
    }
    if (strlen($mail) > 2) {
        VerifyInput::IsMailRegex($mailForRegex);
        VerifyInput::isAlreadyMail($mail);
        VerifyInput::AreMailBothSame($mail, $remail);
        updateMail ($mail);
    }
    if (strlen($lastpassword)>2 && strlen($password)>2 && strlen($repassword) > 2){
        VerifyInput::isAlreadyThisPassword($lastpassword);
        VerifyInput::IsPassWordRegex($password);
        VerifyInput::ArePassWordBothSame($password, $repassword);
        updatePassWord ($Hashpassword);
    }
    echo affichercontenu('Deconnexion', 0, '', 'Vos informations ont bien été modifié. <br /> <a href="../index.php">Index</a></div> ', '../');
} catch (Exception $e) {
    Display ('<div id = "phrase-cont">Erreur : ' . $e->getMessage() . '</div>', '../');
}