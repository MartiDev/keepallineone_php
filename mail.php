<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'AlwaysNeeded.php';
require_once 'Mail/GestionMail.php';

if (isset($_SESSION['pseudo']) && isset($_SESSION['ID'])) {

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

$mail = '
    <div style="display: block;margin: auto;width: 500px;text-align: center;border: solid 1px black;">
        <form action="mail.php" method="post">

            <p>Type e-mail :</p>
            <select name="typemail">
                <option value="Gmail" selected>Gmail</option>
                <option value="Outlook" selected>Outlook</option>
                <option value="Yahoo" selected>Yahoo</option>
            </select>
            <p>E-mail : </p><input type="text" name="email"/><br>
            <p>Mot de passe : </p><input type="password" name="password"/><br><br>
            <p><input type="submit" name="action" value="Ajouter e-mail"/></p>

        </form>
    </div>';


  
$mails = new GestionMail($_SESSION['ID']);
$mail .= $mails->showAllMails(); 

echo affichercontenu('Mes mails', 0, 'MaMessagerie', $mail); 


}

?>