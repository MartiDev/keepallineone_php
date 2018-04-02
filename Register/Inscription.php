<!DOCTYPE html>
<head>
    <script type="text/javascript" src="Verif_Inscr.js" charset="utf-8"></script>
</head>
<form action="Register_processing.php" method="post">
    <fieldset>
        <legend>
            <b>
                Vos Coordonnées
            </b>
        </legend>
        <label>
            Nom* :
        </label>
        <input type="text" name="nom" id="nom" size=40 maxlength="25" value="<?php if (isset($_POST['nom'])) echo $_POST['nom'] ?>" onfocus="focusFunction()" onblur="blurFunction()"/>
        <br />
        <label>
            Prénom* :
        </label>
        <input type="text" name="prenom" size=40 maxlength="25" value="<?php if (isset($_POST['prenom'])) echo $_POST['prenom'] ?>" onblur="verifPseudo(this)"/>
        <br />
        <label>
            Pseudo* :
        </label>
        <input type="text" name="pseudo" size=40 maxlength="25" value="<?php if (isset($_POST['pseudo'])) echo $_POST['pseudo'] ?>" onblur="verifPseudo(this)"/>
        <br />
        <label>
            E-mail* :
        </label>
        <input type="text" name="mail" value="<?php if (isset($_POST['mail'])) echo $_POST['mail'] ?>" onblur="verifMail(this)"/>
        <br />
        <label>
            Retape your E-mail* :
        </label>
        <input type="text" name="re-mail"/>
        <br />
        <label>
            Téléphonne :
        </label>
        <input type="tel" name="text" value="pas bon" onblur="VerifTel(this)"/>
        <br />
        <label>
            Mot de passe* :
        </label>
        <input type="password" name="password" size=40 maxlength="24"/>
        <br />
        <label>
            Retapez votre mot de passe* :
        </label>
        <input type="password" name="repassword" size=40 maxlength="24"/>
        <br />
        <input type="submit" value="Valider" />

    </fieldset>

</form>

 