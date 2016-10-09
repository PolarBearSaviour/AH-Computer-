<?php
  //start session
  session_start();
  //gets the functions from functions.php
  require("../includes/functions.php");


  //attempt to run the code
  try{

      //gets the questionID from the URL and removes anything that isn't an integer
      $questionID = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_NUMBER_INT);

      //checks the questionID has a value
      if(!empty($questionID)){
        //checks user is logged in
        if(!empty($_SESSION['userID'])){
          //connects to the database
          $conn = databaseConn();
          //gets the userID of the owner of the question
          $ownerID = query("SELECT userID FROM questionInfo WHERE questionID =:ID", array("ID"=>$questionID), true, $conn);

          //checks the user that is logged in is the owner of the question
          if($ownerID[0]['userID'] == $_SESSION['userID']){

            if(!empty($_POST)){

              //checks whether the questionTitle input was submitted
              if(!empty($_POST['questionTitle'])){
                //santizes the input
                $questionTitle = filter_var($_POST['questionTitle'], FILTER_SANITIZE_STRING);

                if(!empty($questionTitle)){
                  //checks the questionTitle meets the max and min character count
                  if(strlen($questionTitle) >= 15 and strlen($questionTitle) <= 70){
                    //updates questionTitle in database
                    query("UPDATE questioninfo SET questionTitle = :title WHERE questionID = :ID", array("title"=>$questionTitle, "ID"=>$questionID), false, $conn);
                  }
                }
              }
              //checks whether the post input was submitted
              if(!empty($_POST['post'])){

                $questionText = filter_var($_POST['post'], FILTER_SANITIZE_STRING);

                if(!empty($questionText)){
                  //checks the post meets the max and min character count
                  if(strlen($questionText) > 50 and strlen($questionText) < 5000){
                    //updates the question text in DB
                    query("UPDATE questions SET question = :questionText WHERE questionID =:ID", array("questionText"=>$questionText, "ID"=>$questionID), false, $conn);
                  }
                }
              }

              //checks whether the subject input was submitted
              if(!empty($_POST['subject'])){
                $subject = filter_var($_POST['subject'], FILTER_SANITIZE_NUMBER_INT);
                $subject = query("UPDATE questioninfo SET subjectID = :subject WHERE questionID = :ID", array("subject"=>$subject, "ID"=>$questionID), false, $conn);
              }

              //checks level input was submitted
              if(!empty($_POST['level'])){
                $level = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
                //updates level for question in DB
                query("UPDATE questioninfo SET levelID = :level WHERE questionID = :ID", array("ID"=>$questionID, "level"=>$level), false, $conn);

              }
              //sends user to the QandA page for their question
              redirect("QandA.php?$questionID");
              //stops execuation
              die;
            }else{
              //gets the question details from DB
              $questionInfo = query("SELECT questionTitle, question, level, subject FROM `questioninfo`, `questions` ,`level`, `subject` WHERE `questioninfo`.questionID = :ID AND  `questioninfo`.subjectID = `subject`.subjectID AND `questioninfo`.levelID = `level`.levelID AND `questioninfo`.questionID = `questions`.questionID", array("ID"=>$questionID), true, $conn);
              //displays edit page
              render("postForm.php", array("title"=>"edit question", "post"=>$questionInfo[0], "questionID"=>$questionID));
              //stops execuation of script
              die;
            }

          }
        }
      }
      //sends the user back to the homepage (gets rid of anyone who shouldn't be here)
      redirect("homepage.php");
  //catches any Exception in scipt
  }catch (Exception $e){
    //checks not error to do with user inserting false subject or level values
    if(!($e->getCode() == 1452)){
      //logs error
      logError($e);
    }
    //displays error page
    render("error.php", array('title' => 'Something went wrong'));
  }


 ?>
