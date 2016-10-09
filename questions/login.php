<?php
  //starts session 
  session_start();
  //gets functions
  require("../includes/functions.php");
  //checks if any data was sent
  if(empty($_POST)){
    //displays login form
    render("loginForm.php", array("title" => "Login"));

  }else{
    //Gets the username and password from post and sanitizes them
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    //checks if remember me was set on the form
    if(!empty($_POST['rememberMe'])){
      $rememberMe = filter_var($_POST['rememberMe'], FILTER_VALIDATE_BOOLEAN);
    }


    //attempts to connect to database and query it for the loginDetails
    try{
      $conn = databaseConn();
      $loginDetails = query("SELECT `userID`, `hash` FROM users WHERE username=:username", array("username"=>$username), True, $conn);
    //catches any issues with the DB
    }catch(Exception $errorObject){
      //writes to the error log
      logError($errorObject);
      render("error.php", array("title"=>"something broke", "error"));
      // kills the script
      die();
    }


    //checks login details were returned
    if(!empty($loginDetails)){
      //checks whther the password is correct
      if(password_verify($password, $loginDetails[0]['hash'])){
        //logs user in
        $_SESSION['userID'] = $loginDetails[0]['userID'];
        //checks rememeber is is set
        if(isset($rememberMe)){

          $uniqueToken = false;
          //Loops around till token is unique
          while(!$uniqueToken){
            //attempts to insert the token generated into the DB
            try{
              $token = bin2hex(openssl_random_pseudo_bytes(50));
              query("INSERT INTO loggedin (token, userID) VALUES (:token, :userID)", array("userID" => $_SESSION['userID'], "token" => $token), false, $conn);
              //sets a cookie to last ten years (max time for cookie)
              setcookie("token", $token, time() + (10*365*24*60*60));
              $uniqueToken = True;
            //catches any problems with the query
            }catch (Exception $errorObject){
              //checks isn't dupilicate key error
              if(!($errorObject->getCode() == 2300)){
                //displays error page and stop exec
                render("error.php", array("title"=>"something went wrong"));
                die;
              }
            }

          }

        }
        //sends user to homepage
        redirect("homepage.php");
        die;
      }
    }
    render("loginForm.php", array('title'=>'Login', 'incorrectLogin'=> True));
  }


?>
