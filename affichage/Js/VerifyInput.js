function createInstance()
{
  var req = null;
  if(window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) {
    try {
      req = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
       try {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            alert("XHR not created");
          }
      }
    }
    return req;
}


function surligne(champ, erreur)
{
   if(erreur)
      champ.style.borderColor = '#FF3300';
   else
      champ.style.borderColor = '#66FF00';
}

function verifierNomPrenom (champ)
{

	if (champ.value.length < 3 || champ.value.length > 23 || champ.value.search(/[^A-Za-z\s]/) !== -1)
	{
		surligne(champ , true );
	}
	else
	{
		surligne(champ , false );
	}

}


function verifierPseudo(champ)
{
	if (champ.value.length < 3 || champ.value.length > 23 || champ.value.search(/[^A-Za-z0-9\s]/) !== -1)
	{
		surligne(champ , true );
	}
	else
	{
		$(function()
			{

				$.post(
				
					'verifyPseudo.php', 
					{
						
						pseudo : $("#pseudo").val()  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.phps


					},
					function(data){

						
						if(data == 0)
						{
							 // Le membre est connecté. Ajoutons lui un message dans la page HTML.
							 surligne(champ , false );
						}
						else{
								 // Le membre n'a pas été connecté. (data vaut ici "failed")
								  surligne(champ , true );
								  alert("Ce speudo est déja utilisé");
						}
					}
				);
			});
	}
	
}


function verifierMail (champ)
{
	
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (!re.test(champ.value))
	{
		surligne(champ , true );
	}
	else
	{
		$(function()
		{

			$.post(
			
				'verifyMail.php', 
				{
					
					mail : $("#mail").val()  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.phps


				},
				function(data){

					
					if(data == 0)
					{
						 // Le membre est connecté. Ajoutons lui un message dans la page HTML.
						 surligne(champ , false );
					}
					else{
							 // Le membre n'a pas été connecté. (data vaut ici "failed")
							  surligne(champ , true );
							  alert("Vous avez déjà utilisé cette adresse mail");
					}
				}
			);
		});

	}
	
	/*
	var req =  createInstance();
    var data = "mail=" + document.getElementById("mail").value;
   	console.log(data);
	req.open("POST", "verifyMail.php", true); 
	req.onreadystatechange =  function(){
		
	console.log(req.readyState);
	console.log(req.status);
	 if (req.readyState == 4 && req.status == 200) {
		
	 	// 404 page non trouvée, 403 accès refusé, 200 requête réussie, etc.

	 
			
	 		console.log(req.responseText);
	
			if(req.responseText == 0)
			{
		  		surligne(champ , true );
			}
			else if(req.responseText == 1)
			{
		   		surligne(champ , false );
			}
	
	 	

	 }
	};
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send(data);
	*/
	
	
	
	
}




        





function verifierMailCopie (champMailCopie)
{
	var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var champ = document.getElementById("mail").value; 

	
	
	if (champ != champMailCopie.value || (!(re.test(champMailCopie.value))) ) // Pour pas le casse se colorie en vert si par exemple les deux mails sont vides
	{
		surligne(champMailCopie , true );
	}
	
	else
	{
		surligne(champMailCopie , false );
	}

}

function verifierMotDePasse (champ)
{
	var re =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
	//Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet and 1 Number:
   
	if (!(re.test(champ.value)))
	{
		surligne(champ , true );
	}
	else
	{
		surligne(champ , false );
	}
	
	

}

function verifierMotDePasseCopie (motDePasseCopie)
{
	var re =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
	//Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet and 1 Number:
	var champ = document.getElementById("motDePasse").value; 

	if (champ != motDePasseCopie.value || (!(re.test(motDePasseCopie.value))) )
	{
		surligne(motDePasseCopie , true );
	}
	else
	{
		surligne(motDePasseCopie , false );
	}

}








//verifForm();

