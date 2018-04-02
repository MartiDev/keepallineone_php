<?php
require_once 'AlwaysNeeded.php';
require_once 'GestionFavori.php';

//On test si l'user est connecté ou non
if (isset($_SESSION['username']) && isset($_SESSION['ID'])) {

    $action = $_POST['Action'];
    $IDSource = $_POST['IDSource'];

    if($action == 'Supprimer') {

        $Fav = new Favori($_SESSION['ID'],$IDSource);
        $Fav->deleteSource();
    }

    $Favoris = new GestionFavori($_SESSION['ID']);
    $Favoris->showAllSources(); //Affiche toutes les sources de l'user

}
else {
    echo 'Connectez-vous !';
}
?>