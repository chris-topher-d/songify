<?php
  require("includes/config.php");
  require("includes/classes/Account.php");
  require("includes/classes/Constants.php");
  $account = new Account($con);

  require("includes/handlers/register-handler.php");
  require("includes/handlers/login-handler.php");

  function getInputValue($name) {
    if (isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login/Register</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/register.js"></script>
  </head>
  <body>

    <?php
      if (isset($_POST['regButton'])) {
        echo '<script type="text/javascript">
                $(document).ready(function() {
                  $(".returningUser").hide();
                  $(".newUser").show();
                });
              </script>';
      }
    ?>

    <div class='container'>
      <div class='info'>
        <div class="returningUser">
          <form class="login" action="register.php" method="post">
            <h2>Sign in to your account</h2>
            <p>
              <?php echo $account->getError(Constants::$loginFailed); ?>
              <label for="loginUsername">Username</label>
              <input class="loginUsername" type="text" name="loginUsername" placeholder="Your username" value="<?php getInputValue('loginUsername'); ?>" required>
            </p>
            <p>
              <label for="loginPassword">Password</label>
              <input class="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
            </p>
            <button type="submit" name="loginButton">Log In</button>
            <div class="newAccount">
              <span id="hideLogin">Don't have an account? Sign up here.</span>
            </div>
          </form>
        </div>

        <div class="newUser">
          <form class="register" action="register.php" method="post">
            <h2>Create your free account</h2>
            <p>
              <?php echo $account->getError(Constants::$usernameLength); ?>
              <?php echo $account->getError(Constants::$usernameTaken); ?>
              <label for="username">Username</label>
              <input class="username" type="text" name="username" placeholder="Your username" value="<?php getInputValue('username'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$firstNameLength); ?>
              <label for="firstName">First Name</label>
              <input class="firstName" type="text" name="firstName" placeholder="Your first name" value="<?php getInputValue('firstName'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$lastNameLength); ?>
              <label for="lastName">Last Name</label>
              <input class="lastName" type="text" name="lastName" placeholder="Your last name" value="<?php getInputValue('lastName'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$emailInvalid); ?>
              <?php echo $account->getError(Constants::$emailsDontMatch); ?>
              <?php echo $account->getError(Constants::$emailTaken); ?>
              <label for="email">Email</label>
              <input class="email" type="email" name="email" placeholder="e.g. you@gmail.com" value="<?php getInputValue('email'); ?>" required>
            </p>
            <p>
              <label for="emailConfirm">Confirm Email Address</label>
              <input class="emailConfirm" type="email" name="emailConfirm" placeholder="e.g. you@gmail.com" value="<?php getInputValue('emailConfirm'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$pwInvalid); ?>
              <?php echo $account->getError(Constants::$pwLength); ?>
              <?php echo $account->getError(Constants::$pwsDontMatch); ?>
              <label for="password">Password</label>
              <input class="password" type="password" name="password" placeholder="Your Password" required>
            </p>
            <p>
              <label for="passwordConfirm">Confirm Password</label>
              <input class="passwordConfirm" type="password" name="passwordConfirm" placeholder="Your Password" required>
            </p>
            <button type="submit" name="regButton">Sign Up</button>
            <div class="newAccount">
              <span id="hideRegister">Already have an account? Log in here.</span>
            </div>
          </form>
        </div>
        <div class='loginText'>
          <h1>Your music right now</h1>
          <h2>Stream your favorite tunes for free</h2>
          <ul>
            <li><i class="fas fa-check"></i>Discover music you'll fall in love with</li>
            <li><i class="fas fa-check"></i>Create your own playlists</li>
            <li><i class="fas fa-check"></i>Follow artists to keep up to date</li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
