<?php

require_once '../AlwaysNeeded.php';
require_once 'Register_Inc_Function.php';


try {
    $nom = Securite::inputData($_POST['nom']);
    $password = Securite::inputData($_POST['password']);
    $repassword = Securite::inputData($_POST['repassword']);
    $prenom = Securite::inputData($_POST['prenom']);
    $pseudo = Securite::inputData($_POST['pseudo']);
    $mail = Securite::inputData($_POST['mail']);
    $mailForRegex = Securite::outputData($_POST['mail']);
    $remail = Securite::inputData($_POST['re-mail']);
    $Hashpassword = password_hash($password, PASSWORD_DEFAULT);
    
    VerifyInput::isNameOk($nom);
    VerifyInput::isNameOk($prenom);
    VerifyInput::isNameOk($pseudo);
    VerifyInput::isAlreadyPseudo($pseudo);
    VerifyInput::IsMailRegex($mailForRegex);
    VerifyInput::AreMailBothSame($mail, $remail);
    VerifyInput::isAlreadyMail($mail);
    VerifyInput::IsPassWordRegex($password);
    VerifyInput::ArePassWordBothSame($password, $repassword);
    sendSQLPrepare($nom, $Hashpassword, $prenom, $pseudo, $mail);
    echo affichercontenu('Deconnexion', 0, '', '<div id = "phrase-cont">Vous êtes bien enresgistré. Veuillez activer votre compte en vous rendant sur votre adresse email.</div>', '../');
    sendEmailVerification($mailForRegex, $pseudo);
} catch (PDOException $e) {
     echo affichercontenu('Deconnexion', 0, '', '<div id = "phrase-cont">Erreur lors de la connection au server. Veuillez recommencer plus tard</div>', '../');
} catch (Exception $e) {
     echo affichercontenu('Deconnexion', 0, '', '<div id = "phrase-cont">erreur : ' . $e->getMessage() . '<br /> Redirection vers formulaire ...</div>', '../');
} finally {
    header('Refresh:2;url=../inscription.php');
}
?>