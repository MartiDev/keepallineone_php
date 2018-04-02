<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function askEmail($mail, $mailForRegex) {
    if (!empty($mailForRegex)){
    VerifyInput::IsMailRegex($mailForRegex);
    VerifyInput::DoesMailExist($mail);
    }
    else throw new Exception (' Vous n\'avez pas rentré d\'email. <br /> <a href="../index.php">Index</a> ');
}

function recupPseudo($pseudoForgot) {
    if (!empty($pseudoForgot)) {
        return true;
    }
    return false;
}

function recupPassWord($password) {
    if (!empty($password)) {
        return true;
    }
    return false;
}

function displayInfo ($info){
    return $info;
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}

function sendEmailRecup($mailForRegex, $mail, $pseudoForgot, $password) {
    $destinataire = $mailForRegex;
    $sujet = "Récupération de vos données";
    $entete = "From: inscription@votresite.com";

    $message = 'Bonjour,
        vous avez demandé la récupération de ';
    if (recupPassWord($password)) {
        $newPassword = random_str(14);
        $newHashPassword = password_hash(Securite::inputData($newPassword), PASSWORD_DEFAULT);
        $prepare = SPDO::getInstance()->prepare('UPDATE User SET password = :password WHERE email = :mail');
        $prepare->bindValue(':password', $newHashPassword);
        $prepare->bindValue(':mail', $mail);
        $prepare->execute();
            $message = $message . 'votre nouveau mot de passe :' . $newPassword . '<br />';
    }
    if (recupPseudo($pseudoForgot)) {
        $query = 'SELECT pseudo FROM User  WHERE email ="' . $mail . '"';
        $result = SPDO::getInstance()->query($query);
        foreach ($result as $row){
            $message = $message . 'votre Pseudo :' . $row['pseudo'];
        }
    }

    mail($destinataire, $sujet, $message, $entete);
}