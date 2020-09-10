<?php
// all for keeping track of video progress
require_once("../includes/classes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["userLogged"])){
  $query = $conn->prepare("SELECT * FROM
    videoProgress WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["userLogged"] );
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

    if($query->rowCount() == 0){
        $query = $conn->prepare("INSERT INTO videoprogress (username, videoId) VALUES(:username, :videoId)");

        $query->bindValue(":username", $_POST["userLogged"] );
        $query->bindValue(":videoId", $_POST["videoId"]);

        $query->execute();
    }
}else {
  echo "No videoId or userLogged passed into file ";
}
 ?>
