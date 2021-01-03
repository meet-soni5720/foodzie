<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Food recipe blog </title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script type ="text/javascript" src="/static/js/jquery-3.5.1.js"></script>  
    <script type="text/javascript" src="/static/js/bootstrap.bundle.min"></script> -->
</head>
<body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="col-lg-10">
  <a class="navbar-brand" href="index.php">Foodiez</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</div>
 <div class="col-lg-2" style="margin-top:8px; color:white;">
  <div class = "dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="color:white !important;">Options</a>
        <div class="dropdown-menu">
      <?php $login_url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>
      <?php if($login_url == 'http://localhost/food_blog/register.php'): ?>
        <a class="dropdown-item" href = "index.php">Home</a>
        <a class="dropdown-item" href="login.php">Login</a>
      <?php elseif(isset($_SESSION['user'])): ?>
        <a class="dropdown-item" href = "index.php">Home</a>
        <a class="dropdown-item" href = "dashboard.php">Dashboard</a>
        <a class="dropdown-item" href = "post_add.php">Add Post</a>
        <a class="dropdown-item" href = "logout.php">Logout</a>
      <?php elseif($login_url == 'http://localhost/food_blog/index.php'): ?>
        <a class="dropdown-item" href = "login.php">Login</a>
        <a class="dropdown-item" href = "register.php">Register</a>
      <?php else: ?>
        <a class="dropdown-item" href = "index.php">Home</a>
        <a class="dropdown-item" href = "register.php">Register</a>
        <?php endif ?>

      </div>
      </div>
      </div>
</nav>

  <div class = "container">
