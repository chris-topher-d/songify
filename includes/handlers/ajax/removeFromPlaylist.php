<?php include("../../config.php");

  if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $query = mysqli_query($con, "DELETE FROM playlist_songs WHERE playlist_id='$playlistId' AND song_id='$songId' LIMIT 1");

  } else {
    echo "Playlist id or songId was not passed into removeFromPlaylist.php";
    exit();
  }

?>
