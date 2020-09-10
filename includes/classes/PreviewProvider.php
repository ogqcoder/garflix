<?php
class PreviewProvider {

private $conn, $username;

      public function __construct($conn, $username){
          $this->conn = $conn;
          $this->username = $username;

        }

        public function createCategoryPreviewVideo($categoryId) {
            $entitiesArray = EntityProvider::getEntities($this->conn, $categoryId, 1);

            if(sizeof($entitiesArray) == 0) {
                ErrorMessage::show("No TV shows to display");
            }

            return $this->createPreviewVideo($entitiesArray[0]);
        }

        public function createTVShowPreviewVideo() {
            $entitiesArray = EntityProvider::getTVShowEntities($this->conn, null, 1);

            if(sizeof($entitiesArray) == 0) {
                ErrorMessage::show("No TV shows to display");
            }

            return $this->createPreviewVideo($entitiesArray[0]);
        }

      public function createPreviewVideo($entity){
        if($entity == null){
          $entity = $this->getRandomEntity();
        }
        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();


        $videoId = VideoProvider::getEntityVideoForUser($this->conn, $id, $this->username);
        $video = new Video($this->conn, $videoId);

        $inProgress = $video->isInProgress($this->username);
        $playButtonText = $inProgress ? "Continue Watching" : "Play";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";
        //if a movie do an empty string, if not do something else

        return "<div class='previewContainer'>
        <img src ='$thumbnail' class='previewImage' hidden>
          <video autoplay muted class ='previewVideo' onEnded ='previewEnded()'>
            <source src ='$preview' type ='video/mp4'>
          </video>

          <div class = 'previewOverlay'>
            <div class ='mainDetails'>
                <h3>$name</h3>
                $subHeading

                <div class ='buttons'>
                <button onclick ='watchVideo($videoId)'><i class='fas fa-play'></i> $playButtonText</button>
                <button onclick ='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                </div>
            </div>
          </div>


        </div>";



      //  echo "<img src ='$thumbnail'>"; echos random image
      }

      public function createMoviesPreviewVideo() {
          $entitiesArray = EntityProvider::getMoviesEntities($this->conn, null, 1);

          if(sizeof($entitiesArray) == 0) {
              ErrorMessage::show("No movies to display");
          }

          return $this->createPreviewVideo($entitiesArray[0]);
      }

      public function createEntityPreviewSquare($entity){
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entity.php?id=$id' >
              <div class ='previewContainer small' >
                  <img src ='$thumbnail' title ='$name'>
              </div>
        </a>";


      }

      private function getRandomEntity(){
        //selcts random movie from garflix database
        // $query = $this->conn->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
        // $query->execute();
        //
        // $row = $query->fetch(PDO::FETCH_ASSOC);
        // return new Entity($this->conn,$row);

        $entity = EntityProvider::getEntities($this->conn, null, 1); //this is the same function as above basically
        return $entity[0]; //still returns an array so choose the first in that array
      }
}
