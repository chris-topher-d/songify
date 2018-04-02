<?php

  require("../../config.php");

  if (isset($_POST['albumId'])) {
    $albumId = $_POST['albumId'];
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id={$albumId}");

    $resultArray = mysqli_fetch_array($albumQuery);
    echo json_encode($resultArray);
  }

?>
