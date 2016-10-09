<?php
//starts session in script
session_start();
//Gets all the php functions from functions.php
require("../includes/functions.php");

try{
  //checks user is logged in
  if(isset($_SESSION['userID'])){
    //connects to the database
    $conn = databaseConn();
    //Gets the username from the database
    $username = query("SELECT username FROM users WHERE userID = :userID", array("userID"=>$_SESSION['userID']), true, $conn);
    //checks whether any data was posted to the server
    if(!empty($_POST)){
      //checks whether the passwordChange input was submitted
      if(isset($_POST['passwordChange'])){
        //sanitizes the inputs from the HTML form
        $password = filter_var($_POST['currentPassword'], FILTER_SANITIZE_STRING);
        $newPassword = filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING);
        $newPasswordConfirm = filter_var($_POST['newPasswordConfirm'], FILTER_SANITIZE_STRING);

          //Gets an array containing what elements of the password are right and wrong
          $passwordValid = checkPassword($newPassword, $newPasswordConfirm, $username[0]['username']);

          //checks for false in array
          if(in_array(false, $passwordValid)){
            //Goes through each element in the array
            foreach($passwordValid as $key => $value){
              //checks whether the current element is true
              if($value){
                //removes element from array
                unset($passwordValid[$key]);
              }
            }
            //Displays the settings page (alerting them to their mistakes with their new password)
            render("settings.php", array("title"=>"settings", "passwordValid"=>$passwordValid, "username"=>$username[0]['username']));
            //stops execution
            die;

          }else{
            //gets the hash from the Database
            $hash = query("SELECT hash FROM users WHERE userID = :ID", array("ID"=>$_SESSION['userID']), true, $conn);
            //checks password is valid
            if(password_verify($password, $hash[0]['hash'])){
              //hashes new password
              $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
              //updates hash in the database
              query("UPDATE users SET hash = :newHash WHERE userID =:ID", array("newHash"=>$newHash, "ID"=>$_SESSION['userID']), false, $conn);
              render("settings.php", array("title"=>"settings", "passwordChanged" => True, "username" => $username[0]['username']));
              die;
            }else{
              //Display the setting page (alerting them to the mistake with their password)
              render("settings.php", array("title"=>"settings", "passwordWrong"=>true, "username"=>$username[0]['username']));
              die;
            }

          }

      }
      //checks to whether the deleteAccount input was submitted
      if(isset($_POST['deleteAccount'])){

        $password = filter_var($_POST['deleteAccount'], FILTER_SANITIZE_STRING);
        //checks it's not empty
        if(!empty($password)){
          //connects to the database
          $conn = databaseConn();
          //Gets the hash from the database
          $hash = query("SELECT hash FROM users WHERE userID = :ID", array("ID"=>$_SESSION['userID']), true, $conn);
          //check the hash from the database and the password submitted by the user match
          if(password_verify($password, $hash[0]['hash'])){
            //logs out user
            session_destroy();
            //Deletes the user's account
            query("DELETE FROM users WHERE userID =:ID", array("ID"=>$_SESSION['userID']), false, $conn);
            //send the user to the hompage
            redirect("homepage.php");
          }else{
            //Displays the setting page informing the user that the password is wrong
            render("settings.php", array("title"=>"setting", "passwordInvalid"=> true));
            
            die;
          }
        }
      }

    }
      render("settings.php", array("title"=>"settings", "username"=>$username[0]['username']));
  }else{
    //sends the user back to the hompage
    redirect("homepage.php");
  }

}catch (exception $errors){
  //logs error
  logError($errors);
  render("error.php", array("title"=>"settings"));
}
 ?>
