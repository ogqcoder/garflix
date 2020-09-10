<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
  //exit(""); //stops any further code after this page fro executing
ErrorMessage::show("No ID passed into page"); //same thing as above just put into a method
}
$entityId = $_GET["id"];
$entity = new Entity($conn, $_GET["id"]);


$preview = new PreviewProvider($conn, $userLogged);
echo $preview->createPreviewVideo($entity);

 $seasonProvider = new SeasonProvider($conn, $userLogged);
 echo $seasonProvider->create($entity);

 $categoryContainer  = new CategoryContainer($conn, $userLogged);
 echo $categoryContainer ->showCategory($entity->getCategoryId(), "You might also like");
 ?>
