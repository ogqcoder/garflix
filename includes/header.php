<?php
require_once("includes/classes/config.php");
// require_once("includes/classes/FormSanitizer.php");
// require_once("includes/classes/Account.php");
// require_once("includes/classes/Constants.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/CategoryContainer.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoProvider.php");

if(!isset($_SESSION["userLogged"])) {
    header("Location: register.php");
    //if it isnt set, it will take you back to register page
}


$userLogged = $_SESSION["userLogged"];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="styler3.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a3ba819db4.js" crossorigin="anonymous"></script>
    <script type="text/javascript"  src ="assets/js/script1.js"> </script>
  </head>
  <body>
    <div class="wrapper">

      <?php
      if(!isset($hideNav)){ //go to watch.php
        include_once("includes/navBar.php");

      }
       ?>
