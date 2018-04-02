<?php

require_once 'AlwaysNeeded.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$form = '
			<div id="contact-form">
			
				<h1 class="titre-a-propos">Venez!</h1>
				<h2>Connexion Rapide</h2>
				<meta name="google-signin-scope" content="profile email">
				<meta name="google-signin-client_id" content="670403014763-cmjg76o07elk12oi4b9lgcen6ig2agb9.apps.googleusercontent.com">
				<script src="https://apis.google.com/js/platform.js" async defer></script>
				<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
				<script src="https://apis.google.com/js/api:client.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	  
				<script>

					var googleUser = {};
					var startApp = function() {
					gapi.load(\'auth2\', function(){
					  auth2 = gapi.auth2.init({
						client_id: \'670403014763-cmjg76o07elk12oi4b9lgcen6ig2agb9.apps.googleusercontent.com\',
						cookiepolicy: \'single_host_origin\',
						});
					  attachSignin(document.getElementById(\'customBtn\'));
					});
					};

					function attachSignin(element) {
					console.log(element.id);
					auth2.attachClickHandler(element, {},
						function(googleUser) {
						  document.getElementById(\'name\').innerText = "Signed in: " +
								googleUser.getBasicProfile().getName();
								var profile = googleUser.getBasicProfile();
								console.log("ID: " + profile.getId());
								console.log("Name: " + profile.getName());
								console.log("Image URL: " + profile.getImageUrl());
								console.log("Email: " + profile.getEmail());
								connexionReussi = profile.getName();

								
								
								if(profile.getEmail() != null)
								{
									
									$(function()
									{

										$.post(
				
											\'connectionAvecGoogle.php\', 
											{
												
												email : profile.getEmail() ,
												nom : profile.getName()


											},
											function(data){

							
												if(data == 0)
												{
													
													 console.log("utilisateur creer");
													 document.location.href="index.php";
												}
												else{
													
													 console.log("compte deja creer");
													 document.location.href="index.php";
												}
												
											}
										);
									});
								
									
								}
								
						}, 
						function(error) {
						  alert(JSON.stringify(error, undefined, 2));
						});
					

					}	
				</script>
				<div id="gSignInWrapper">
					<div id="customBtn" class="customGPlusSignIn">
						<span class="icon">G</span>
						<span class="buttonText">Connexion</span>
					</div>
				</div>
				<div id="name"></div>
				<script>startApp();</script>
			
				<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
				<br/>
				<br/>
		
				<script>
				  var nom;
				  var user_email;
				  var appuyer = 0;
				
				
				  function statusChangeCallback(response) {
					console.log(\'statusChangeCallback\');
					console.log(response);
					
					if (response.status === \'connected\') {
					  testAPI();
					} else if (response.status === \'not_authorized\') {
					  
					  document.getElementById(\'status\').innerHTML = \'Please log \' +
						\'into this app.\';
					} else {
					
					  document.getElementById(\'status\').innerHTML = \'Please log \' +
						\'into Facebook.\';
					}
				  }

				  function checkLoginState() {
					  
						
					
						FB.getLoginStatus(function(response) {
					  statusChangeCallback(response);
					});
					
					
					
				  }
					
				  
				  window.fbAsyncInit = function() {
				  FB.init({
					appId      : \'1522400578053239\',
					cookie     : true,  // enable cookies to allow the server to access 
										// the session
					xfbml      : true,  // parse social plugins on this page
					version    : \'v2.2\' // use version 2.2
				  });


				  FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				  });

				  };

				 
				  (function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "https://connect.facebook.net/fr_FR/all.js";
					fjs.parentNode.insertBefore(js, fjs);
				  }(document, \'script\', \'facebook-jssdk\'));

				  function testAPI() {
					
					appuyer += 1;
					FB.api(\'/me\', function(response) {
					  console.log(\'Successful login for: \' + response.name);
					  
						nom = response.name;
						FB.api(\'/me\', { locale: \'en_US\', fields: \'name, email\' },
						  function(response) {
							console.log("le mail est :" +response.email);
							user_email = response.email;
							if(appuyer == 2 && user_email != null) // si user appuie sur la bouton facebook
							{
								$(function()
									{

										$.post(
				
											\'connectionAvecFacebook.php\', 
											{
												
												email : user_email ,
												nom : nom


											},
											function(data){

							
												if(data == 0)
												{
													
													 console.log("utilisateur creer");
													 document.location.href="index.php";
												}
												else{
													
													 console.log("compte deja creer");
													 document.location.href="index.php";
												}
												
											}
										);
									});
								
							}
							
						  }
						);
						
					});
					
				  }
				</script>
			
			<fb:login-button max_rows="4" size="xlarge" show_faces="false" auto_logout_link="false" onlogin="checkLoginState();"></fb:login-button>
			<br/>
			<br/>
			<br/>
			<h2>Connexion</h2>	
	  			<form method="post" action="Connection/Data_processing.php" id="form-appear"> 
		  		<label class="label">
					Pseudo:
				</label>
				<input type="text" name="login" size=40 maxlength="25" value="" /><br/>
				<br />
				<label class="label">
				    	Mot de passe:
				</label>
				<input type="password" name="Password" size=40 maxlength="24"/><br/>
				<br />
				<a id="oubli" href="Forgot_Logs/Forgot_Logs.php" > Logs oubliés? </a>
				<input type="submit" value="Envoyer" id="submit-button" />
                <br/><br/>
				</form>
			</div>		';

echo affichercontenu('Connexion', 0, '', $form); 
