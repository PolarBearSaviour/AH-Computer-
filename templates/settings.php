<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-7">
      <h1 class="page-header">Settings</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-7">
      <div class="panel panel-default">
        <div class="panel-body">
          <?php //displays username ?>
          <p>Currently logged in as: <?=($username); ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-7">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Change password</h4>
          <?php //checks whether password was changed ?>
          <?=(isset($passwordChanged)) ? "<p class='text-success'>Password was changed!</p>":"" ?>
        </div>
        <form class="form" action="settings.php" method="post">
          <div class="panel-body">
            <p>Password must:</p>
              <ul>
                <li>Have an uppercase character</li>
                <li>Have a lowercase character</li>
                <li>Have a number</li>
                <li>Be at least 8 characters and no more than 25</li>
                <li>Contain a space</li>
                <li>Password must not username</li>
                <li>Passwords must match</li>
              </ul>
              <label for="currentPassword">Password:</label>
              <?php //checks whether the password is wrong ?>
              <?php if(isset($passwordWrong)): ?>
                <div class="form-group has-feedback has-error">
                  <input type="password" name="currentPassword" class="form-control" required="true" minlength="8" maxlength="25" autofocus="true"/>
                  <p class="text-danger">Your password was wrong!</p>
                </div>
              <?php else: ?>
                <input type="password" name="currentPassword" class="form-control" required="true" minlength="8" maxlength="25" <?=(isset($passwordInvalid)) ? "":"autofocus=true"?> />
              <?php endif; ?>
              <?php //checks whether the password is valid ?>
              <?php if(isset($passwordValid)): ?>
                <div class="form-group has-feedback has-error">
                  <label for="newPassword">New password:</label>
                  <input type="password" name="newPassword" class="form-control" required="true" minlength="8" maxlength="25"/>
                  <?php //checks whether password hasn't got an uppercase letter ?>
                  <?=(isset($passwordValid['uppercase'])) ? "<p class=text-danger>Password did not have an uppercase character</p>":""?>
                  <?php //checks whether password hasn't got a lowercase letter ?>
                  <?=(isset($passwordValid['lowercase'])) ? "<p class=text-danger>Password did not have a lowercase character</p>":""?>
                  <?php //checks whether password hasn't got a number ?>
                  <?=(isset($passwordValid['numberFound'])) ? "<p class=text-danger>Password did not have a number in it</p>":""?>
                  <?php //checks whether password hasn't got a space ?>
                  <?=(isset($passwordValid['spaceFound'])) ? "<p class=text-danger>Password did not have a space in it</p>":""?>
                  <?php //checks whether password isn't the same as the username ?>
                  <?=(isset($passwordValid['passwordIsNotUsername'])) ? "<p class=text-danger>Password equaled the username</p>":""?>
                  <label for="newPasswordConfirm">New password confirm:</label>
                  <input type="password" name="newPasswordConfirm" class="form-control" required="true" minlength = "8" maxlength="25"/>
                  <?php //checks whether don't passwords match  ?>
                  <?=(isset($passwordValid['passwordsMatch'])) ? "<p class=text-danger>Passwords didn't match</p>":""?>
                </div>
              <?php else: ?>
                <label for="newPassword">New password:</label>
                <input type="password" name="newPassword" class="form-control" required="true" minlength="8" maxlength="25"/>
                <label for="newPasswordConfirm">New password confirm:</label>
                <input type="password" name="newPasswordConfirm" class="form-control" required="true" minlength="8" maxlength="25"/>
              <?php endif; ?>
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary btn-sm" name="passwordChange" value="">Change password</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-7">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Delete account</h4>
        </div>
      </div>
      <form class="form" action="settings.php" method="post">
      <div class="panel-body">
        <p>Deleting account will remove all questions and answers from the site</p>
          <label for="Password">Password:</label>
          <?php //checks whether the password is wrong ?>
          <?php if(isset($passwordInvalid)): ?>
            <div class="form-group has-feedback has-error">
              <input type="password" name="deleteAccount" class="form-control" autofocus="true" minlength="8" maxlength="25"/>
              <p class="text-danger">The password you entered was wrong</p>
            </div>
          <?php else: ?>
          <input type="password" name="deleteAccount" class="form-control" minlength="8" maxlength="25"/>
        <?php endif; ?>
      </div>
      <div class="panel-footer">
        <button type="submit" class="btn btn-primary btn-sm">Delete account</button>
      </div>
    </form>

    </div>
  </div>
</div>
