<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../TXT/FileTXT.php';

class ExtractDebugArticle {

    private $htmlDebugFile = '';
    private $sourceFile ='';

    public function __construct($fluxHTMLAdresse) {
        $this->htmlDebugFile = $this->parsage($fluxHTMLAdresse); // On commence le parsage
        $this->sourceFile = new FileTXT('/home/lmcreation/www/Mon_Site_Vente/Extraction/Sources/'  . 'lemondefr' . '/' . 'lemondefr' . 'Debug.php');
        $this->sourceFile->puts($this->htmlDebugFile);
        $this->sourceFile->closeFile();
    }

    function DOMinnerHTML($element) { /////////REDONDANCE NE PAS LAISSER LONGTEMPS CETTE FONCTION  LA
        $innerHTML = ""; //On initialise notre variable
        $children = $element->childNodes; //On récupére les enfants ///////////ALLERTE GO A PARSERHTMLTWITTER.PHP !!!!!!!!!!!!!!!!
        foreach ($children as $child) {  //Pour chaque enfants
            $tmp_dom = new DOMDocument();  // on crée un nouveau document
            $tmp_dom->appendChild($tmp_dom->importNode($child, true));  //On créer un noeud depuis le noeud importé du paramétre
            $innerHTML.=trim($tmp_dom->saveHTML()); //Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        }
        return $innerHTML; //On retourne notre portion de texte qui est ainsi rebalisé
    }

    public function parsage($document) { // On va parser le document
        $htmlPure = preg_replace('@<script[^>]*?>.*?</script>@si', '', mb_convert_encoding(@file_get_contents($document), 'HTML-ENTITIES', "UTF-8")); //On extrait le lien avec file_get_contents, puis on le parse pour supprimer le javascript
        $htmlPure = preg_replace('@<style[^>]*?>.*?</style>@si', '', $htmlPure); //On le reparse pour supprimer le css
        //echo $htmlPure;
        $html = new DOMDocument('1.0', 'utf-8'); //On charge un nouveau DOMDocument
        @$html->loadHTML($htmlPure); //On charge notre article précédemment parser en tant qu'HTML et on supprime les messages d'érreurs
        $elements = $html->getElementsByTagName('body'); //Maintenant, on récupére tous les élements de balise <rss>, un suel normalement
        $arbre = $elements->item(0); //On mets le curseur de l'arbre sur le premier élément

        $resultat_html = $this->parsageenfant($arbre); // On commence le parsage

        return $resultat_html; // Une fois fini, on retourne le résultat final
    }

    public function parsage_normal($noeud, $compt) {
        $baliseNoClose = array('area', 'base', 'br', 'col',  'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');
        $attributes = array ('src', 'href');
        $intermediaire = '';
        foreach ($baliseNoClose as $tag){
            /*if (preg_match('/' . $tag . '/i', $noeud->nodeName)){
                if ($tag == 'img'){
                    $intermediaire .= '<input type="checkbox"> <' . $tag . 'src =' . $noeud->getAttribute('src') .'/><br>';
                }
                else if ($tag == 'a'){
                    $intermediaire .= '<input type="checkbox"> <' . $tag . 'href=' . $noeud->getAttribute('href') . '>' . $noeud->nodeValue . '</' . $tag .'><br>';
                } else {
                    $intermediaire .= '<input type="checkbox"> <' . $tag . '/><br>';
                }
            } else {
                $intermediaire .='<input type="checkbox"> <' . $tag . '>' . $noeud->nodeValue . '</' . $tag .'><br>';
            }*/
            $intermediaire .= '<input type="checkbox">' . $noeud->nodeValue . '<br>' ;
        }
        
        return $intermediaire; // On renvoie le texte parsé
    }

    public function parsageenfant($noeud, $compt = 0) {// Fonction de parsage d'enfants
        if (!isset($accumulation)) { // Si c'est la première balise, on initialise $accumulation
            $accumulation = '';
        }
        $enfantsniv1 = $noeud->childNodes;
        foreach ($enfantsniv1 as $enfant) {
            if ($enfant->hasChildNodes() == true) {
                $accumulation .= $this->parsageenfant($enfant, $compt); // Dans ce cas, on revient sur parsage_enfant
            } else {
                $accumulation .=  $this->parsage_normal($enfant, $compt); // On parse comme un nœud normal
                ++$compt;
            }
        }
        return $accumulation;
    }

}

new ExtractDebugArticle('http://www.lemonde.fr/tiny/4842029/');