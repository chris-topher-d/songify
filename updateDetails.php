<?php include("includes/includedFiles.php");

?>

<div class="user-details">
  <div class="details-container bottom-border">
    <h2>Email</h2>
    <input type='text' class="email" name='email' placeholder="Email address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
    <span class="message"></span>
    <button class="button" onClick="updateEmail('email')">SAVE</button>
  </div>
  <div class="details-container">
    <h2>Password</h2>
    <input type='password' class="old-password" name='old-password' placeholder="Current password">
    <input type='password' class="new-password" name='new-password' placeholder="New password">
    <input type='password' class="verify-password" name='verify-password' placeholder="Verify password">
    <span class="message"></span>
    <button class="button" onClick="updatePassword('old-password', 'new-password', 'verify-password')">UPDATE</button>
  </div>
</div>
