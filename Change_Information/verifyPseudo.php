<?php

		require_once '../AlwaysNeeded.php';
		

		
		$pseudo = $_POST['pseudo'];
		
        
        $prepare = SPDO::getInstance()->prepare('SELECT email FROM User WHERE pseudo = "\'' . $pseudo . '\'"');
		$prepare->execute();
        if ($prepare->rowCount() == 0) {
            echo 0;
        } 
		else {
            echo 1;
        }
    
?>
