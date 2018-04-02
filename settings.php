<?php include("includes/includedFiles.php"); ?>

<div class="settings-info">
  <div class="center-section">
    <div class="user-info">
      <h1><?php echo $userLoggedIn->getUsername(); ?></h1>
    </div>
  </div>
  <div class="button-items">
    <button class="button" onClick="openPage('updateDetails.php')">User details</button>
    <button class="button" onClick="logout()">Logout</button>
  </div>
</div>
