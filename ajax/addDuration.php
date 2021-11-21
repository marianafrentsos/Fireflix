<?php 
require_once('../includes/config.php');

//pass in the videoId and username values
if(isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query=$con->prepare("SELECT * FROM videoProgress WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->execute();

    //check if any rows exist in the table
    //if there is now rows in the table, insert a row
    if($query->rowCount() == 0) {
        $query = $con->prepare("INSERT INTO videoProgress(username, videoId) VALUES(:username, :videoId)");
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();
    }
} else {
    echo "No videoId or username passed into file";
}
?>