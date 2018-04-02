<?php
require_once '../AlwaysNeeded.php';
require_once '../affichage/affichercontenu.php';
require_once 'Change_Information_Inc_Function.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$query = 'SELECT pseudo, firstName, name, email FROM User WHERE ID ="' . $_SESSION['ID'] . '"';
$prepare = SPDO::getInstance()->prepare($query);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_FUNC, "displayWithChamp");
foreach ($result as $contenu){
    //echo $contenu;
    echo affichercontenu('Changez vos informations', 0, '', $contenu, '../');
}
