<?php

class EntityProvider {
    
    public static function getEntities($con, $categoryId, $limit) {

        $sql = "SELECT * FROM entities "; //select from entities

        if($categoryId != null) { 
            //if categoryID is null in the params, add the string to the query 
            //and select the category with the id given in the param

            $sql .= "WHERE categoryId=:categoryId "; 
        }

        //add  this limit string to the query string
        $sql .="ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId !=null) {
            //check again if categoryId is not null and bind its value
            $query->bindValue(":categoryId", $categoryId);
        }

        //bind limit with the param limit
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //put the entity into the next available place in the results array
            $result[] = new Entity($con, $row);
        }

        return $result;

    }
}
?>