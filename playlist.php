<?php include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $playlistId = $_GET['id'];
  } else {
    header("Location: index.php");
  }

  $playlist = new Playlist($con, $playlistId);
  $owner = new User($con, $playlist->getOwner());

?>

<div class="album-info-top">
  <div class="left-section">
    <div class="playlist-icon">
      <img src="assets/images/icons/playlist.png">
    </div>
  </div>
  <div class="right-section">
    <h2 class="playlist-name"><?php echo $playlist->getName(); ?></h2>
    <p>by <?php echo $playlist->getOwner(); ?></p>
    <p><?php echo $playlist->getSongCount() . " " . ngettext("track", "tracks", $playlist->getSongCount()); ?></p>
    <button class="button" onClick="deletePlaylist('<?php echo $playlistId; ?>')">Delete Playlist</button>
  </div>
</div>
<div class="tracks-container">
  <ul class="track-list">
    <?php
      $songIdArray = $playlist->getSongIds();
      $i = 1;

      foreach ($songIdArray as $songId) {
        $song = new Song($con, $songId);
        $artist = $song->getArtist()->getName();

        echo "<li class='track-list-row'>
                <div class='track-count'>
                  <i class='fas fa-play' onClick='setTrack(\"{$song->getId()}\", tempPlaylist, true)'></i>
                  <span class='track-number'>{$i}</span>
                </div>
                <div class='track-info'>
                  <span class='track-name'>{$song->getTitle()}</span>
                  <span class='artist-name'>{$artist}</span>
                </div>
                <div class='track-options'>
                  <input type='hidden' class='song-id' value='{$song->getId()}'>
                  <i class='fas fa-ellipsis-h' onClick='showOptionsMenu(this)'></i>
                </div>
                <div class='track-length'>
                  <span class='duration'>{$song->getDuration()}</span>
                </div>
              </li>";
        $i++;
      }
    ?>

    <script>
      var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
      tempPlaylist = JSON.parse(tempSongIds);
    </script>
  </ul>
</div>
<!-- popup menu for each track -->
<nav class="options-menu">
  <input type="hidden" class="song-id">
  <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
  <div class="item" onClick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
</div>
