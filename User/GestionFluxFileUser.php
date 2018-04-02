<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../XML/GestionFluxXML.php';
require_once '../XML/FluxXML.php';
require_once '../../Article.php';

class GestionFluxFileUser {
    private $name;
    private $arrayAdresseFlux = array();
    private $arrayFluxUserAlea = array();
    private $arrayArticleAlea = array();
    private $arrayFluxUserClassify = array();
    
    public function __construct($name, $sourcesUser) {
        $this->name = $name . '_Flux.xml';
        $this->arrayFluxUserAlea = $this->extractUserFlux($sourcesUser);
        $this->arrayFluxUserClassify = $this->sortFluxXMLUser();
        if (!file_exists($this->name)){
            $this->createUserFileFlux($this->arrayFluxUserAlea);
        }
    }
    
    private function extractUserFlux($sourcesUser){ 
        foreach ($sourcesUser as $source) {
            $this->arrayAdresseFlux[] = '../Sources' . $source . '/' . $source . 'xml';
        } 
        $fluxuser = new GestionFluxXML($this->arrayAdresseFlux);
        $fluxuser = $fluxuser->getArrayfluxRSS();
        foreach ($fluxuser as $fluxS){
            foreach ($fluxS as $fluxSource){
                for ($i = 0 ; i  < 8 ; ++$i){
                    $this->arrayArticleAlea[] = new Article(preg_replace('/.php/', '', $fluxSource->getDescription($i)), $fluxSource->getTitre($i), $$fluxSource->getPubDate($i), $fluxSource->getLink($i), $fluxSource->getGuid($i), $fluxSource->getEnclosure($i), $fluxSource->getName());
                }
            }
        }
    }

    private function sortFluxXMLUser() {
        usort($this->arrayArticleAlea, function($a, $b) {
            if ($a->getPubDate() == $b->getPubDate()) {
                echo "a ($a) is same priority as b ($b), keeping the same\n";
                return 0;
            } else if ($a->getPubDate() > $b->getPubDate()) {
                echo "a ($a) is higher priority than b ($b), moving b down array\n";
                return -1;
            } else {
                echo "b ($b) is higher priority than a ($a), moving b up array\n";
                return 1;
            }
        });
    }

    private function createUserFileFlux(){  
        $xml = new DOMDocument('1.0', 'utf-8');
        $articles = $xml->createElement('Articles', '');
        // ICI ON VA GENERER LE DOM Boucle While
        foreach ($this->arrayFluxUserClassify as $article){
            $newArticle = $xml->createElement('Article', '');
            $titre = $xml->createElement('titre', $article->getTitre());
            $newArticle->appendChild($titre);
            $pubDate = $xml->createElement('pubDate', $article->getPubDate());
            $newArticle->appendChild($pubDate);
            $linkArticle = $xml->createElement('link', $article->getLinkArticle());
            $newArticle->appendChild($linkArticle);
            $idArticle = $xml->createElement('idArticle', $article->getIdArticle());
            $newArticle->appendChild($idArticle);
            $guid = $xml->createElement('guid', $article->getGuid());
            $newArticle->appendChild($guid);
            $image = $xml->createElement('image', $article->getImage());
            $newArticle->appendChild($image);
            $sourceName = $xml->createElement('sourceName', $article->getSourceName());
            $newArticle->appendChild($sourceName);
            $articles->appendChild($newArticle);
        }
        $xml->appendChild($articles);
       $xml->save($this->name . '/' . $this->name . ".xml");
    }
}