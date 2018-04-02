<?php
  class Account {
    private $con;
    private $errorArray;

    public function __construct($con) {
      $this->con = $con;
      $this->errorArray = array();
    }

    public function login($un, $pw) {
      $pw = md5($pw);

      $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

      if (mysqli_num_rows($query) == 1) {
        return true;
      } else {
        array_push($this->errorArray, Constants::$loginFailed);
        return false;
      }
    }

    public function register($un, $fn, $ln, $em, $emConfirm, $pw, $pwConfirm) {
      $this->validateUsername($un);
      $this->validateFirstName($fn);
      $this->validateLastName($ln);
      $this->validateEmails($em, $emConfirm);
      $this->validatePassword($pw, $pwConfirm);

      if (empty($this->errorArray)) {
        // insert user information into database
        return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
      } else {
        return false;
      }
    }

    public function getError($error) {
      if (!in_array($error, $this->errorArray)) {
        $error = "";
      }
      return "<span class='errorMsg'>$error</span>";
    }

    private function insertUserDetails($un, $fn, $ln, $em, $pw) {
      // encrypts password
      $encryptedPw = md5($pw);
      $date = date("Y-m-d");
      $profilePic = "assets/images/profile-pics/user.png";

      $result = mysqli_query($this->con, "INSERT INTO users VALUES('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

      return $result;
    }

    private function validateUsername($un) {
      // checks username length
      if (strlen($un) > 25 || strlen($un) < 5) {
        array_push($this->errorArray, Constants::$usernameLength);
        return;
      }

      $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
      if (mysqli_num_rows($checkUsernameQuery) != 0) {
        array_push($this->errorArray, Constants::$usernameTaken);
      }
    }

    private function validateFirstName($fn) {
      // checks first name length
      if (strlen($fn) > 25 || strlen($fn) < 2) {
        array_push($this->errorArray, Constants::$firstNameLength);
        return;
      }
    }

    private function validateLastName($ln) {
      // checks last name length
      if (strlen($ln) > 25 || strlen($ln) < 2) {
        array_push($this->errorArray, Constants::$lastNameLength);
        return;
      }
    }

    private function validateEmails($em, $emConfirm) {
      // checks if the email is valid
      if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$emailInvalid);
        return;
      }

      // checks if both emails match
      if ($em != $emConfirm) {
        array_push($this->errorArray, Constants::$emailsDontMatch);
        return;
      }

      $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
      if (mysqli_num_rows($checkEmailQuery) != 0) {
        array_push($this->errorArray, Constants::$emailTaken);
      }
    }

    private function validatePassword($pw, $pwConfirm) {
      // checks if password contains only letters and numbers
      if (preg_match("/[^A-Za-z0-9]/", $pw)) {
        array_push($this->errorArray, Constants::$pwInvalid);
        return;
      }

      // checks password length
      if (strlen($pw) > 30 || strlen($pw) < 8) {
        array_push($this->errorArray, Constants::$pwLength);
        return;
      }

      // checks if both passwords match
      if ($pw != $pwConfirm) {
        array_push($this->errorArray, Constants::$pwsDontMatch);
        return;
      }
    }
  }
?>
