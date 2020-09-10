<?php

class VideoProvider {
  public static function getUpNext($conn, $currentVideo){
    $query = $conn->prepare("SELECT * FROM videos WHERE entityId=:entityId
    AND id != :videoId
    AND ((season = :season AND episode >:episode) OR season > :season) ORDER BY
    season, episode ASC LIMIT 1");

    $query->bindValue(":entityId", $currentVideo->getEntityId());
    $query->bindValue(":season", $currentVideo->getSeasonNumber());
    $query->bindValue(":episode", $currentVideo->getEpisodeNumber());
    $query->bindValue(":videoId", $currentVideo->getId());

    $query->execute();

    if($query->rowCount() == 0){ // if already at last video of the last season
      $query = $conn->prepare("SELECT * FROM videos
        WHERE season <=1 AND episode <= 1 AND id != :videoID
        ORDER by views DESC LIMIT 1 ");
        $query->bindValue(":videoID", $currentVideo->getId());

        $query->execute();

    }

    $row = $query->fetch(PDO::FETCH_ASSOC);
    return new Video($conn, $row);

  }

  public static function getEntityVideoForUser($conn, $entityId, $username){
    $query = $conn->prepare("SELECT videoId FROM videoprogress
    INNER JOIN videos
    ON videoProgress.videoId = videos.id
    WHERE videos.entityId = :entity
    AND videoProgress.username = '$username'
    ORDER BY videoProgress.dateModified DESC
    LIMIT 1");

$query->bindValue(":entity", $entityId);
$query->execute();

if($query->rowCount() == 0){
$query = $conn->prepare("SELECT id FROM videos WHERE entityID =:entity
ORDER BY season, episode ASC LIMIT 1");

$query->bindValue(":entity", $entityId);
$query->execute();
}

return $query->fetchColumn();

  }
}
 ?>
