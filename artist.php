<?php

  include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $artistId = $_GET['id'];
  } else {
    header("Location: index.php");
  }

  $artist = new Artist($con, $artistId);

?>

<div class="entity-info">
  <div class="artist-header">
    <h1 class="name"><?php echo $artist->getName(); ?></h1>
    <div class="header-buttons">
      <button class="button" onClick="playFirstSong()">PLAY</button>
    </div>
  </div>
  <div class="center-container">
    <div class="artist-albums">
      <h2 class="artist-albums-title">Albums</h2>

      <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist={$artistId} ORDER BY id DESC");
        while ($row = mysqli_fetch_array($albumQuery)) {
          echo "<div class='grid-item'>
                  <span role='link' tabindex='0' onClick='openPage(\"album.php?id={$row['id']}\")'>
                    <img src='{$row['artwork']}' alt='album cover'>
                    <div class='grid-item-info'>
                      {$row['title']}
                    </div>
                  </span>
                </div>";
        }
      ?>

    </div>
    <div class="tracks-container">
      <ul class="track-list">
        <h2>Tracks</h2>

        <?php
          $songIdArray = $artist->getSongIds();
          $i = 1;

          foreach ($songIdArray as $songId) {
            $song = new Song($con, $songId);
            $album = new Album($con, $song->getAlbumId());

            echo "<li class='track-list-row'>
                    <div class='track-count'>
                      <i class='fas fa-play' onClick='setTrack(\"{$song->getId()}\", tempPlaylist, true)'></i>
                      <span class='track-number'>{$i}</span>
                    </div>
                    <div class='track-info'>
                      <span class='track-name'>{$song->getTitle()}</span>
                      <span class='album-name'>{$album->getTitle()}</span>
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
  </div>
</div>
<!-- popup menu for each track -->
<nav class="options-menu">
  <input type="hidden" class="song-id">
  <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</div>
