
<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
$account = new Account($conn);

if(isset($_POST['submit'])){

    $fn = FormSanitizer::sanitizeFormString($_POST['firstname']);
    $ln = FormSanitizer::sanitizeFormString($_POST['lastname']);
    $un = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $em = FormSanitizer::sanitizeFormEmail($_POST['email']);
    $em2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
    $pw = FormSanitizer::sanitizeFormPassword($_POST['password']);
    $pw2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

    // $account->validateFirstName($fn); changed-- gonna call this from register class
    // $account->validateLastName($ln);
    $success = $account->register($fn, $ln, $un, $em, $em2, $pw, $pw2);
    if($success){
      // Store session
      $_SESSION["userLogged"] = $username;
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
    <title>Welcome To The Register Page</title>
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

          <?php echo $account->getError(Constants::$firstNameCharacters); ?>
          <input type="text" name="firstname" placeholder="First Name" value ="<?php getInputValue("firstname"); ?>" required/>

          <?php echo $account->getError(Constants::$lastNameCharacters); ?>
          <input type="text" name="lastname"  placeholder="Last Name" value = "<?php getInputValue("lastname"); ?>" required>

          <?php echo $account->getError(Constants::$userNameCharacters); ?>
          <?php echo $account->getError(Constants::$userNameTaken); ?>
          <input type="text" name="username"  placeholder="Username"  value = "<?php getInputValue("username"); ?>" required>

          <?php echo $account->getError(Constants::$emailDontMatch); ?>
          <?php echo $account->getError(Constants::$emailInvalid); ?>
          <?php echo $account->getError(Constants::$emailTaken); ?>
          <input type="email" name="email"  placeholder="Email" value = "<?php getInputValue("email"); ?>" required>
          <input type="email" name="email2"  placeholder="Confirm Email" value = " <?php getInputValue("email2"); ?>" required>

          <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
          <?php echo $account->getError(Constants::$passwordLength); ?>
          <input type="password" name="password" placeholder="Password" required>
          <input type="password" name="password2" placeholder="Confirm Password" required >
          <input type="submit" name="submit" value="REGISTER">

        </form>
        <a href="login.php" class="signInMessage"> Already Have an account? Sign in here!</a>

      </div>

    </div>

  </body>
</html>
