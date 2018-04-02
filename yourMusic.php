<?php
  include("includes/includedFiles.php");
?>

<div class="playlist-container">
  <div class="grid-container">
    <h2>Your Playlists</h2>
    <div class="playlist-results">
    <?php
      $username = $userLoggedIn->getUsername();
      $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

      if (mysqli_num_rows($playlistsQuery) === 0) {
        echo "<span class='no-results'>You don't have any playlists yet.</span>";
      }

      while ($row = mysqli_fetch_array($playlistsQuery)) {
        $playlist = new Playlist($con, $row);
        echo "<div class='grid-item' role='link' tabindex='0' onClick='openPage(\"playlist.php?id={$playlist->getId()}\")'>
                <div class='playlist-image'>
                  <img src='assets/images/icons/playlist.png' alt='playlist-icon'>
                </div>
                <div class='grid-item-info'>
                  {$playlist->getName()}
                </div>
              </div>";
      }
    ?>
      <div class="add-playlist" onClick="createPlaylist('asdf')">
        <h4>ADD PLAYLIST</h4>
      </div>
    </div>
  </div>
</div>
