<?php

class CategoryContainers {

    private $con;
    private $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function showAllCategories() {
        Global $con;
        $query = $con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHTML($row, null, true, true);
        }

        return $html . "</div>";

    }

    private function getCategoryHTML($sqlData, $title, $tvShows, $movies) {

        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;

        if($tvShows && $movies) {
            $entities = EntityProvider::getEntities($this->con, $categoryId, 30);
        } else if($tvShows) {
            //Get tv shows entities

        } else {
            //Get movie entities
        } 

        if(sizeof($entities) == 0) {
            return;
        }

        $entitiesHtml = "<div class='categorieRow'>";
        $previewProvider = new PreviewProvider($this->con, $this->username);

        foreach($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }
        return $entitiesHtml . "</div>";
        
    }
}
?>