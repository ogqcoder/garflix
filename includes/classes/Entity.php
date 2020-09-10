<?php
class Entity{

  private $conn, $sqlData; //input variable is either data from database or id

      public function __construct($conn, $input){
      $this->conn = $conn;

      if(is_array($input)){ //if is associative array
        $this->sqlData = $input;
      }else {
        $query = $conn->prepare("SELECT * FROM entities WHERE id = :input ");
        $query->bindValue(":input", $input);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC); //store data in
      }

    }

    public function getId(){
       return $this->sqlData["id"];
    }

    public function getCategoryId(){
       return $this->sqlData["categoryId"];
    }
    public function getName(){
       return $this->sqlData["name"];
    }

    public function getThumbnail(){
       return $this->sqlData["thumbnail"];
    }

    public function getPreview(){
       return $this->sqlData["preview"];
    }
    public function getSeasons(){
      $query = $this->conn->prepare("SELECT * FROM
      videos WHERE entityID = :id AND isMovie=0 ORDER BY season, episode ASC");
      //orders Seasons e.g Season 1, Season 2
      // also considering the *ORDER BY season,episode* query, it orders by the first property
      // which is season but when every 2 values have that same season number, it will order
      //by second which orders both season and episode nicely
      $query->bindValue(":id", $this->getId());
      $query->execute();

      $seasons = array();
      $videos = array();
      $currentSeason = null;
      while($row = $query->fetch(PDO::FETCH_ASSOC)){

        if($currentSeason != null && $currentSeason != $row['season']){
          $seasons[] = new Season($currentSeason,$videos);
          $videos = array(); // clear array for next title
        }

        $currentSeason = $row['season'];
        $videos[] = new Video($this->conn, $row);

      }

      if(sizeof($videos) != 0){ //handles the case when exited the loop -- the very last season
        $seasons[] = new Season($currentSeason,$videos);
      }

      return $seasons;
    }



}
 ?>
