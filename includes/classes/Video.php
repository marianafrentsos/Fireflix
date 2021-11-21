<?php
class Video {
    private $con, $sqlData, $entity;
    public function __construct($con, $input) {

        $this->con = $con;

        if(is_array($input)) {
            $this->sqlData = $input; 
            
        } else {
            Global $con;

            $query = $con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id", $input);
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

    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id"); //increment the view count
        $query->bindValue(":id", $this->getId());
        $query->execute();
    }
}
?>