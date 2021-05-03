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
    <link rel="stylesheet" type="text/css" href="./static/css/index.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Stylish&display=swap" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>




<nav class="navbar navbar-expand-md navbar-light bg-light" style="position:relative;">
        <a class="navbar-brand " id="logo" href="index.php">Foodzie</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav">


                  <?php $login_url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>
                  <?php if($login_url == 'http://localhost/foodzie_v3/register.php'): ?>
                    <a class="nav-item nav-link " href = "index.php">Home</a>
                    <a class="nav-item nav-link" href="login.php">Login</a>
                  <?php elseif(isset($_SESSION['user'])): ?>
                    <a class="nav-item nav-link " href = "index.php">Home</a>
                    <a class="nav-item nav-link" href = "dashboard.php">Dashboard</a>
                    <a class="nav-item nav-link" href = "post_add.php">Add Post</a>
                    <a class="nav-item nav-link" href = "logout.php">Logout</a>
                  <?php elseif($login_url == 'http://localhost/foodzie_v3/index.php'): ?>
                    <a class="nav-item nav-link" href = "login.php">Login</a>
                    <a class="nav-item nav-link" href = "register.php">Register</a>
                  <?php else: ?>
                    <a class="nav-item nav-link " href = "index.php">Home</a>
                    <a class="nav-item nav-link active" href = "login.php">Login</a>
                    <a class="nav-item nav-link " href = "register.php">Register</a>
                    <?php endif ?>
            </div>
            <form class="form-inline" method="post" action="search.php" style="display:flex;flex-direction:column;margin-right:60px;margin-top:15px;">
                <div class="input-group">                    
                    <input autocomplete="off" type="text" class="form-control searchBar" id="search" name="search_input" placeholder="Search">
                    <div class="input-group-append">
                        <button style="outline: none;background-color:white;border:none" type="submit"  name="search_btn" >
                        <i class="fa fa-search"></i></button>
                    </div>
                </div>
              <div>
                <ul class="list-group" id="result"></ul>
                 <br />
              </div>
            </form>
           
        </div>
    </nav>

    <style>
      .fa-search{
        font-size:1rem;
        margin-left:0.2rem
      }
      .fa-search:hover{
        font-size:1.2rem
      }

     .form-inline{
       position:absolute;
       z-index:1001;
       right:0;
     }

     .list-group{
       position: absolute;
       margin-top:0.5rem;
       width:12rem;
       top:3rem;
       right:2rem;
       cursor:pointer;
     }
     .cards{
      transition: all .3s ease-in-out;
     }
     .cards:hover{
  transform: scale(1.02);
}
    </style>


  <script>
$(document).ready(function(){

 $.ajaxSetup({ cache: false });

 $('#search').keyup(function(){
  $('#result').html('');
  var searchField = $('#search').val().toLowerCase();
  $.getJSON('data.json', function(data) {
    let list_items = [];
   $.each(data, function(key, value){
    // console.log("key" ,key,value);
    if (value.name.toLowerCase().includes(searchField) && searchField!="")
    {
      // console.log(list_items)
      if(!list_items.includes(value.name)){
        list_items.push(value.name);
        $('#result').append('<li class="list-group-item link-class"><img src="'+value.image+'" height="40" width="40" class="img-thumbnail" /> '+value.name );
      }
    
    }
   });   
  });
 });
 
 $('#result').on('click', 'li', function() {
  var click_text = $(this).text().split('|');
  $('#search').val($.trim(click_text[0]));
  $("#result").html('');
 });
});
</script>
  <div class = "container">
