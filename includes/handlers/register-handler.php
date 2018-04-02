<?php
  function sanitizeFormUsername($inputText) {
    // formats username for database
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
  }

  function sanitizeFormString($inputText) {
    // formats input for database
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
  }

  function sanitizeFormPassword($inputText) {
    // formats password
    $inputText = strip_tags($inputText);
    return $inputText;
  }

  if (isset($_POST['regButton'])) {
    // register button was pressed
    $username = sanitizeFormUsername($_POST['username']);
    $firstName = sanitizeFormString($_POST['firstName']);
    $lastName = sanitizeFormString($_POST['lastName']);
    $email = sanitizeFormString($_POST['email']);
    $emailConfirm = sanitizeFormString($_POST['emailConfirm']);
    $password = sanitizeFormPassword($_POST['password']);
    $passwordConfirm = sanitizeFormPassword($_POST['passwordConfirm']);

    $successfulReg = $account->register($username, $firstName, $lastName, $email, $emailConfirm, $password, $passwordConfirm);

    if ($successfulReg) {
      $_SESSION['userLoggedIn'] = $username;
      header("Location: index.php");
    }
  }
?>
