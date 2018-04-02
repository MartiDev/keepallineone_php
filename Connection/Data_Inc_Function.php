<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function queryConnect($login) {
    $QueryConnect = 'SELECT ID, pseudo, password FROM User WHERE pseudo="' . $login . '"';
    return SPDO::getInstance()->query($QueryConnect);
}
