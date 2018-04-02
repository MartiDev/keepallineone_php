<?php
require_once '../AlwaysNeeded.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo affichercontenu('Logs oubliés', 0, '', '<form action="Forgot_Logs_Processing.php" method="post">
        <fieldset>
        <INPUT type="checkbox" name="pseudoForgot" value="pseudoForgot"> Pseudo oublié.<br>
        <INPUT type="checkbox" name="passwordForgot" value="passwordForgot"> Mot de passe oublié.<br>
        <label>Votre adresse email:
        </label>
        <input type="text" name="mail" onblur="verifMail(this)"/><br>
        <input type="submit" value="Envoye"/>
        </fieldset>' , '../');