<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php //prints the title of page ?>
      <title><?=$title?></title>
      <link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <script src="JS/jquery-1.11.3.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <?php //checks the title ?>
      <?php if($title == "Q and A"): ?>
        <script type="text/javascript" async src="Mathsjax/MathJax.js?config=TeX-MML-AM_CHTML"></script>
        <script type="text/x-mathjax-config">MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});</script>
      <?php endif; ?>
    </head>
    <body>
    <nav class="navbar navbar">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="glyphicon glyphicon-list"></span>
          </button>
          <a class="navbar-brand" href="homepage.php">Questions</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <?php //checks the user isn't logged in and that the user isn't on the Register or login pages ?>
            <?php if((!isset($_SESSION['userID'])) and !($title == "Register" or $title == "Login")): ?>
              <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php //checks user is logged in ?>
            <?php elseif(isset($_SESSION['userID'])): ?>
              <?php //checks whether the title of page isn't post ?>
              <?php if ($title != "Post"): ?>
                <li><a href="post.php"><span class="glyphicon glyphicon-plus"></span> Add question</a></li>
              <?php endif; ?>
              <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            <?php //checks whether the current page title is login ?>
            <?php elseif($title == "Login"): ?>
              <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <?php //checks whether the current page title is register ?>
            <?php elseif($title == "Register"): ?>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
