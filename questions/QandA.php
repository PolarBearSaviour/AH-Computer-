<?php
  session_start();
  //Gets the functons from functions.php
  require("../includes/functions.php");

  try{
      //Get the questionID from the URL and  sanitizes
      $questionID = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_NUMBER_INT);
      //Checks that the sanitized questionID has a value
      if(!empty($questionID)){
        //connects to the database
        $conn = databaseConn();

        //Checks that data was sent via the post method
        if(!empty($_POST)){

          //Check if the answer form was submitted
          if(isset($_POST['answer'])){
            //sanitizes the answer that was sent
            $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);

            if(!empty($answer)){
              //starts transaction
              $conn->beginTransaction();
              //Inserts details of answer into DB
              query("INSERT INTO answerinfo (userID, questionID) VALUES (:userID, :questionID)", array("userID"=>$_SESSION['userID'], "questionID"=>$questionID), false, $conn);
              //Inserts the answer into the answer table
              query("INSERT INTO answer (answerID ,answer) VALUES (LAST_INSERT_ID() ,:answer)", array("answer"=>$answer), false, $conn);
              //end of transaction
              $conn->commit();
            }
          }

          //Checks if the answerCorrect input tag was submitted
          if(isset($_POST['answerCorrect'])){
            //Gets the ownerID of the question
            $ownerID = query("SELECT userID FROM questionInfo WHERE questionID =:ID", array("ID"=>$questionID), true, $conn);
            //checks whether current user matches the owner
            if($_SESSION['userID'] == $ownerID[0]['userID']){
              //sanitizes the answerID
              $answerID = filter_var($_POST['answerCorrect'], FILTER_SANITIZE_NUMBER_INT);

              if(!empty($answerID)){
                //Queries the answerright table for correct answers that match the answer ID
                $answerRight = query("SELECT answerright FROM answerright WHERE answerID = :ID", array("ID"=>$answerID), true, $conn);

                if(empty($answerRight)){
                  //Adds the answer to table of right answers
                  query("INSERT INTO answerright (answerID, answerright) VALUES (:ID, true)", array("ID"=>$answerID), false, $conn);
                }else{
                  //Answer is removed from the answerright table
                  query("DELETE FROM answerright WHERE answerID =:ID", array("ID"=>$answerID), false, $conn);
                }
              }
            }
          }

          //checks if answerEdit input was submitted
          if(isset($_POST['answerEdit'])){

            $answerID = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

            if(!empty($answerID)){
              //gets userID of owner
              $ownerID = query("SELECT userID FROM answerinfo WHERE answerID = :ID", array("ID"=>$answerID), true, $conn);

              if($_SESSION['userID'] == $ownerID[0]['userID']){
                //Sanitizes the answer that was submitted
                $answer = filter_var($_POST['answerEdit'], FILTER_SANITIZE_STRING);

                if(!empty($answer)){
                  //Updates the answers text in the answer table in the DB
                  query("UPDATE answer SET answer = :ans WHERE answerID =  :ID", array("ans"=>$answer, "ID"=>$answerID), false, $conn);
                }
              }
            }
          }

          //Checks whether the delete input has been submitted
          if(isset($_POST['delete'])){

            $answerID = filter_var($_POST['delete'], FILTER_SANITIZE_STRING);
            if(!empty($answerID)){

              $ownerID = query("SELECT userID FROM answerinfo WHERE answerID = :ID", array("ID"=>$answerID), true, $conn);
              if($ownerID[0]['userID'] == $_SESSION['userID']){
                //Deletes the answer from the answerinfo table
                query("DELETE FROM answerinfo WHERE answerID = :ID", array("ID"=>$answerID), false, $conn);
              }
            }
          }
          //sends the user back to the QandP page (avoids the page asking for form resubmission)
          redirect("QandA.php?$questionID");
        }
        //Gets details of question from
        $questionInfo = query("SELECT `users`.userID, username, questionTitle, question, level, subject FROM questions, questioninfo, level, subject, users WHERE `questioninfo`.questionID = :ID AND `questionInfo`.subjectID = `subject`.subjectID AND `questionInfo`.levelID = `level`.levelID AND `questioninfo`.userID = `users`.userID AND `questioninfo`.questionID = `questions`.questionID", array("ID"=>$questionID), true, $conn);
        //Gets right answer from DB
        $correctAnswer = query("SELECT username, `users`.userID, answer, `answerinfo`.answerID FROM users, answer, answerinfo LEFT JOIN answerright ON `answerinfo`.answerID = `answerright`.answerID WHERE `answerinfo`.questionID = :ID AND `answerinfo`.answerID = `answer`.answerID AND `answerinfo`.userID = `users`.userID AND answerright IS NOT NULL ORDER BY answerTimestamp ASC", array("ID"=>$questionID), true, $conn);
        //Gets unmarked answer from DB
        $answers = query("SELECT username, `users`.userID, answer, `answerinfo`.answerID FROM users, answer, answerinfo LEFT JOIN answerright ON `answerinfo`.answerID = `answerright`.answerID WHERE `answerinfo`.questionID = :ID AND `answerinfo`.answerID = `answer`.answerID AND `answerinfo`.userID = `users`.userID AND answerright IS NULL ORDER BY answerTimestamp ASC", array("ID"=>$questionID), true, $conn);
        //Dispays the answerPage and passes the correct data
        render("answerPage.php", array("questionInfo" =>$questionInfo, "answerCorrect"=> $correctAnswer, "answers"=>$answers, "title"=>"Q and A"));
      }else{
        //redirect homepage
        redirect("homepage.php");
      }

  }catch (Exception $e){
    //displays the error page
    render("error.php", array("title"=>"something went wrong"));
    //logs error
    logError($e);
  }
?>
