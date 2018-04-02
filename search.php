<?php

  include("includes/includedFiles.php");

  if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
  } else {
    $term = "";
  }

?>

<div class="search-container">
  <h4>Search for an artist, album, or song</h4>
  <input type="text" class="search-input" value="<?php echo $term; ?>" onfocus=" var temp_val=this.value; this.value = ''; this.value=temp_val" placeholder="Start typing...">
</div>

<script>
  // keeps search field active
  $(".search-input").focus();

  // auto searches 1.5 seconds after typing has stopped
  $(function() {
    $(".search-input").keyup(function() {
      clearTimeout(timer);
      var input = $('.search-input').val();
      timer = setTimeout(function() {
        openPage("search.php?term=" + input);
      }, 1500);
    });
  });
</script>

<!-- if search field is empty, no results are shown -->
<?php if ($term === "") exit(); ?>

<div class="tracks-container">
  <ul class="track-list">
    <h2 style="padding: 20px 0; margin: 0;">Tracks</h2>

    <?php

      $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' LIMIT 10");

      if (mysqli_num_rows($songsQuery) === 0) {
        echo "<span class='no-results'>No song titles containing <i>{$term}</i></span>";
      }

      $songIdArray = array();
      $i = 1;

      while ($row = mysqli_fetch_array($songsQuery)) {
        array_push($songIdArray, $row['id']);

        $song = new Song($con, $row['id']);
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
<div class="artist-container">
  <h2>Artists</h2>

  <?php

    $artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

    if (mysqli_num_rows($artistQuery) === 0) {
      echo "<span class='no-results'>No artists found for <i>{$term}</i></span>";
    }

    while ($row = mysqli_fetch_array($artistQuery)) {
      $artistResult = new Artist($con, $row['id']);
      $artistAlbumTotal = count($artistResult->getAlbumIds()) . " " . ngettext("album", "albums", count($artistResult->getAlbumIds()));
      $artistTrackTotal = count($artistResult->getSongIds()) . " " . ngettext("track", "tracks", count($artistResult->getSongIds()));

      echo "<div class='artist-result-row' role='link' tabindex='0' onClick='openPage(\"artist.php?id={$artistResult->getId()}\")'>
            <span class='artist-info'>
              <span class='artist-name'>{$artistResult->getName()}</span>
              <p class='album-track-count'>{$artistAlbumTotal}, {$artistTrackTotal}</p>
            </span>
          </div>";
    }

  ?>
</div>
<div class="album-results">
  <h2 class="album-results-title">Albums</h2>
  <div class='albums'>
    <?php

      $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '%$term%' ORDER BY title DESC LIMIT 10");

      if (mysqli_num_rows($albumQuery) === 0) {
        echo "<span class='no-results'>No album titles containing <i>{$term}</i></span>";
      }

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
</div>
<!-- popup menu for each track -->
<nav class="options-menu">
  <input type="hidden" class="song-id">
  <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</div>
