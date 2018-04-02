<?php
require_once"ClassBlog.php";
require_once '../AlwaysNeeded.php';
if(isset($_POST['id_article']))
{
    $idA=$_POST['id_article'];
    
    $blog = new Blog();
    
    $queryVerif =  'SELECT * FROM Blog WHERE IDarticle="' .$idA . '" AND IDuser="' . $blog->getIdU() . '"';

    $prepareVerif = SPDO::getInstance()->prepare($queryVerif);
    $prepareVerif->execute();
    if($prepareVerif->rowCount() == null)
    {
        $blog->addArticle($idA);
    }
    else
    {
        $blog->deleteArticle($idA);
    }
}
