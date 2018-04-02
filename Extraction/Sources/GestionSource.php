<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'SourceFacebook.php';
require 'SourceHtml.php';
require 'SourceMail.php';
require 'SourceTwitter.php';
require 'SourceXML.php';

class GestionSource {

    private $source;
    private $nameSource = '';
    private $sourceflux = '';
    private $filePath;

    public function __construct($qualificatif) { //On test ce que c'est et on appel le bon constructeur
        $this->findTheSource($qualificatif);
    }

    private function findTheSource($qualificatif) {
        if (!file_exists('/home/keepalliin/www/Extraction/Sources/AllSources.xml')) {
            //echo 'fichier créer <br/>';
            $newdoc = new DOMDocument('1.0', 'utf-8');
            $sources = $newdoc->createElement('Sources', '');
            $newdoc->appendChild($sources);
            $newdoc->save('/home/keepalliin/www/Extraction/Sources/AllSources.xml');
        }
        if (!filter_var($qualificatif, FILTER_VALIDATE_URL) === false) {
            // C'est soit un flux XML soit un flux HTML
            if ($this->isXML($qualificatif) >= 1) {
                // C'est un flux XML, on va donc appeller le construction XML
                echo 'puet<br/>';
                $this->source = new SourceXML($qualificatif);
                $this->nameSource = $this->source->getUniqNameForFlux();
                $this->filePath = $this->source->getfilePath();
                $this->sourceflux = $this->source->getFluxRSS();
            } else {
                // C'est un flux HTML, on va donc appeller le constructeur HTML
                throw new Exception ('entrée invalide');
                new SourceHTML($qualificatif);
            }
        }
        else if (substr($qualificatif, 0, 1) == "#" || substr($qualificatif, 0, 1) == "@") {  
            echo $qualificatif;
            $this->source = new SourceTwitter($qualificatif);
            $this->nameSource = $this->source->getName();
        } else if (!filter_var($qualificatif, FILTER_VALIDATE_EMAIL) === false) {
            // C'est un flux mail
            //echo 'C\'est mail <br/>';
            throw new Exception ('entrée invalide'); 
            new SourceMail($qualificatif);
        } else {
            //On regarde dans notre base de donnée (preg_match ou autre)
            throw new Exception('Erreure, entrée inconnue');
        }
        
    }

    private function isXML($url) {
        /* libxml_use_internal_errors(true);
          $doc = new DOMDocument('1.0', 'utf-8');
          $doc->loadXML(file_get_contents($url));
          $errors = libxml_get_errors();
          return empty($errors); */
        $xml = new DOMDocument();
        $xml->load($url);
        return ($xml->getElementsByTagName('rss')->length || $xml->getElementsByTagName('channel')->length);
    }

    public function getNameSource() {
        return $this->nameSource;
    }

    public function getfilePath() {
        return $this->filePath;
    }

}

