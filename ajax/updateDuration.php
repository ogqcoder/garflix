<?php
require_once("../includes/classes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["userLogged"]) && isset($_POST["progress"])){
  $query = $conn->prepare("UPDATE
    videoProgress SET progress=:progress, dateModified=NOW() WHERE username=:username AND
    videoId=:videoId");
    $query->bindValue(":username", $_POST["userLogged"] );
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":progress", $_POST["progress"]);

    $query->execute();

}else {
  echo "No videoId, userLogged or progress passed into file ";
} ?>
