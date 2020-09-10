<?php
require_once("includes/header.php");

$preview = new PreviewProvider($conn, $userLogged);
echo $preview->createPreviewVideo(null);

$container = new CategoryContainer($conn, $userLogged);
echo $container->showAllCategories();
 ?>
