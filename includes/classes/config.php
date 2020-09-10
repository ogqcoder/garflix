<?php //connect to database

ob_start(); // turns on ouptut buffering waits till php is executed before html is loaded
session_start(); //enables us to use session, saves some values until browser is closes, tells us if the user is logged in as well
date_default_timezone_set("America/New_York");



try {
  $conn = new PDO("mysql:dbname=garflix;host=localhost", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //sets error reporting


}
catch (PDOException $e){
  exit("Connection failed " . $e->getMessage());

}
 ?>
