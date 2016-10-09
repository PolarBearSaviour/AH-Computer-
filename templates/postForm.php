<?php //checks if the title is edit questions and gets JS for page ?>
<?php if($title == "edit question"): ?>
  <script src="JS/editPage.js" charset="utf-8"></script>
<?php endif; ?>
<?php //connects to DB ?>
<?php $conn = databaseConn(); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h1 class="page-header text-center"><?=$title?></h1>

        <p>The site uses mathjax and allows for code to be entered (providing it is entered correctly). If you are unsure how to do this then follow this link: <a href="http://meta.math.stackexchange.com/questions/5020/mathjax-basic-tutorial-and-quick-reference">Mathjax reference</a></p>
        <?php //checks whether the title is post and then embed the suitable attributes for the page ?>
        <form class="form" method="post" <?=($title == "Post") ? " action='post.php'" : "onsubmit='return check(this)' id='formStuff' action='editQuestion.php?$questionID'" ?>>

          <label for="title">title:</label>
          <?php //checks title isn't valid ?>
          <?php if(isset($notValid['title'])): ?>
            <div class="form-control has-feedback has-error">
              <input type="text" name="questionTitle" class="form-control" required="true" maxlength="100" minlength="15">
            </div>
          <?php else: ?>
            <input type="text" name="questionTitle" class="form-control" required="true" maxlength="100" minlength="15" <?=(isset($post['questionTitle'])) ? "value='".$post['questionTitle']."'":"" ?> id="title"/>
          <?php endif; ?>
          <div class="form-group-inline">
            <div class="pull-left">
              <?php //checks title is edit question ?>
                <?php if ($title == "edit question"): ?>
                  <?php //prints the current subject ?>
                  <p>Current subject: <?=$post['subject']?></p>
                <?php endif; ?>
                <select class="form-control" name="subject" <?=($title == "Post") ? 'required="true"' :'' ?> id="subject">
                  <option value=""><?=($title=="Post") ? "Select subject" : "Choose another subject if current is wrong!"?></option>
                  <?php //creates drop down menu ?>
                  <?php  createSubjectDropdownMenu($conn)  ?>
                </select>
            </div>


            <div class="pull-right">
              <?php //checks the title is edit question ?>
                <?php if ($title == "edit question"): ?>
                  <?php //prints off current level ?>
                  <p>Current level: <?=$post['level']?></p>
                <?php endif; ?>
                <select name="level" <?=($title == "Post") ? 'required="true"' :'' ?> class="form-control" id="level">
                  <option value=""><?=($title=="Post") ? "Select a level" : "Choose another level if wrong"?></option>
                  <?php //creates drop down menu ?>
                  <?php createLevelDropdownMenu($conn); ?>
                </select>
            </div>
          </div>
          <br>
          <textarea name="post" class="form-control" rows="8" cols="40" maxlength="5000" minlength="40" required="true" id="question"><?=(isset($post['question'])) ? $post['question'] : ""?></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <br>
          <button type="submit" name="button" class="btn btn-block btn-primary center-block"><?= ($title == "Post" ? "Post question":"Sumbit changes")?></button>
      </div>
    </div>
  </form>
</div>
