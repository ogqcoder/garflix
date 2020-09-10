<?php
//handles validation of login contents
class Account{

  private $conn;
  private $errorArray = array();

  public function __construct($conn){
    $this->conn = $conn;
  }

  public function register($fn, $ln, $un, $em, $em2, $pw, $pw2){
    $this->validateFirstName($fn);
    $this->validateLastName($ln);
    $this->validateUserName($un);
    $this->validateEmail($em,$em2);
    $this->validatePassword($pw,$pw2);

    if(empty($this->errorArray)){
      return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
    }
    return false;

  }

  public function login($un, $pw){

    $pw2 = hash("sha512", $pw);

    $query= $this->conn->prepare("SELECT * FROM users WHERE username = '$un' AND password = '$pw2'");

    $query->execute(); // executes query

    if($query->rowCount() == 1){
      return true;
    }
    array_push($this->errorArray, Constants::$loginFailed);
    return false;
  }

  private function insertUserDetails($fn, $ln, $un, $em, $pw){

    $pw = hash("sha512", $pw);
    $query= $this->conn->prepare("INSERT into users (firstname,lastname,username,email,password)
    VALUES ('$fn', '$ln', '$un', '$em', '$pw') ");

    return $query->execute();

  }

  private function validateFirstName($var){
    if (strlen($var) < 2 || strlen($var) > 25){
      array_push($this->errorArray, Constants::$firstNameCharacters);
      return;
    }
  }


  private function validateLastName($var){
    if (strlen($var) < 2 || strlen($var) > 25){
      array_push($this->errorArray, Constants::$lastNameCharacters);
      return;
    }
  }


  private function validateUserName($var){
    if (strlen($var) < 2 || strlen($var) > 25){
      array_push($this->errorArray, Constants::$userNameCharacters);
      return;
    }

    $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un");
    $query->bindValue(":un", $var);

    $query->execute();

    if($query->rowCount() != 0){
      array_push($this->errorArray, Constants::$userNameTaken);
    }
  }

  private function validateEmail($em,$em2){
    if($em != $em2){
      array_push($this->errorArray, Constants::$emailDontMatch);
    }
    if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray, Constants::$emailInvalid);
      return;
    }
    $query = $this->conn->prepare("SELECT * FROM users WHERE email=:un");
    $query->bindValue(":un", $em);

    $query->execute();

    if($query->rowCount() != 0){
      array_push($this->errorArray, Constants::$emailTaken);
    }
  }

  private function validatePassword($pw,$pw2){
    if($pw != $pw2){
      array_push($this->errorArray, Constants::$passwordsDontMatch);
      return;
    }
    if (strlen($pw) < 2 || strlen($pw2) > 25){
      array_push($this->errorArray, Constants::$passwordLength);
    }
  }

  public function getError($err){
    if(in_array($err,$this->errorArray)){
       return "<span class='errorMessage'>$err</span>";
    }
  }


}

 ?>
