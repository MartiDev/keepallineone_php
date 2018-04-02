<?php

function sendSQLPrepare($nom, $Hashpassword, $prenom, $pseudo, $mail) {
    $Query = 'INSERT INTO User (email, name, firstName, password, pseudo) VALUES (:mail, :nom, :prenom, :password, :pseudo)';
    $PrepareQuery = SPDO::getInstance()->prepare($Query);
    $PrepareQuery->bindValue(':mail', $mail, PDO::PARAM_STR);
    $PrepareQuery->bindValue(':nom', $nom, PDO::PARAM_STR);
    $PrepareQuery->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $PrepareQuery->bindValue(':password', $Hashpassword, PDO::PARAM_STR);
    $PrepareQuery->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $PrepareQuery->execute();
}

function sendEmailVerification($mail, $pseudo) {

    $cle = md5(microtime(TRUE) * 100000);
    $prepare = SPDO::getInstance()->prepare('UPDATE User SET validationKey=:cle  WHERE pseudo = :login ');
    $prepare->bindValue(':cle', $cle);
    $prepare->bindValue(':login', $pseudo);
    $prepare->execute();

    $headers ='From: postmaster@keepallinone.com'."\n";
    $headers .='Reply-To: postmaster@keepallinone.com'."\n";
    $headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
    $headers .='Content-Transfer-Encoding: 8bit';
    
    $destinataire = $mail;
    $sujet = "Activer votre compte";
    

    $message = 'Bienvenue sur VotreSite,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://lmcreation.alwaysdata.net/Validation/validation.php?log=' . urlencode($pseudo) . '&cle=' . urlencode($cle) . '
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';


    mail($destinataire, $sujet, $message, $headers);
}
?>