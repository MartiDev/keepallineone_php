<?php

/**
 * Created by PhpStorm.
 * User: m14020696
 * Date: 18/11/15
 * Time: 10:51
 */
// en-tête HTML
try {
    if (!session_start()) {
        throw new Exception('Impossible de démarrer la session');
    }
} catch (Exception $e) {
    Display ('erreur : ' . $e->getMessage());
}
require_once 'Display.php';
require_once 'Connection_PDO/Connection.php';
require_once 'Securite/Securite.php';
require_once 'Verify/VerifyInput.php';
require_once 'affichage/affichercontenu.php';


?>