<?php 

class Entity {

    private $con, $sqlData;
    public function __construct($con, $sqlData) {

        $this->con = $con;
        $this->sqlData = $sqlData;

        if(is_array($sqlData)) {
            // Global $sqlData;

            $this->sqlData = $sqlData; 
        } else {
            Global $con;
            // Global $sqlData;

            $query = $con->prepare("SELECT * FROM entities WHERE id=:id");
            $query->bindValue(":id", $sqlData);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC); //store the dat ainto an associative/key-value array 
        }
    }
    
    public function getId() {
        return $this->sqlData["id"];
    }
    
    
    public function getName() {
        return $this->sqlData["name"];
    }
    
    
    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }


    public function getPreview() {
        return $this->sqlData["preview"];
    }

    public function getCategoryId() {
        return $this->sqlData["categoryId"];

    }

    public function getSeasons() {
        
        Global $con;

        $query = $con->prepare("SELECT * FROM videos WHERE entityId=:id
                                        AND isMovie=0 ORDER by season, episode ASC" ); //do not select movies, order by season and then by episode
        $query->bindValue(":id", $this->getId());
        $query->execute();
        
        $seasons = array();
        $videos = array();
        $currentSeason = null;
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {

            if($currentSeason != null && $currentSeason != $row["season"]) {
                $seasons[] = new Season($currentSeason, $videos);
                $videos = array(); //reset the video array
            }

            $currentSeason = $row["season"];
            $videos[] = new Video($this->con, $row);
        }

        if(sizeof($videos) !=0 ) {
            $seasons[] = new Season($currentSeason, $videos);

        }

        return $seasons;

    }
}
?>