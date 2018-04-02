<?php
		
			require_once 'AlwaysNeeded.php';
			

			$email = $_POST['email'];
			$nom = $_POST['nom'];
		
		
			
		
			$prepare = SPDO::getInstance()->prepare('SELECT email FROM User WHERE email = "\'\'\'' . $email . '\'\'\'"');			
			$prepare->execute();
			 if ($prepare->rowCount() == 0) {
				 
			    $prepare = SPDO::getInstance()->prepare('Insert into  User (name,email,pseudo) Values ("\'\'\'' . $nom . '\'\'\'","\'\'\'' . $email . '\'\'\'","\'\'\'' . $nom . '\'\'\'")');
			    $prepare->execute();
				$prepare = SPDO::getInstance()->prepare('SELECT ID, pseudo FROM User WHERE email= "\'\'\'' . $email . '\'\'\'"');
				$prepare->execute();
				 if ($prepare->rowCount() != 0) {
					foreach ($prepare as $row) {
								session_start();
								$_SESSION['keyConnection'] = md5(microtime() . rand() * $row['ID']);
								$_SESSION['ID'] = $row['ID'];
								$_SESSION['pseudo'] = trim($row['pseudo'], '\'');
					}
				 }
				 echo 0;
				
			} 
			else
			{
				$prepare = SPDO::getInstance()->prepare('SELECT ID, pseudo FROM User WHERE email= "\'\'\'' . $email . '\'\'\'"');
				$prepare->execute();
				 if ($prepare->rowCount() != 0) {
					foreach ($prepare as $row) {
								session_start();
								$_SESSION['keyConnection'] = md5(microtime() . rand() * $row['ID']);
								$_SESSION['ID'] = $row['ID'];
								$_SESSION['pseudo'] = trim($row['pseudo'], '\'');
					}
				 }
				 echo 1;
		
			}
			
			
			
		 	
?>
