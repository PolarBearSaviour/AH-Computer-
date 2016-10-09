<?php

function logError(Exception $e){
    //gets the date
    $date = getdate();
    //gets the error message from exception passed to it along with recording the time and date of when it occured
    $message = "Error: ".$e->getMessage(). ".Occured at: ".$date['mday'].'/'.$date['mon'].'/'.$date['year']." at time: ".$date['hours'].':'.$date['minutes']."\r\n";
    //writes the error message to error log
    error_log($message, 3, "../Error log/errorLog.txt");
  }

  //opens a connection with the SQL server for the site
  function databaseConn(){

    //Attempts to open a connection with the server
    try{

      $conn = new PDO("mysql:host=questions;dbname=sitedatabase", "root","");
      //This sets the server to throw an exception if there's an error invovling the DB
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //returns the object conntaining the connections
      return $conn;
    //if something goes wrong with connecting to the DB then the program throw an exception
    }catch(PDOExceptions $e){
        //throws new exception to be caught else where
        throw new Exception($e->getMessage(), $e->getCode(), $e);
    }

  }


  //redirects user to different pages on the site,
  function redirect($page){
    //Gets the name of the host
    $host = $_SERVER['HTTP_HOST'];
    //gets the current path name
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    //redirects to given page
    header("Location: http://$host$path/$page");
  }

  
  //queries the database without taking any arguements (for the DB that is)
  function queryNoArguements($SQL, $return, $conn){
    try{
      //Queries the database
      $statement = $conn->query($SQL);
      //checks whether any results are expected
      if($return){
        //gets the results from DB
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        //returns the result to the main script
        return $results;
      }
    //catches any issues with DB
    }catch(PDOExceptions $e){
      //throws new exception to be caught by the main script
      throw new Exception($e->getMessage(), $e->getCode(), $e);
    }
  }


  //queries the database with arguements for the DB
  function query($SQL, $arguements, $return, $conn){
      try{
        //prepares the SQL query
        $statement = $conn->prepare($SQL);
        //Adds the arguements to the SQL query and executes
        $statement->execute($arguements);
        //rchecks whether any values are to be returned
        if($return){
          //gets results from DB
          $results = $statement->fetchAll(PDO::FETCH_ASSOC);
          //returns the results to the main script
          return $results;
        }
      //catches any errors with the database
      }catch(PDOExceptions $e){
        //throw new execption to be caught by the main script
        throw new Exception($e->getMessage(), $e->getCode(), $e);
      }
  }

  //puts together all the templates to form a full webpage
  function render($templateName, $variables){
    //checks whether the template exists in the template Directory
      if(file_exists("../templates/$templateName")){
        //creates variables from an associative array (with the keys becoming the variable names and their values, the value of the new variable)
        extract($variables);
        //Gets the code the header
        require("../templates/header.php");
        //gets the code for the template
        require("../templates/$templateName");
        //gets the code for the footer
        require("../templates/footer.php");
      }else{
        //triggers an error message if the template doesn't exits
        trigger_error("File: $templateName", E_USER_ERROR);
      }
  }

  function checkPassword($password, $passwordConfirm, $username){

      //sets up an empty list
      $passwordCheck = [];
      //gets whether the password contains any of the following following characters
      $passwordCheck['uppercase'] = preg_match("/[A-Z]/", $password);
      $passwordCheck['lowercase'] = preg_match("/[a-z]/", $password);
      $passwordCheck['numberFound']= preg_match("/[0-9]/", $password);
      $passwordCheck['spaceFound'] = preg_match("/[[:space:]]/", $password);
      //gets whether the username doesn't equal the username
      $passwordCheck['passwordIsNotUsername'] = !($username == $password);
      //gets length of password
      $lengthOfPassword = strlen($password);
      //gets whether the password is between 25 and 8
      $passwordCheck['passwordIsCorrectLength'] = $lengthOfPassword >= 8 and $lengthOfPassword <= 25;
      //gets whether the password and password confirm match
      $passwordCheck['passwordsMatch'] = $password == $passwordConfirm;
      //returns passwordCheck to main script
      return $passwordCheck;

  }

  function createSubjectDropdownMenu($conn){
    //gets subjects from DB
    $subjects = queryNoArguements("SELECT * FROM subject", True ,$conn);
    //goes through each subject and creates option tag that subject
    for ($i=0; $i < sizeof($subjects); $i++){
      print("<option value=".$subjects[$i]['subjectID'].">".$subjects[$i]['subject']."</option>");
    }
  }

  function createLevelDropdownMenu($conn){
    //gets level from DB
    $level = queryNoArguements("SELECT * FROM level", True,$conn);
    //goes through each level and creates an option tag for it
    for ($i=0; $i < sizeof($level); $i++){
      print("<option value=".$level[$i]['levelID'].">".$level[$i]['level']."</option>");
    }
  }


?>
