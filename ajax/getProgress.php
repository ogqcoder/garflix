<?php
//starts video at the time of the column progress under the videoProgress Table
require_once("../includes/classes/config.php");
if(isset($_POST["videoId"]) && isset($_POST["userLogged"])){
  $query = $conn->prepare("SELECT progress FROM videoprogress WHERE username=:username AND
    videoId=:videoId");
    $query->bindValue(":username", $_POST["userLogged"] );
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();
    echo $query->fetchColumn(); //returns one column from query

}else {
  echo "No videoId, userLogged or progress passed into file ";
}
?>
