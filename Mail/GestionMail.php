<?php
require_once 'Mails.php';

class GestionMail{

    private $idUser;

    function __construct($idUser)
    {
        $this->idUser = $idUser;
    }

    public function showAllMails()
    {
        /*
         * On selectionne TOUS les mails de l'user, pour afficher
         * TOUS les message de CHAQUE mails
         * On affiche aussi un bouton SUPPRIMER pour chaque mail.
         */
        $QueryGetMails = 'SELECT * FROM Mail WHERE idUser = "' . $this->idUser .'"';

        $prepareMails = SPDO::getInstance()->prepare($QueryGetMails);
        $prepareMails->execute();

		
        while ($Mails = $prepareMails->fetch(PDO::FETCH_OBJ)) {

            $mail = new Mails($this->idUser, $Mails->email, $Mails->password, $Mails->typemail);
			$mail->connection();
            $unMail = '
            <form action ="mail.php" method="post">
                <input type="hidden" name="typemail" value="'. $Mails->typemail .'" />
                <input type="hidden" name="email" value="'. $Mails->email .'" />
                <input type="hidden" name="password" value="'. $Mails->password .'" />
                <p>Email : '. $Mails->email .' .  <input type="submit" name="action" value="Supprimer"/></p><br>
            </form>';

			$unMail .= $mail->showMails();
            
            return $unMail;
            $mail->deconnection();

        }

    }

}