<?php 
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page"); //stop executing any code coming after this statement
}

$videoId=$_GET["id"];
$video = new Video($con, $videoId);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($con, $video);

?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button class="goBackBtn" onClick="goBack()"><img src="assets/images/long-arrow-left.svg"></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext hidden">
        <!-- <button onClick="restartVideo()"><i class="fas fa-redo"></i></button> -->
        <div class="upNextContainer">
        <h2><?php echo $upNextVideo->getTitle(); echo $upNextVideo->getSeasonAndEpisode(); ?> </h2>
        <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?> </h3>

            <!-- <h3><?php echo $upNextVideo->getTitle(); ?></h3> -->
            <!-- <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3> -->
            <p><?php echo $upNextVideo->getDescription(); ?></p>
        </div>

        <button class="playNext" onClick="watchVideo(<?php echo $upNextVideo->getId(); ?>)">
            <i class="fas fa-play"></i> 
            <span>Next Episode</span>
        </button>
    </div>    

    <video controls autoplay playsinline muted onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>
<script>
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn?>")
</script>