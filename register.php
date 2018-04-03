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
    <link rel="shortcut icon" href="favicon_headphones.png">
    <title>Login/Register</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/solid.js" integrity="sha384-P4tSluxIpPk9wNy8WSD8wJDvA8YZIkC6AQ+BfAFLXcUZIPQGu4Ifv4Kqq+i2XzrM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/regular.js" integrity="sha384-BazKgf1FxrIbS1eyw7mhcLSSSD1IOsynTzzleWArWaBKoA8jItTB5QR+40+4tJT1" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/fontawesome.js" integrity="sha384-2IUdwouOFWauLdwTuAyHeMMRFfeyy4vqYNjodih+28v2ReC+8j+sLF9cK339k5hY" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/register.js"></script>
  </head>
  <body>

    <?php
      if (isset($_POST['regButton'])) {
        echo '<script type="text/javascript">
                $(document).ready(function() {
                  $(".returning-user").hide();
                  $(".new-user").show();
                });
              </script>';
      }
    ?>

    <div class='container'>
      <div class='info'>
        <div class="returning-user">
          <form class="login" action="register.php" method="post">
            <h2>Sign in to your account</h2>
            <p>
              <?php echo $account->getError(Constants::$loginFailed); ?>
              <input class="loginUsername" type="text" name="loginUsername" placeholder="Username" value="<?php getInputValue('loginUsername'); ?>" required>
            </p>
            <p>
              <input class="loginPassword" type="password" name="loginPassword" placeholder="Password" required>
            </p>
            <button type="submit" name="loginButton">Log In</button>
            <div class="new-account">
              <span id="hide-login">Don't have an account? Sign up here.</span>
            </div>
          </form>
        </div>

        <div class="new-user">
          <form class="register" action="register.php" method="post">
            <h2>Create your free account</h2>
            <p>
              <?php echo $account->getError(Constants::$usernameLength); ?>
              <?php echo $account->getError(Constants::$usernameTaken); ?>
              <input class="username" type="text" name="username" placeholder="Enter username" value="<?php getInputValue('username'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$firstNameLength); ?>
              <input class="firstName" type="text" name="firstName" placeholder="Your first name" value="<?php getInputValue('firstName'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$lastNameLength); ?>
              <input class="lastName" type="text" name="lastName" placeholder="Your last name" value="<?php getInputValue('lastName'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$emailInvalid); ?>
              <?php echo $account->getError(Constants::$emailsDontMatch); ?>
              <?php echo $account->getError(Constants::$emailTaken); ?>
              <input class="email" type="email" name="email" placeholder="Your email address" value="<?php getInputValue('email'); ?>" required>
            </p>
            <p>
              <input class="emailConfirm" type="email" name="emailConfirm" placeholder="Confirm email address" value="<?php getInputValue('emailConfirm'); ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$pwInvalid); ?>
              <?php echo $account->getError(Constants::$pwLength); ?>
              <?php echo $account->getError(Constants::$pwsDontMatch); ?>
              <input class="password" type="password" name="password" placeholder="Your password" required>
            </p>
            <p>
              <input class="passwordConfirm" type="password" name="passwordConfirm" placeholder="Confirm password" required>
            </p>
            <button type="submit" name="regButton">Sign Up</button>
            <div class="new-account">
              <span id="hide-register">Already have an account? Log in here.</span>
            </div>
          </form>
        </div>
        <div class='login-text'>
          <div class="logo-name">
            <i class="fas fa-headphones"></i>
            <h1>Songify</h1>
          </div>
          <h2>Stream your favorite music for free</h2>
          <ul>
            <li><i class="fas fa-check"></i>Discover new music</li>
            <li><i class="fas fa-check"></i>Create your own playlists</li>
            <li><i class="fas fa-check"></i>Follow artists</li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
