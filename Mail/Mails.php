<?php
require_once 'AlwaysNeeded.php';
class Mails {

    /*
     * [3:15:00 PM] Gruuuudu: if ($connect->rowCount() != 0) {
            foreach ($connect as $row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['keyConnection'] = md5(microtime() . rand() * $row['ID']);
                    //$this->InsertKeyConnection($_SESSION['keyConnection'], $row['ID']);
                    $_SESSION['ID'] = $row['ID'];
                    $_SESSION['pseudo'] = trim($row['pseudo'], '\'');
                    / header('Location: index.php'); /
                }
            }
[3:15:04 PM] Gruuuudu: pour la vérification
[3:15:34 PM] Gruuuudu: $Hashpassword = password_hash($password, PASSWORD_DEFAULT);
[3:15:37 PM] Gruuuudu: pour l'encryptage
     */

    private $idUser;

    private $typemail;
    private $hostname;
    private $email;
    private $password;

    private $inbox; //pour l'affichage des message du mail


    /*
     * CONSTANTE de type de mail, pour la connection à IMAP.
     */
    const outlookHostName = '{imap-mail.outlook.com:993/imap/ssl}INBOX';
    const gmailHostName = '{imap.gmail.com:993/imap/ssl}INBOX';
    const yahooHostName = '{imap.mail.yahoo.com:993/imap/ssl}INBOX';


    function __construct($idUser,$email,$password,$typemail)
    {
        $this->idUser = $idUser;
        $this->typemail = $typemail;
        $this->email = $email;
        $this->password = $password;

        if($typemail == 'Gmail')
           $this->hostname = self::gmailHostName;
        elseif($typemail == 'Outlook')
            $this->hostname = self::outlookHostName;
        elseif($typemail == 'Yahoo')
            $this->hostname = self::yahooHostName;
    }


    public function addEMail(){
        $queryAddMail = 'INSERT INTO Mail (idUser, email, password, typemail)  VALUES (\'' . $this->idUser .
            '\', \''. $this->email . '\',\''. $this->password . '\',\''. $this->typemail .'\') ';

        if(!($prepareAddMail = SPDO::getInstance()->prepare($queryAddMail))) return;
        $prepareAddMail->execute();
    }

    public function deleteEMail(){
        $queryDeleteMail = 'DELETE FROM Mail WHERE idUser = \'' . $this->idUser .
            '\' AND email=\''. $this->email . '\'';

        if(!($prepareDeleteMail = SPDO::getInstance()->prepare($queryDeleteMail))) return;
        $prepareDeleteMail->execute();
    }

    public function connection()
    {
        $this->inbox = imap_open($this->hostname,$this->email,$this->password) or die('Cannot connect to e-mail: ' . imap_last_error());
    }

    public function deconnection()
    {
        imap_close($this->inbox);
    }

    public function showMails()
    {
        /*
         * Affiche tous les emails d'une boite
         */

        $emails = imap_search($this->inbox,'ALL');

        if($emails) {
            $mail = '';

            // nouveaux mails en haut
            rsort($emails);

            foreach($emails as $email_number) {
                $overview = imap_fetch_overview($this->inbox,$email_number,0);
                $message = imap_fetchbody($this->inbox,$email_number,2);

                if($overview[0]->seen)
                    $mail.= 'EMAIL DEJA VUE<br><br>';
                else
                    $mail.= 'NOUVEAU MESSAGE<br><br>';

                //en-tete
                $mail.= 'Titre du mail : '.imap_utf8($overview[0]->subject).'<br>';
                $mail.= 'From : '.imap_utf8($overview[0]->from).'<br>';
                $mail.= 'Pour : '.imap_utf8($overview[0]->to).'<br>';
                $mail.= 'Date : '.$overview[0]->date.'<br><br>';

                //contenu
                $newDoc = new DOMDocument('1.0', 'utf-8');
				if(imap_qprint($message) != null){
					$newDoc->loadHTML(imap_qprint($message));
				}
                

                //Supprime les balises meta
                $html_fragment = preg_replace('/<meta[^>]+[\/>$]*/i', '', $newDoc->saveHTML());

                //supprimes balises title, head,body, etc, des messages.
                $html_fragment = preg_replace('~<(?:!DOCTYPE|/?(?:title|head|div|img|span|tr|td))[^>]*>\s*~i', '', $html_fragment);

                //Supprime option style des balises
                $html_fragment = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '', $html_fragment);

                $mail.= '<div class="Contenu">Contenu :<br>'.$html_fragment.'</div><br>_______________________________________<br><br><br><br><br><br>';
            }

            return $mail;
        }
    }


}