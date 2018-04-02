<?php

  require("../../config.php");

  if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];
    $songQuery = mysqli_query($con, "SELECT * FROM songs WHERE id={$songId}");

    $resultArray = mysqli_fetch_array($songQuery);
    echo json_encode($resultArray);
  }

?>
