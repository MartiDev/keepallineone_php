<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

final class VerifyInput {

    static function myCtype_alpha($string) {
        for ($i = 1; $i < strlen($string) - 1; ++$i) {
            if (!ctype_alpha($string[$i])) {
                throw new Exception('Les charactéres spécieux ne sont pas acceptés.');
            }
        }
        return true;
    }

    static function isNameOk($string) {
        if (strlen($string) < 5 || strlen($string) > 23) {
            throw new Exception('Saisie incorrect (min 3 et maximum 23)');
        }
        VerifyInput::myCtype_alpha($string);
        return true;
    }

    static function isAlreadyPseudo($string) {
        $Query = 'SELECT pseudo FROM User WHERE pseudo = "' . $string . '" ';
        $result = SPDO::getInstance()->query($Query);
        if ($result->rowCount() == 0) {
            return false;
        } else {
            throw new Exception('Le pseudo est déjà pris');
        }
    }

    static function IsMailRegex($string) {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('L\'email est invalide.');
        } else {
            return true;
        }
    }

    static function isAlreadyMail($string) {
        $Query = 'SELECT email FROM User WHERE email = "' . $string . '" ';
        $result = SPDO::getInstance()->query($Query);
        if ($result->rowCount() == 0) {
            return false;
        } else {
            throw new Exception('Votre adresse email est déjà enregistrée');
        }
    }
    
    static function DoesMailExist($string) {
        $Query = 'SELECT email FROM User WHERE email = "' . $string . '" ';
        $result = SPDO::getInstance()->query($Query);
        if ($result->rowCount() == 1) {
            return true;
        } else {
            throw new Exception('Votre adresse email n\'éxiste pas');
        }
    }

    static function AreMailBothSame($email, $secondEmail) {
        if ($email != $secondEmail) {
            throw new Exception('Vos adresses email ne correspondent pas');
        } else {
            return true;
        }
    }

    static function IsPassWordRegex($string) {
        if (strlen($string) < 8 || strlen($string) > 18) {
            throw new Exception(' Le mot de passe n\'est pas valid (inférieur à 8 ou supérieur à 18 )');
        } else {
            $upperCompt = 0;
            $digitCompt = 0;
            for ($i = 0; $i < strlen($string); ++$i) {
                if (ctype_upper($string[$i])) {
                    ++$upperCompt;
                } else if (is_numeric($string[$i])) {
                    ++$digitCompt;
                }
            }
            if ($upperCompt < 1 || $digitCompt < 1) {
                throw new Exception('Votre mot de passe n\'est pas assez sécurisé, il nécessite au moins une majuscule et un chiffre');
            } else {
                return true;
            }
        }
    }

    static function ArePassWordBothSame($pass, $repass) {
        if ($pass == $repass) {
            return true;
        } else {
            throw new Exception('Vos mots de passe ne correspondent pas.');
        }
    }

    static function isAlreadyThisPassword($password) {
        $Query = 'SELECT password FROM User WHERE pseudo = "' . $_SESSION['username'] . '" ';
        $connect = SPDO::getInstance()->query($Query);
            foreach ($connect as $row) {
                if (password_verify($password, $row['password'])) {
                    return true;
                } else {
                throw new Exception('Ce mot de passe n\'éxiste pas');
            } 
        }
    }
    
    static function verifIfChecked($login, $password) {
        if (empty($login) && empty($password)){
            throw new Exception('Vous n\'avez coché aucune option');
        }return false;
    } 
}
?>
