<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../Extraction/Sources/GestionSource.php';
require __DIR__ . '/../AlwaysNeeded.php';

$newArticlesFromSources = new DOMDocument('1.0', 'utf-8');
$newArticles = $newArticlesFromSources->createElement('Articles', '');
$newArticlesFromSources->appendChild($newArticles);
$newArticlesFromSources->save(__DIR__ . '/../Extraction/Sources/NewArticles.xml');

$majAllSources = new DOMDocument('1.0', 'utf-8');
$majAllSources->load(__DIR__ . '/../Extraction/Sources/AllSources.xml');
$allSource = $majAllSources->getElementsByTagName('Source');
foreach($allSource as $source){
    new GestionSource($source->nodeValue);
}

/*
 * 
 * $allUser = scandir(__ROOT__ . 'User');
 * 
 * 
 * 
 * 
 */

//unlink(__DIR__ . '/../Extraction/Sources/NewArticles.xml');
