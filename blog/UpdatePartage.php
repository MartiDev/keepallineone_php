<?php

require_once "ClassBlog.php";
require_once '../AlwaysNeeded.php';
if (isset($_POST['id_article'])) {
    $id_article = $_POST['id_article'];
    $blog = new Blog();
    $nbPartage = $blog->getPartage($id_article);
    echo $nbPartage;
}
?>