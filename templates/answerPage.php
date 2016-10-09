<?php function answerPanels($answer, $questionInfo, $IDOffset, $rightAnswer){ ?>
  <?php //checks if there is any answers ?>
  <?php if(isset($answer)): ?>
   <?php //loops around each answer in the array ?>
   <?php for ($i = 0; $i < sizeof($answer); $i++): ?>
     <?php //create localID so the pannels can be distingushed by the hideElement function ?>
     <?php $localID = $IDOffset.strval($i); ?>
     <div class="row">
       <div class="col-md-2"></div>
       <div class="col-md-7">
         <?php //Checks whether the answer is right or not ?>
         <div <?=($rightAnswer) ? "class='panel panel-success'":"class='panel panel-default'"?> id=<?=$localID?>>
           <div class="panel-heading">
             <p>By <?=$answer[$i]['username']?></p>
           </div>

           <div class="panel-body">
             <p style="white-space:pre-wrap; word-wrap:break-word;"><?=$answer[$i]['answer']?></p>
             <?php //checks the user is logged in ?>
             <?php if(isset($_SESSION['userID'])): ?>
               <?php //checks user logged in matches the user who owns the question ?>
               <?php if($_SESSION['userID'] == $questionInfo[0]['userID']): ?>
               <form id="answerRight" action="QandA.php" method="post" onsubmit="return editAction(this);">
                 <button type="submit" name="answerCorrect" value=<?=$answer[$i]['answerID']?> class="btn btn-secondary btn-sm pull-right pull-right">
                   <span <?=($rightAnswer) ? 'class="glyphicon glyphicon-remove" style="color:red"': 'class="glyphicon glyphicon-ok" style="color:green"'?>></span>
                 </button>
               </form>
             <?php endif; ?>
           <?php endif; ?>
           </div>


           <?php if(isset($_SESSION['userID'])): ?>
             <?php //checks whether the user is logged is the user who posted the question ?>
             <?php if($_SESSION['userID'] == $answer[$i]['userID']): ?>
               <div class="panel-footer clearfix">
                   <form action="QandA.php" method="post" onsubmit="return editAction(this)">
                     <button type="button" class = "btn btn-secondary btn-sm" name="edit" onclick="hideElement(<?="'".$localID."'"?>, <?=$answer[$i]['answerID']?>)" value=<?=("'".$answer[$i]['answerID']."'"); ?>>Edit</button>
                     <button type="submit" class="btn btn-danger btn-sm" name="delete" value="<?=$answer[$i]['answerID']?>">Delete</button>
                   </form>
               </div>
             <?php endif; ?>
         <?php endif; ?>
       </div>

        <?php
        /*
        It should be noted the reason for running the same checks twice
        is because the form needs to be in a different div to the text of the answer.
        This means the JS functon hideElement can hide one and show the other,
        if they were in the same div this wouldn't be possible. And having one check run over the two divs
        caused the the page not render properly when the user wasn't logged in so basically this was the easiest
        fixed (the structure of this HTML needs to be improved at some point in a later version...)
        */
         ?>
         <?php if(isset($_SESSION['userID'])): ?>
           <?php //checks the user owns the answer ?>
           <?php if($_SESSION['userID'] == $answer[$i]['userID']): ?>
             <?php //gives the HTML form the answer ID  ?>
             <form id=<?=("'".$answer[$i]['answerID']."'")?> class="form" action="QandA.php" method="post" onsubmit="return editAction(this)" hidden="hidden">
               <?php //prints off the answer into the text box ?>
               <textarea name="answerEdit" rows="8" cols="40" required="true" class="form-control"><?=$answer[$i]['answer']?></textarea>
               <?php //sets up parameters for the hideElement function ?>
               <button type="button" name="cancel" onclick="hideElement(<?=$answer[$i]['answerID']?>,<?="'".$localID."'"?>)" class="btn btn-secondary btn-sm">Cancel</button>
               <?php //gives the submit button the value of the answer ID ?>
               <button type="submit" name="id" class="btn btn-primary btn-sm" value="<?=$answer[$i]['answerID']?>">Submit</button>
             </form>
           <?php endif; ?>
        <?php endif; ?>


       </div>
     </div>
   <?php endfor; ?>
  <?php endif; ?>
<?php } ?>



<?php //Gets the Javascript required for the webpage ?>
<script src='JS/answerPage.js' charset='utf-8'></script>
 <body>
   <div class="container">
     <div class="row">
       <div class="col-md-2"></div>
       <div class="col-md-7">
         <?php //the php code prints out the question title into the HTML ?>
          <h3 class="page-header" id="title"><?=$questionInfo[0]['questionTitle']?></h3>
       </div>
       <div class="col-md-3">
         <br>
         <br>
         <?php //prints out the username intot the username ?>
         <p>by <?=$questionInfo[0]['username']?></p>
         <label for="subject">Subject:</label>
         <?php //prints out subject of question ?>
         <p id="subject"><?=$questionInfo[0]['subject']?></p>
       </div>
       </div>

       <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-7">
           <div class="panel panel-default">
             <div class="panel-body">
              <?php //inserts the question into HTML ?>
              <p id="question" style="white-space:pre-wrap; word-wrap:break-word;"><?=$questionInfo[0]['question']; ?></p>
              <?php //checks wether te user is logged in ?>
               <?php if(isset($_SESSION['userID'])): ?>
                 <?php //checks whether the user who is currently logged is the owner of the question ?>
                 <?php if($_SESSION['userID'] == $questionInfo[0]['userID']): ?>
                     <span><button type="button" name="button" class="btn btn-secondary btn-sm pull-right" id="edit" onclick="createLink()">Edit question</button></span>
                     <span><button type="button" name="button" class="btn btn-secondary btn-sm pull-right" onclick="showDialouge()">Delete</button></span>
                 <?php endif; ?>
               <?php endif; ?>
             </div>
           </div>
         </div>
         <br>
         <div class="col-md-3">
           <label class="pull-left" for="level">Level:</label>
           <?php //Displays level of subject ?>
           <p id="level"><?=$questionInfo[0]['level']?></p>
         </div>
       </div>


    <?php answerPanels($answerCorrect, $questionInfo, "A", true); ?>
    <?php answerPanels($answers, $questionInfo, "B", false); ?>

    <?php //checks user is logged in  ?>
    <?php if(isset($_SESSION['userID'])): ?>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
          <form id="answer" class="form" action="QandA.php" method="post" onclick="return editAction(this);">
            <label for="answer">Answer:</label>
            <textarea name="answer" class="form-control" rows="4" cols="40" maxlength="5000" minlength="10" required="true"></textarea>
            <button type="submit" class="btn btn-primary btn-sm pull-right">Reply</button>
          </form>
        </div>
      </div>
    <?php endif; ?>


    <div id="deleteDialouge" class="modal fade center" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title text-danger">Deleting question</h3>
          </div>
          <div class="modal-body">
            <p>Do you really want to delete the question?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" onclick="link()">yes</button>
          </div>
        </div>
      </div>
    </div>
    </div>
