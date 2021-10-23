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
}
?>