<?php

function endpage($repertory = null) {
    $contenu =  '
		</div>
	</div>
    	<div id = "footer">
        	<a id="ancre" href="#top">Retourner en haut de page</a>
		<p>Tous les articles appartiennent à leurs auteurs respectifs, L\'équipe de KeepAllInOne n\' est en aucun cas responsable du contenu que vous ajoutez.</p>
        	<p>Version 2.3</p>
        	<p>Copyright © 2015 PUSKARIC Jean-Adam, MARTINEZ Mathieu, MARTINEZ Maxime, OSTROV Raphaël, Design PUSKARIC Jean-Adam</p>
        	<p class="footer">
            		<img  src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" />
            		<img  src="' . $repertory . 'affichage/images/HTML5Valide.png" alt="html5 Valide !" /> <!-- C\'est un montage car le vrai n\'existe pas pour le HTML -->
        	</p>
    	</div>
        
</body>
</html>';
    return $contenu;
}

?>
