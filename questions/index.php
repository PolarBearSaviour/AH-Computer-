<?php
  //starts session
  session_start();
  //gets functions
  require("../includes/functions.php");

  //checks whether the user has a login token
  if(isset($_COOKIE["token"])){
    //Sanitizes (ie removes HTML) from the value stored in the cookie
    $token = filter_var($_COOKIE['token'], FILTER_SANITIZE_STRING);

    try{
      //creates a connection with the database
      $conn = databaseConn();
      //Queries the database looking for a user with that particular login token and returns their id
      $result = query("SELECT userID FROM loggedin WHERE token = :token", array('token' => $token), true, $conn);
      //checks whether an id from the DB was returned
      if(!empty($result)){
        //logs user in
        $_SESSION['userID'] = $result[0]['userID'];
      }
    //catches error with DB
    }catch (Exception $errorObject){
      //logs the exception and then displays for error page for the user
      logError($errorObject);
      render("error.php", array('title' => 'Something went wrong'));
    }

  }
    //displays homepage
    redirect("homepage.php");


?>
