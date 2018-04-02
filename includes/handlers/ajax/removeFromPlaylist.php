<?php include("../../config.php");

  if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $orderIdQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlist_order) + 1, 1) as playlist_order FROM playlist_songs WHERE playlist_id='$playlistId'");
    $row = mysqli_fetch_array($orderIdQuery);
    $order = $row['playlist_order'];

    $query = mysqli_query($con, "INSERT INTO playlist_songs VALUES('', '$songId', '$playlistId', '$order')");
  } else {
    echo "PlaylistId or songId was not passed into addToPlaylist.php";
  }

?>
