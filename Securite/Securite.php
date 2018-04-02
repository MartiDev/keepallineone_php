<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Securite {

    public static function inputData($string) {
        if (ctype_digit($string)) {
            $string = intval($string);
        } else {
            $string = SPDO::getInstance()->quote($string);
            $string = addcslashes($string, '%_');
        }
        return $string;
    }

    public static function outputData($string) {
        return htmlentities($string);
    }

}
