<?php
  //starts session
  session_start();
  //gets functions
  require("../includes/functions.php");

  //ends session (getting rid of all the data stored inside)
  session_destroy();

  //checks whether the user had "rememeber me" cookie
  if(isset($_COOKIE['token'])){
    //santizes cookies value
    $token = filter_var($_COOKIE['token'], FILTER_SANITIZE_STRING);
    //overwrites the cookie's token value
    setcookie("token");

    try{
      //connects to the database
      $conn = databaseConn();
      //deletes the token from the DB
      query("DELETE FROM `loggedIn` WHERE token = :token", array("token"=>$token), False, $conn);
      //kills connection
      $conn = null;


    //catches any Exceptions
    }catch(Exception $errorObject){
      //logs error
      logError($errorObject);

      $conn = null;
      //displays error page
      render("error.php", array("title"=>"something went wrong"));
    }
  }
  //sends user to homepage
  redirect("homepage.php");

?>
