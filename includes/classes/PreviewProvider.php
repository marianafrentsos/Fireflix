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
                    
                    <video autoplay muted class='previewVideo' onended=previewEnded()>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                    <div class='mainDetails'>
                    <h3 class='movieTitle'>$name</h3>
                    <div class='buttons'>
                    <button><i class='fas fa-play'></i> Play</button>
                    <button onClick=volumeToggle(this)><i class='fas fa-volume-mute'></i></button>
                    </div>
                    </div>
                    
                    </div>
                <div>";
    }

    private function getRandomEntity() {
        Global $con;

        $entity = EntityProvider::getEntities($con, null, 1);
        return $entity[0];
    }
}
?>