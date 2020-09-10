<?php
class Video {
  private $conn, $sqlData, $entity; //input variable is either data from database or id

      public function __construct($conn, $input){
      $this->conn = $conn;

      if(is_array($input)){ //if is associative array
        $this->sqlData = $input;
      }else {
        $query = $this->conn->prepare("SELECT * FROM videos WHERE id = :input ");
        $query->bindValue(":input", $input);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC); //store data in
      }

      $this->entity = new Entity($conn, $this->sqlData["entityId"]);

    }


    public function getId(){
      return $this->sqlData["id"];
    }
    public function getEntityId(){
      return $this->sqlData["entityId"];
    }
    public function getTitle(){
      return $this->sqlData["title"];
    }
    public function getDescription(){
      return $this->sqlData["description"];
    }
    public function getFilePath(){
      return $this->sqlData["filePath"];
    }
    public function getThumbnail(){
      return $this->entity->getThumbnail(); //from the Entity class since thumbnail is not available to this specific table
    }
    public function getEpisodeNumber(){
      return $this->sqlData["episode"];
    }
    public function getSeasonNumber(){
      return $this->sqlData["season"];
    }
    public function incrementViews(){
      $query = $this->conn->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
      $query->bindValue(":id",$this->getId());
      $query->execute();

    }
    public function getSeasonAndEpisode(){
        if($this->isMovie()){
          return;
        }
        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();
        return  "Season $season, Episode $episode";
    }


    public function isMovie(){
      return $this->sqlData["isMovie"] == 1;
    }

    public function isInProgress($username){
      $query = $this->conn->prepare("SELECT * FROM videoprogress
      WHERE videoId=:videoID AND username=:username");

      $query->bindValue(":videoID",$this->sqlData['id']);
      $query->bindValue(":username",$username);

      $query->execute();

      return $query->rowCount() != 0;
    }

    public function hasSeen($username){
      $query = $this->conn->prepare("SELECT * FROM videoprogress
      WHERE videoId=:videoID AND username=:username AND finished=1");

      $query->bindValue(":videoID",$this->sqlData['id']);
      $query->bindValue(":username",$username);

      $query->execute();

      return $query->rowCount() != 0;
    }
}

 ?>
