  <script src="JS/checkCookiesEnabled.js" charset="utf-8"></script>
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <h1 class="page-header text-center">Login</h1>
    <form class="form-login" action="login.php" method="post">
      <?php //checks whether the login is incorrect ?>
      <?php if(isset($incorrectLogin)): ?>
        <label for="username">Username: </label>
        <div class="form-group has-error has-feedback">
          <input type="text" name="username" class="form-control" autofocus="True">
        </div>
        <label for="password">Password: </label>
        <div class="form-group has-error has-feedback">
          <input type="password" name="password" class="form-control">
        </div>
        <p class="text-danger">The username or password was wrong</p>
      <?php else: ?>
        <label for="username">Username: </label>
        <input type="text" name="username" class="form-control" autofocus="True">
        <label for="password">Password: </label>
        <input type="password" name="password" class="form-control">
      <?php endif; ?>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="rememberMe" id="tickBox">Remember me</input>
        </label>
      </div>
      <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Login">
    </form>
