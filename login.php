<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account = new Account($conn); //create object of Account page to access functions

 if(isset($_POST['submit'])){

  $un = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $pw = FormSanitizer::sanitizeFormPassword($_POST['password']);

  $success = $account->login($un, $pw);
  if($success){
    // Store session
    $_SESSION["userLogged"] = $un;
    //$_SESSION["userLogged"] = $username; <-- I put this not knowing that i never defined $username, i used $un.
    //duh declare a variable before you can set it to a value;
    header("Location: index.php");
  }
}
function getInputValue($name){ //This echos the name you previously written into the username box so you dont have to repeat it
  if(isset($_POST[$name])){
    echo $_POST[$name];

  }

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="styler3.css">
  </head>
  <body>
    <div class="signIncontainer">
      <div class="column">

        <div class="header">
          <img src="garflix.png" title ="Logo" alt ="Site Logo" >
          <h3>Sign Up</h3>
          <span>to continue to GarFlix</span>


        </div>


        <form class="" action="" method="post">

          <?php echo $account->getError(Constants::$loginFailed); ?>
          <input type="text" name="username"  placeholder="Username" value ="<?php getInputValue("username"); ?>" required>
          <input type="password" name="password" placeholder="Password" required>

          <input type="submit" name="submit" value="LOGIN">

        </form>
        <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>

      </div>

    </div>

  </body>
</html>
