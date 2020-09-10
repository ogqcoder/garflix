<?php
require_once("includes/header.php");

$preview = new PreviewProvider($conn, $userLogged);
echo $preview->createTVShowPreviewVideo();

$container = new CategoryContainer($conn, $userLogged);
echo $container->showTVShowCategories();
?>
