<?php
// all for keeping track of video progress
require_once("../includes/classes/config.php");
if(isset($_POST["videoId"]) && isset($_POST["userLogged"])){
  $query = $conn->prepare("UPDATE
    videoProgress SET finished=1, progress=0 WHERE username=:username AND
    videoId=:videoId");
    $query->bindValue(":username", $_POST["userLogged"] );
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

}else {
  echo "No videoId, userLogged or progress passed into file ";
}
?>
