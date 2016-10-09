<?php
//start session
session_start();
//gets functions
require("../includes/functions.php");

//checks the user is logged
if(isset($_SESSION['userID'])){

  //checks whether any data
  if(empty($_POST)){
    //displays the post form
    render("postForm.php", array('title' => "Post" ));
    }else{
      //create an empty list
      $post = [];
      //gets the data posted to the server and then sanitizes it
      $post['subject'] = filter_var($_POST['subject'], FILTER_SANITIZE_NUMBER_INT);
      $post['level'] = filter_var($_POST['level'], FILTER_SANITIZE_NUMBER_INT);
      $post['question'] = filter_var($_POST['post'], FILTER_SANITIZE_STRING);
      $post['questionTitle'] = filter_var($_POST['questionTitle'], FILTER_SANITIZE_STRING);

      $postValid = [];

      //connects to the database
      $conn = databaseConn();

      //gets the length 0f string
      $postLength = strlen($post['question']);
      //gets whether it is between 40 and 500
      $postValid['post'] =  $postLength >= 40 && $post['question'] <= 5000;

      //gets the string length
      $titleLength  = strlen($post['questionTitle']);
      //gets whether the string is between 15 and 70
      $postValid['questionTitle'] = $titleLength >= 15 && $titleLength <= 70;

      //checks post is valid
      if(!in_array(false, $postValid)){
        try{
          //starts transaction
          $conn->beginTransaction();
          //Inserts question details into DB
          query("INSERT INTO `questioninfo` (userID, subjectID, levelID, questiontitle) VALUES(:userID, :subjectID, :levelID, :questiontitle);", array("userID"=>$_SESSION['userID'], "subjectID"=>$post['subject'], "levelID"=>$post['level'], "questiontitle"=>$post['questionTitle']), false, $conn);
          //Inserts question text into DB
          query("INSERT INTO `questions` (questionID, question) VALUES (LAST_INSERT_ID(), :question);", array('question'=>$post['question']), false, $conn);
          //ends transactions
          $conn->commit();
          //kills connection with DB
          $conn = null;

        }catch(Exception $errorObject){
          $conn = null;
          render("error.php", array('title'=>'Something went wrong'));
          //checks failure wasn't  due to user inseting subject and levels that don't exist in DB
          if(!($errorObject->getCode() == 1452)){
            logError($errObject);
          }
          //stops execution
          die;
        }
        //Redirects to homepage
        redirect("homepage.php");
      }else{
        //Goes through each element in array
        foreach ($postValid as $key => $value){
          //checks current value
          if($value){
            //removes the value from the post valid array
            unset($postValid[$key]);
          }else{
            //removes current element from array
            unset($post[$key]);
          }
        }
        //display post form
        render("postForm.php", array("notVaild"=>$postValid, "post"=>$post, "title"=>"Post"));
      }
    }
  }else{
    redirect("homepage.php");
  }
 ?>
