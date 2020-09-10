<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
ErrorMessage::show("No id passed to page");
}

$preview = new PreviewProvider($conn, $userLogged);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$container = new CategoryContainer($conn, $userLogged);
echo $container->showCategory($_GET["id"]);
?>
