<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'ExtractTextArticle.php';

class FileHTMLForOneArticles {
   private $name = null;
   
   public function __construct($ArticleAdresse, $nomDeDomaine, $name, $endUrlName, $description) {
       $this->name = $name;
       
        $source = file_get_contents($ArticleAdresse);
      
        $Readability = new ExtractTextArticle($source);
          
        $Data = $Readability->getContent();
        if(strlen($Data) < 1200){
            $Data = $description;
        }
        
       file_put_contents(__DIR__ . '/../Sources/Articles/' . $this->name . '.php', affichercontenu('KAIO-Article', 0, '', $Data));
       file_put_contents(__DIR__ . '/../Sources/Articles/' . $this->name . '.html', $Data);
   }
}