<?php

class PreviewProvider {

    private $con;
    private $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createPreviewVideo($entity) {

        if($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();

        return "<div class='previewContainer'>
                    <img src='$thumbnail' class='previewImage' hidden>
                    
                    <video autoplay muted class='previewVideo'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                    <div class='mainDetails'>
                    <h3 class='movieTitle'>$name</h3>
                    <div class='buttons'>
                    <button class='fas fa-play'> Play</button>
                    <button class='fas fa-volume-mute'></button>
                    </div>
                    </div>
                    
                    </div>
                <div>";
    }

    private function getRandomEntity() {
        Global $con;

        $query=$con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Entity($con, $row);
    }
}
?>