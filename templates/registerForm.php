  <?php //Gets the JS script required for the webpage to function ?>
  <script src="JS/validateForm.js" charset="utf-8"></script>
  <div class="container">
    <h1 class="page-header text-center">Sign-up</h1>
    <div class="col-md-6">
      <form class="form-signup" action="register.php" method="post">
        <label for="username">Username: </label>
        <?php //Checks whether the username has been taken  ?>
        <?php if(isset($usernameTaken)): ?>
          <div class="form-group has-error has-feedback">
            <input type="text" name="username" class='form-control' maxlength="16" minlength="2" autofocus="True" required="True" id ="username">
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span for="username" class="text-danger">Sorry that username was already taken</span>
          </div>
        <?php else: ?>
            <input type="text" name="username" class='form-control' maxlength="16" minlength="2" required="True" id ="username" <?=(isset($username)) ? "value='$username'":"autofocus=true" ?>>
        <?php endif; ?>
        <label for="password">Password:</label>
        <?php
        $errorWithPassword = False;
          //checks whether passwordCheck has a value
          if(isset($passwordCheck)){
            //go through each element in the array (key being the index of the array and value at that key)
            foreach ($passwordCheck as $key => $value) {
              //checks that the value is false and the key isn't passwordsMatch
              if(!$value and $key != 'passwordsMatch'){
                //sets with errorWithPassword to true and exits loop, since we now know
                //there's a problem so we know that we have to check what part of the password is wrong
                $errorWithPassword = True;
                break;
              }
            }
          }
            //checks whether that errorWithPassword is true
            if($errorWithPassword):
        ?>
          <div class="form-group has-error has-feedback">
            <input type="password" name="password" class='form-control' maxlength="25" minlength="8" required="True" onkeyup="validatePassword()" id = "password" <?=(isset($username)) ? "autofocus=true":"" ?>>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <ul>
              <?php //This block of code checks whether if a value has been set and then prints the suitable error message. Otherwise nothing happens ?>
              <?=(isset($passwordCheck['lowercase'])) ? "<p class='text-danger'>The password didn't contain any lowercase letters</p>":""?>
              <?=(isset($passwordCheck['uppercase'])) ? "<p class='text-danger'>The password didn't contain any uppercase letter</p>":""?>
              <?=(isset($passwordCheck['numberFound'])) ? "<p class='text-danger'>The password didn't contain any numbers</p>":""?>
              <?=(isset($passwordCheck['spaceFound'])) ? "<p class='text-danger'>The password didn't contain any spaces</p>":""?>
              <?=(isset($passwordCheck['passwordIsNotUsername'])) ? "<p class='text-danger'>The password was your username</p>":""?>
            </ul>
          </div>
        <?php else: ?>
          <input type="password" name="password" class='form-control' maxlength="25" minlength="8" required="True" onkeyup="validatePassword()" id = "password" <?=(isset($username)) ? "autofocus=true":"" ?>>
        <?php endif; ?>
        <label for="passwordConfirm">Confirm Password:</label>
        <?php //checks whether the passwords matched  ?>
        <?php if(isset($passwordCheck['passwordsMatch'])): ?>
          <div class="form-group has-error has-feedback">
            <input type="password" name="passwordConfirm" class='form-control' maxlength="25" minlength="8" required="True" onkeyup="checkPwordAndPwordConfirm()" id = "passwordConfirm">
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <p class="text-danger">The password and password confirm field didn't match</p>
          </div>
        <?php else: ?>
          <input type="password" name="passwordConfirm" class='form-control' maxlength="25" minlength="8" required="True" onkeyup="checkPwordAndPwordConfirm()" id = "passwordConfirm">
        <?php endif; ?>
        <br>
        <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="register">
        </form>
      </div>
      <div class="col-xs-6">
        <p>The password must meet these requirements:</p>
        <ul class="list-group" id= "list">
          <li class= "list-group-item list-group-item-danger">Password shouldn't match username</li>
          <li class= "list-group-item list-group-item-danger">Passsword should have at leat 8 characters and maximum of 25</li>
          <li class= "list-group-item list-group-item-danger">Password should contain at least one number</li>
          <li class= "list-group-item list-group-item-danger">Password should contain at least one space</li>
          <li class= "list-group-item list-group-item-danger">Password should contain uppercase characters</li>
          <li class= "list-group-item list-group-item-danger">Password should contain lowercase letters</li>
          <li class= "list-group-item list-group-item-danger">Password and password confirm must match</li>
        </ul>
      </div>
  </div>
