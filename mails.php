<?php

require_once 'Mail/GestionMail.php';
require_once 'AlwaysNeeded.php';

/*
 * Gere les erreurs de mails.
 */
libxml_use_internal_errors(true);


    $action     = $_POST['action'];
    $typemail   = $_POST['typemail'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    if($action == 'Ajouter e-mail'){
        $mail = new Mails($_SESSION['ID'],$email, $password, $typemail);
        $mail->addEMail();
    }
    elseif($action == 'Supprimer'){
        $mail = new Mails($_SESSION['ID'],$email, $password, $typemail);
        $mail->deleteEMail();
    }

    /*
     * DIV qui ajoute un mail
     */

    /*
     * TESTER AVEC MES COMPTES :
     *
     * Gmail :
     *      mail : raphtestostrov@gmail.com
     *      mdp : coucoutest
     *
     * Yahoo :
     *      mail : raphtest@yahoo.com
     *      mdp : coucoutest
     *
     * Outlook :
     *      mail : raphtest@outlook.com
     *      mdp : coucouTEST123
     */

    $mails = new GestionMail($_SESSION['ID']);

    $mails->showAllMails();
	
    /*
    $mail = new Mails('{imap.gmail.com:993/imap/ssl}INBOX','raphtestostrov@gmail.com','coucoutest');
    $mail->connection();
    $mail->showMails();
    $mail->deconnection();*/
?>

