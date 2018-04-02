<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Display ($string)
{
    echo'
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
       
                <title> Le site de communication numéro 1!</title>
                <link rel="stylesheet" type="text/css" href="cssIndex.css">
                <link rel="stylesheet" type="text/css" href="../cssIndex.css">
            </head>

            <body>

                <header>
                    <img id="logo" src="../logo.png" alt="photo logo"> 
                    
                </header>

                   
            <div id = phrase >
         
                   ';
           echo $string;
           echo '
           </div>   
               
               <footer>
               
                <div>
                    <br/>
                    
                      <div id = merci > <p>Merci d\'avoir visiter notre site </p>  </div>
                        
                       <div id = "copyright" > <p > Fait par Martinez² © Copyright 2015 - Pigeon Voyageur </p> </div>
                       <br/>
                </div>
                           
                 

                 </footer>
            </body>

        </html>
    ';
}