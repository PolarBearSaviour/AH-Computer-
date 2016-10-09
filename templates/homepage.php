    <?php //conects to the DB ?>
    <?php $conn = databaseConn(); ?>
    <?php //gets JS for page ?>
    <script type="text/javascript" src="JS/homepage.js"></script>
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-inline" action="homepage.php" method="get" onsubmit="return check()">
        <div class="col-md-4" id="highlightErrorForLevel">
            <label for="level">Level: </label>
            <select class="form-control" name="level" id="level">
              <option value="">Select a level</option>
              <?php //gets all the other options for level ?>
              <?php createLevelDropdownMenu($conn); ?>
            </select>
        </div>
        <div>
          <div class="col-md-8">
            <label for="subject" class="inline">Subject: </label>
            <select class="form-control" name="subject" id="subject">
              <option value="">Select a subject</option>
              <?php //gets all the other options for subject ?>
              <?php createSubjectDropdownMenu($conn); ?>
            </select>

            <div class="pull-right">
              <button type="submit" class="btn btn-small btn-primary">Search</button>
            </div>
          </div>
        </div>
      </form>



      <table class="table">
        <tr>
          <td>
            <h3>
              Title
            </h3>
          </td>
          <td>
            <h3>
              Users
            </h3>
          </td>
        </tr>
        <?php //goes through every question ?>
        <?php for($i = 0; $i < sizeof($questionToBeDisplayed); $i++): ?>
          <tr>
            <td>
              <?php //sets up the link for the question ?>
              <h4><a href=<?="QandA.php?".$questionToBeDisplayed[$i]['questionID'];?>><?=$questionToBeDisplayed[$i]['questionTitle'];?></a></4>
              </td>
              <td>
                <?php //displayes the user's username ?>
                <h5><?="By ".$questionToBeDisplayed[$i]['username'];?></h5>
              </td>
            </tr>
          <?php endfor; ?>
        </table>


        
  </div>
  <?php
    $errorMessage = "You need to fill out both subject and level!";
    //gets HTML template for error box
    require("../templates/errorMessage.php");
   ?>
   <?php //kills connection with DB ?>
   <?php $conn = null; ?>
