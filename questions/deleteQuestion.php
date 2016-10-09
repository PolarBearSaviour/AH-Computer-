<?php
//starts session
session_start();
//gets the functions in functions.php
require("../includes/functions.php");
//attempts to run the code
try{
  //checks the user is logged in
  if(isset($_SESSION['userID'])){
    //gets the questionID from the URL and then sanitizes it
    $questionID = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_STRING);
    //checks the questionID has a value (ie it's clean)
    if(!empty($questionID)){
      //connects to DB
      $conn = databaseConn();
      //gets the userID of the user that owns the question
      $ownerID = query("SELECT userID FROM questioninfo WHERE questionID = :ID", array("ID"=>$questionID), true, $conn);
      //checks that the user currently logged in matches the user who poasted the question
      if($ownerID[0]['userID'] == $_SESSION['userID']){
        //Deletes the question from DB and redirects to homepage
        query("DELETE FROM questioninfo WHERE questionID = :ID", array("ID"=>$questionID), false, $conn);
      }

    }
  }
    //redirects to the hompeage
    redirect("homepage.php");

//catches any exception thrown
}catch(exception $errors){
  //loggs the exception and display error page
  logError($errors);
  render("error.php", array("title"=>"Something went wrong"));
}

 ?>
