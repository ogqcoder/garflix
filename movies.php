<?php
require_once("includes/header.php");

$preview = new PreviewProvider($conn, $userLogged);
echo $preview->createMoviesPreviewVideo();

$container = new CategoryContainer($conn, $userLogged);
echo $container->showMovieCategories();
?>
