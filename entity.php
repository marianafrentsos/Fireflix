<?php 
require_once("includes/header.php");


//get the url 
if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page"); //stop executing any code coming after this statement
}

$entityId = $_GET["id"];
$entity = new Entity($con, $entityId);


$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($con, $userLoggedIn);
echo $seasonProvider->create($entity);

$seasonProvider = new CategoryContainers($con, $userLoggedIn);
echo $seasonProvider->showCategory($entity->getCategoryId(), "You might also like");
?>
