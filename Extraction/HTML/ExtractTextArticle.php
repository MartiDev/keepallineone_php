<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("READABILITY_VERSION", 0.21);

class ExtractTextArticle {

    const ATTR_CONTENT_SCORE = "contentScore";
    const DOM_DEFAULT_CHARSET = "utf-8";
    const MESSAGE_CAN_NOT_GET = "Readability was unable to parse this page for content.";

    protected $DOM = null;
    protected $source = "";
    private $parentNodes = array();

    private $junkTags = Array("style", "form", "iframe", "script", "button", "input", "textarea",
        "noscript", "select", "option", "object", "applet", "basefont",
        "bgsound", "blink", "canvas", "command", "menu", "nav", "datalist",
        "embed", "frame", "frameset", "keygen", "label", "marquee", "link");
    private $junkAttrs = Array("style", "class", "onclick", "onmouseover", "align", "border", "margin");

   
    public function __construct($source, $input_char = "utf-8") {
        $this->source = $source;

 
        $source = mb_convert_encoding($source, 'HTML-ENTITIES', $input_char);

// HTML
        
        $source = $this->preparSource($source);
//La source contient maintenant le contenu du site
// DOM 
        
        $this->DOM = new DOMDocument('1.0', $input_char);
        try {
//libxml_use_internal_errors(true);
            
            if (!@$this->DOM->loadHTML('<?xml encoding="'.  ExtractTextArticle::DOM_DEFAULT_CHARSET.'">'.$source)) { //Si il a y des soucis avec le loading, on dis probléme
           
                throw new Exception("Parse HTML Error!");
            }
            
            foreach ($this->DOM->childNodes as $item) {
                if ($item->nodeType == XML_PI_NODE) {
                    $this->DOM->removeChild($item); // remove hack
                }
            }

// insert proper
            $this->DOM->encoding = ExtractTextArticle::DOM_DEFAULT_CHARSET;
        } catch (Exception $e) {
// ...
        }
    }

    
    private function preparSource($string) {
//HTML
        preg_match("/charset=([\w|\-]+);?/", $string, $match);
        if (isset($match[1])) {
            $string = preg_replace("/charset=([\w|\-]+);?/", "", $string, 1);
        }

// Replace all doubled-up <BR> tags with <P> tags, and remove fonts.
        $string = preg_replace("/<br\/?>[ \r\n\s]*<br\/?>/i", "</p><p>", $string);
        $string = preg_replace("/<\/?font[^>]*>/i", "", $string);


        $string = preg_replace("#<script(.*?)>(.*?)</script>#is", "", $string);

        return trim($string);
    }

    
    private function removeJunkTag($RootNode, $TagName) {

        $Tags = $RootNode->getElementsByTagName($TagName);

        while ($Tag = $Tags->item(0)) {
            $parentNode = $Tag->parentNode;
            $parentNode->removeChild($Tag);
        }

        return $RootNode;
    }

    /**
     * 
     */
    private function removeJunkAttr($RootNode, $Attr) {
        $Tags = $RootNode->getElementsByTagName("*");

        $i = 0;
        while ($Tag = $Tags->item($i++)) {
            $Tag->removeAttribute($Attr);
        }

        return $RootNode;
    }

   
    private function getTopBox() {
        $allParagraphs = $this->DOM->getElementsByTagName("p");


        $i = 0;
        while ($paragraph = $allParagraphs->item($i++)) {
            $parentNode = $paragraph->parentNode;
            $contentScore = intval($parentNode->getAttribute(ExtractTextArticle::ATTR_CONTENT_SCORE));
            $className = $parentNode->getAttribute("class");
            $id = $parentNode->getAttribute("id");
            $attributes = $parentNode->attributes;
            while ($attributes->length) {
                $parentNode->removeAttribute($attributes->item(0)->name); //Pour la validation W3C
            }

            if (preg_match("/(comment|meta|footer|footnote)/i", $className)) {
                $contentScore -= 50;
               
            } else if (preg_match(
                            "/((^|\\s)(post|hentry|entry[-]?(content|text|body)?|article[-]?(content|text|body)?)(\\s|$))/i", $className)) {
                $contentScore += 25;
             
            }
 
            if (preg_match("/(comment|meta|footer|footnote)/i", $id)) {
                $contentScore -= 50;
             
            } else if (preg_match(
                            "/^(post|hentry|entry[-]?(content|text|body)?|article[-]?(content|text|body)?)$/i", $id)) {
                $contentScore += 25;
               
            }


            if (strlen($paragraph->nodeValue) > 10) {
                $contentScore += strlen($paragraph->nodeValue);
            }

//
            $parentNode->setAttribute(ExtractTextArticle::ATTR_CONTENT_SCORE, $contentScore);

//
            array_push($this->parentNodes, $parentNode);
        }

        $topBox = null;


        for ($i = 0, $len = sizeof($this->parentNodes); $i < $len; $i++) {
            $parentNode = $this->parentNodes[$i];
            $contentScore = intval($parentNode->getAttribute(ExtractTextArticle::ATTR_CONTENT_SCORE));
            $orgContentScore = intval($topBox ? $topBox->getAttribute(ExtractTextArticle::ATTR_CONTENT_SCORE) : 0);

            if ($contentScore && $contentScore > $orgContentScore) {
                $topBox = $parentNode;
            }
        }

//$topBox
        return $topBox;
    }

    
    public function getTitle() {
        $split_point = ' - ';
        $titleNodes = $this->DOM->getElementsByTagName("title");

        if ($titleNodes->length && $titleNode = $titleNodes->item(0)) {

            $title = trim($titleNode->nodeValue);
            $result = array_map('strrev', explode($split_point, strrev($title)));
            return sizeof($result) > 1 ? array_pop($result) : $title;
        }

        return null;
    }

   
    public function getLeadImageUrl($node) {
        $images = $node->getElementsByTagName("img");
        if ($images->length && $leadImage = $images->item(0)) {
            return $leadImage->getAttribute("src");
        }

        return null;
    }

    
    public function getContent() {
        if (!$this->DOM)
            return false;


        $ContentTitle = $this->getTitle();
        $content = mb_convert_encoding('<h1>' . $ContentTitle . '</h1><br/>', ExtractTextArticle::DOM_DEFAULT_CHARSET);
        $ContentBox = $this->getTopBox();


        if ($ContentBox === null)
            return 0;

// DOMDocument
        $Target = new DOMDocument;
        $Target->appendChild($Target->importNode($ContentBox, true));

//
        foreach ($this->junkTags as $tag) {
            $Target = $this->removeJunkTag($Target, $tag);
        }

//
        foreach ($this->junkAttrs as $attr) {
            $Target = $this->removeJunkAttr($Target, $attr);
        }

        $content .= mb_convert_encoding($Target->saveHTML(), ExtractTextArticle::DOM_DEFAULT_CHARSET, "HTML-ENTITIES");

//
        return /* Array(
                  'lead_image_url' => $this->getLeadImageUrl($this->DOM),
                  'word_count' => mb_strlen(strip_tags($content), Readability::DOM_DEFAULT_CHARSET),
                  'title' => $ContentTitle ? $ContentTitle : null,
                  'content' => $content
                  ); */ $content;
    }

}
