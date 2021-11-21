<?php 
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page"); //stop executing any code coming after this statement
}

$videoId=$_GET["id"];
$video = new Video($con, $videoId);
$video->incrementViews();

?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button class="iconButton" onClick=goBack()><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
</div>
    <video controls autoplay playsinline muted>
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>
<script>
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn?>")
</script>