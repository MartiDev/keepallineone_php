<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Flux {
    
    private function parsage($fluxRSSAddress, $elementName) { // On va parser le document
        $document_xml = new DomDocument('1.0', 'utf-8'); // On crée le DOMDocument qui va contenir le contenu RSS du site
        $document_xml->load($fluxRSSAddress); //On le charge
        $elements = $document_xml->getElementsByTagName($elementName); //Maintenant, on récupére tous les élements de balise <rss>, un suel normalement
        $arbre = $elements->item(0); //On mets le curseur de l'arbre sur le premier élément
        foreach ($elements as $arbre){
        $this->parsageenfant($arbre); // On commence le parsage
        }
    }

    private function parsageenfant($noeud) {// Fonction de parsage d'enfants
        $enfantsniv1 = $noeud->childNodes;
        foreach ($enfantsniv1 as $enfant) {
            if ($enfant->hasChildNodes() == true) {
                $this->parsageenfant($enfant); // Dans ce cas, on revient sur parsage_enfant
            } else {
                $this->parsage_normal($enfant); // On parse comme un nœud normal
            }
        }
        return $this->parsage_normal($noeud);
    }
    
}