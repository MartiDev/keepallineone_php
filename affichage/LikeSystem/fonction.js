$(document).ready(function() {
	$(".wrapper-jaime div").click(function() {
		
		var id_article = $(this).attr('class');
		
		$.post('show_like.php',{id_article:id_article},function(data) {
			
			if (data=="ok")
			{
				add_like(id_article);
			}
			else
			{
				alert('Vous avez déjà partagé');
			}
		});
	});
	
	function add_like(id_article)
	{
		$.post('add_like.php',{id_article:id_article}, function(data){
			
			$('.id'+id_article).text(data);
		});
	}
	// Quand on click sur like bah ca add un like en faisant appel à add_like.php mais cette fonction
	// en particulier permet d'ajouter 'visuellement' le nouvel article
});

// Il faut rajouter le fait qu'au chargement de la page on affiche différemment les articles qu'on aime.
// Ca se fait au niveau du titre et du bouton j'aime entre autres