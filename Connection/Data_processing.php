<?php

/**
 * Created by PhpStorm.
 * User: m14020696
 * Date: 18/11/15
 * Time: 09:43
 */
require_once '../AlwaysNeeded.php';
require_once 'UserConnection.php';
require_once 'ConnectionException.php';
require_once '../affichage/affichercontenu.php';

try {
    $login = Securite::inputData($_POST['login']);
    $mdp = Securite::inputData($_POST['Password']);
    new UserConnection($login, $mdp);
    header('Refresh:2;url=../index.php');
    echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">Vous êtes bien connecté</div>', '../');
    
   
} catch(ConnectionException $e) {
    header('Refresh:2;url=../index.php');
    echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">' . $e->getMessage() . '</div>', '../');
} catch (PDOException $e) {
    echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">Erreur de communication avec la base de donnée. Veuillez réessayer plus tard</div>');
} catch (Exception $e) {
   echo affichercontenu('Page Principale', 0, 'Actualites', '<div id = "phrase-cont">Erreur inconnue</div>');
}
?>