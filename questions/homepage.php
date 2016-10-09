<?php
  session_start();
  //gets functions
  require("../includes/functions.php");
  try{
    //connects to the database
    $conn = databaseConn();
    //checks if any data was sent to the server
    if(empty($_GET)){
      //gets question details for homepage
      $results = queryNoArguements("SELECT questionID, questionTitle, username FROM questioninfo, users WHERE `questioninfo`.`userID` = `users`.`userID` ORDER BY questionTimeStamp DESC", true, $conn);
    }else{
      //removes any HTML tags from the code
      $subjectID = filter_var($_GET['subject'], FILTER_SANITIZE_NUMBER_INT);
      $levelID = filter_var($_GET['level'], FILTER_SANITIZE_NUMBER_INT);
      //gets question details for homepage
      $results = query("SELECT questionID, questionTitle, username FROM questioninfo, users WHERE subjectID = :subject AND levelID = :level AND `questioninfo`.`userID` = `users`.`userID` ORDER BY questionTimeStamp DESC", array("subject"=>$subjectID, "level"=>$levelID), true, $conn);
    }
    //displays homepage
    render("homepage.php", array("title"=>"homepage", "questionToBeDisplayed"=>$results));
    //kills connection with DB
    $conn = null;

  }catch (Exception $e){
    //Takes error object and logs the error
    logError($e);
    //displays the error page
    render("error.php", array("title"=>"homepage"));
    //ends execution
    die;
  }



 ?>
