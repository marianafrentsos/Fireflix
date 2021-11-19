<?php
class Video {
    private $con, $sqlData, $entity;
    public function __construct($con, $sqlData) {

        $this->con = $con;
        $this->sqlData = $sqlData;

        if(is_array($sqlData)) {
            $this->sqlData = $sqlData; 

        } else {
            Global $con;
            Global $sqlData;

            $query = $con->prepare("SELECT * FROM entities WHERE id=:id");
            $query->bindValue(":id", $sqlData);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC); //store the data into an associative/key-value array 
        }
        $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getThumbnail() {
        return $this->entity->getThumbnail();
    }

    public function getEpisodeNumber() {
        return $this->sqlData["episode"];
    }
}
?>