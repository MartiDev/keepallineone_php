<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../XML/FileXMLForOneSource.php';
require '../TXT/FileTXT.php';

class Source {
    private $nomDeDomaine = '';
    private $adresseWeb = '';
    private $fluxRSS = [];
    private $fluxXML;
    private $sourceFile;
    
    public function __construct($adresseWeb = null, $fluxRSS = null){
        if ($adresseWeb != null){
        $this->adresseWeb = $adresseWeb;
        } 
        array_push($this->fluxRSS, $fluxRSS);
        $this->nomDeDomaine = $this->extractNomDeDomaineFromWebAdresse($adresseWeb);
        if (!file_exists('/home/lmcreation/www/Mon_Site_Vente/Extraction/Sources/'  . $this->nomDeDomaine . '/Articles')){
            mkdir('/home/lmcreation/www/Mon_Site_Vente/Extraction/Sources/' . $this->nomDeDomaine . '/Articles', 0700, true);
            $this->fluxXML = new FileXMLForOneSource($this->nomDeDomaine, $this->fluxRSS);
         }
            $this->sourceFile = new FileTXT('/home/lmcreation/www/Mon_Site_Vente/Extraction/Sources/'  . $this->nomDeDomaine . '/' . $this->nomDeDomaine . '.txt');  
            $contenu = $this->sourceFile->read();
            if ($contenu == null){
                $this->sourceFile->write(time() + 3*60); 
            }
            else if ($contenu <= time()){
                echo 'popopopopopopo';
                $this->fluxXML = new FileXMLForOneSource($this->nomDeDomaine, $this->fluxRSS);
                $this->sourceFile->seek(0);
                $this->sourceFile->puts(time() + 3*60); 
            }
            $this->sourceFile->closeFile();
    }
    
    private function extractNomDeDomaineFromWebAdresse ($adresseWeb){
        $nomDeDomaine = parse_url($adresseWeb, PHP_URL_HOST);
        $nomDeDomaine = preg_replace('/www./', '', $nomDeDomaine); 
        $nomDeDomaine = str_replace('.', '', $nomDeDomaine);
       return  $nomDeDomaine;
    }
    
    private function extractNomDeDomaineFromFluxRSSAdresse ($fluxRSSAdress){
       return  'http://' . parse_url($fluxRSSAdress, PHP_URL_HOST);
    }
    
    public function mettreAJour(){
        $this->fluxRSS->chargerXMLDansFichier($this->nomDeDomaine);
    }
    
    public function afficher(){
        
    }
    
    public function getNomDeDomaine(){
        return $this->nomDeDomaine;
    }
    
    public function getFluxRSS(){
        return $this->fluxRSS;
    }
    
    public function getAdresseWeb(){
        return $this->adresseWeb;
    }
}