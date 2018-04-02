<?php
  include("includes/includedFiles.php");
?>

<h2>Recommended for you</h2>
<div class='grid-container'>
  <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 4");
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
