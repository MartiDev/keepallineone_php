<?php


function displayWithChamp ($pseudo, $prenom, $nom, $mail){
    $contenu = '
			<div id="contact-form">
				<h1 class="titre-a-propos">Changez vos identifiants</h1>
			    	<h2>Vous pouvez ne changer que certains champs si vous le désirez</h2>
			    	<form method="post" action="Change_Information_Processing.php">
					<label class="label">
						Ancien Pseudo : ' . Securite::outputData($pseudo) .' <br /> Nouveau :
					</label>
					<input type="text" name="changepseudo" id="pseudo" size=40 maxlength="25" onblur="verifierPseudo(this)"/>
					<br /><hr><br />
					<label class="label">
						Ancien Prenom : ' . Securite::outputData($prenom) . ' <br /> Nouveau : 
					</label>
					<input type="text" name="changeprenom" size=40 maxlength="25" onblur="verifierNomPrenom(this)"/>
					<br /><hr><br />
					<label class="label">
						Ancien nom : ' .  Securite::outputData($nom) . ' <br /> Nouveau : 
					</label>
					<input type="text" name="changenom" size=40 maxlength="25" onblur="verifierNomPrenom(this)"/>
					<br /><hr><br />
					<label class="label">
						Ancien Email : ' . Securite::outputData($mail) . ' <br /> Nouveau : 
					</label>
					<input type="text" id ="mail" name="changemail" onblur="verifierMail(this)"/>
					<br />
					<label class="label">
						Vérifiez : 
					</label>
					<input type="text" name="changeremail" onblur="verifierMailCopie(this)"/>
					<br /><hr><br />
					<label class="label">
						Ancien Mot de passe :
					</label>
					<input type="password" name="lastpassword" size=40 maxlength="24"  />
					<br /> 
					<label class="label">
						Nouveau mot de passe :
					</label>
					<input type="password" id ="motDePasse" name="changepassword" size=40 maxlength="24" onblur="verifierMotDePasse(this)"/>
					<br />
					<label class="label">
						Retapez votre mot de passe :
					</label>
					<input type="password" name="changerepassword" size=40 maxlength="24"  onblur="verifierMotDePasseCopie(this)"/>
					<br />
					<input type="submit" value="Valider" id="submit-button" />
					<br />
				</form> 
			</div>';
        return $contenu;
}

function updatePassWord ($password){
    $query ='UPDATE User SET password = "' . $password . '" WHERE ID = "' . $_SESSION['ID'] . '" ';
    SPDO::getInstance()->query($query);
}

function updateName($name){
    $query ='UPDATE User SET name = "' . $name . '" WHERE ID = "' . $_SESSION['ID'] . '" ';
    SPDO::getInstance()->query($query);
}

function updatePrenom ($prenom){
    $query ='UPDATE User SET firstName = "' . $prenom . '" WHERE ID = "' . $_SESSION['ID'] . '" ';
    SPDO::getInstance()->query($query);
}

function updatePseudo ($pseudo){
    $query ='UPDATE User SET pseudo = "' . $pseudo . '" WHERE ID = "' . $_SESSION['ID'] . '" ';
    SPDO::getInstance()->query($query);
}

function updateMail ($mail){
    $query ='UPDATE User SET email = "' . $mail . '" WHERE ID = "' . $_SESSION['ID'] . '" ';
    SPDO::getInstance()->query($query);
}
