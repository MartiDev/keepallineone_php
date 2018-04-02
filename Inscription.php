 <?php

require_once 'AlwaysNeeded.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $form = '
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
			<div id="contact-form">
				<h1 class="titre-a-propos">Inscription</h1>
			    	<h2>Toutes vos sources favorites, à un seul endroit.</h2>
			    	<form method="post" action="Register/Register_processing.php" id="form-appear">
					<label class="label">
			      			Nom: <span class="required">*</span>
					</label>
			       		<input type="text" name="nom" id="nom" size=40 maxlength="25" value="" onblur="verifierNomPrenom(this)"/> <br/>
					<br />
					<label class="label">
				    		Prenom: <span class="required">*</span>
					</label>
					<input type="text" name="prenom" size=40 maxlength="25" value="" onblur="verifierNomPrenom(this)"/> <br/>
					<br />
					<label class="label">
				    		Pseudo: <span class="required">*</span>
					</label>
					<input type="text" name="pseudo" size=40 maxlength="25" value="" /><br/>
					<br />
					<label class="label">
				   		<span>Votre e-mail: </span>:<span class="required">*</span>
					</label>
					<input id="mail" type="text" name="mail" size=40 onblur="verifierMail(this)" /><br/>
					<br />
					<label class="label">
				    		Vérification e-mail :<span class="required">*</span>
					</label class="label">
					<input type="text"  size=40  name="re-mail" onblur="verifierMailCopie(this)"/><br/>
					<br />
					<label class="label">
				    		Mot de passe: <span class="required">*</span><br/>
                                                (8 charactéres minimum, 1 chiffre,  1 majuscule) <br/>
					</label>
					<input id="motDePasse" type="password" name="password" size=40 maxlength="24" onblur="verifierMotDePasse(this)"/><br/>
					<br />
					<label class="label">
				    		Vérification mot de passe: <span class="required">*</span>
					</label>
					<input type="password" name="repassword" size=40 maxlength="24" onblur="verifierMotDePasseCopie(this)"/><br/>
					<input type="submit" value="Envoyer" id="submit-button" />
					<p id="req-field-desc"><span class="required">*</span></p>
					<label class="label">
						Champs requis
					</label>

			    	</form>
			</div>';
echo affichercontenu('Inscription', 0, 'Actualités', $form);
