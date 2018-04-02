<?php

		require_once 'AlwaysNeeded.php';
		

		
		$mail = $_POST['mail'];
		
        
        $prepare = SPDO::getInstance()->prepare('SELECT email FROM User WHERE email = "\'' . $mail . '\'"');
		$prepare->execute();
        if ($prepare->rowCount() == 0) {
            echo 0;
        } 
		else {
            echo 1;
        }
    
?>
