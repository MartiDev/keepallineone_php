/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
	$(".wrapper-jaime div").click(function() {
		
		var id_article = $(this).attr('class');
		
		$.post('blog/ShowPartage.php',{id_article:id_article},function(data) {
			
			if (data=="add")
			{
				displayNbPartage(id_article);
				displayArticlepartage(id_article);
			}
			else if (data=="remove")
			{
				displayNbPartage(id_article);
				displayArticlenonpartage(id_article);
				
			}
		});
	});
	
	function displayNbPartage(id_article) {
		$.post('blog/UpdatePartage.php',{id_article:id_article}, function(data){
			
			$('.id' + id_article).text(data);
		});
	}
	
	function displayArticlepartage(id_article) {
		$( '#a' + id_article + ' h4' ).addClass( "like" );
		$( '#a' + id_article + ' i' ).addClass( "like" );
		$( '.' + id_article).css('background-color' , '#d14841');
	}
	
	function displayArticlenonpartage(id_article) {
		$( '#a' + id_article + ' h4' ).removeClass( "like" );
		$( '#a' + id_article + ' i' ).removeClass( "like" );
		$( '.' + id_article).css('background-color' , '#6a717f');
			
	}
	// Quand on click sur partager bah ca add un like en faisant appel à UpdatePartage.php mais cette fonction
	// en particulier permet d'ajouter 'visuellement' le nouvel article
});

// Il faut rajouter le fait qu'au chargement de la page on affiche différemment les articles qu'on aime.
// Ca se fait au niveau du titre et du bouton j'aime entre autres