<?php
/**
 * Created by PhpStorm.
 * User: m14020696
 * Date: 25/11/15
 * Time: 15:17
 */
require_once '../AlwaysNeeded.php';
require_once '../affichage/affichercontenu.php';

unset($_SESSION['username']);
unset($_SESSION['ID']);
unset($_SESSION['pseudo']);
echo affichercontenu('Deconnexion', 0, 'Actualites', '', '../');


?>