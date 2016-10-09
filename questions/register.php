<?php
//starts session
session_start();
//gets functions
require("../includes/functions.php");

//check whether anything was sent to server
if(empty($_POST)){
  //Displays register form
  render("registerForm.php", array("title" => 'Register'));

}else{
  //Gets the values sent via post from the user and sanitizes them
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  $passwordConfirm = filter_var($_POST['passwordConfirm'], FILTER_SANITIZE_STRING);

  //Gets whether the password meet the requirements
  $passwordCheck = checkPassword($password, $passwordConfirm, $username);
  //checks whether the password meets all the requirements
  if(!in_array(false, $passwordCheck)){

    //Attempts to enter username and has into DB
    try{
      //connects to database
      $conn = databaseConn();
      //hashes the password
      $hash = password_hash($password, PASSWORD_DEFAULT);
      //Insert the username, hash into the database
      query("INSERT INTO users (username, hash) VALUES (:username,:hash);", array('username'=>$username, 'hash'=> $hash), False, $conn);
      //kills the connection with the database
      $conn = null;
      //send the user to the login page
      redirect("login.php");

    //catches the exception thrown by DB
    }catch (Exception $e){
      $conn = null;
      //checks whether the username already exists
      if($e->getCode() == 23000){

        //register page informs user that the username was taken
        render("registerForm.php", array('title' => 'Register', 'usernameTaken' => True));

      }else{
        //logs error and displays error page
        logError($e);
        render("error.php", array('title' => 'something went wrong!'));
      }
    }
  }else{
      //goes through each element in the array passwordCheck
      foreach ($passwordCheck as $key => $value) {
        //checks whether value of current element is true
        if($value){
          //removes element from array
          unset($passwordCheck[$key]);
        }
      }

      $conn = null;
      //Display the register form (with errors)
      render("registerForm.php", array('title' => 'Register', 'username' => $username, 'passwordCheck' => $passwordCheck));
  }
}
?>
