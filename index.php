<?php include('dbh.php'); ?>
<?php include('header.php'); ?>

<style>
.container {
  position: relative;
  text-align: center;
  color: white;
}


</style>
<!-- </head>
<body> -->

<h2 class="IntroLine">Variety of recipes and cooking-related articles with a focus on thoughtful and stylish living</h2>


<div class="container">
  <img class="introImg" src=<?php echo "static/images/food_blog2.jpg" ?> alt="Snow" >
  <div class="centered">Calories don’t count on the weekend.!!<br>Eat right, exercise, die anyway.</div>
</div>

<h1 style = "margin: 10rem auto;margin-bottom:1rem"> Popular Recipes</h1>
<?php 
    $que = "SELECT * FROM post ORDER BY views DESC LIMIT 9";
    $res = mysqli_query($conn, $que) or die(mysqli_error($conn)); ?>
   <?php if(mysqli_num_rows($res) > 0): ?>
    <?php echo "in"; ?>
    <div class = "row">
     <?php while($p = mysqli_fetch_assoc($res)): ?>
  <div class = "col-sm-4">
  <a href= <?php echo "single_blog.php?id=" . $p['id']; ?> style="text-decoration:none" >
      <div class="card mb-3 cards" >
      <img src= <?php echo $p['featured_img']; ?> class="d-block user-select-none" width="100%" height="200" alt="recipe image">
      <div class="card-body">
      <h3 class="cardHeader"> <?php echo $p['title']; ?> </h3>
      <hr/>
          <p class="card-text" style = "color: black;">
          <?php
         echo implode(' ', array_slice(explode(' ', $p['description']), 0, 8)).".....\n";
        ?>
          </p>
       </div>
      <div class="ReadMore" role = "button">
          <a href= <?php echo "single_blog.php?id=" . $p['id']; ?> class="card-link" role = "button" style="color:white; display:block"> View Recipe </a>
      </div>
      <div class="card-footer text-muted">
          <?php 
              $diff = strtotime("now") - strtotime($p['created_at']);
              $days = floor($diff/(3600*24));

              if($days < 0){
                  $days = 0;
              }
          ?>
          <h6> <?php echo $days . " days ago" ?> </h6>
      </div>
      </div>
      </a>
      </div>
              <?php endwhile ?>
    </div>
          <?php endif ?>
      <?php

?>
<!-- </body>
</html>  -->

<?php include('footer.php'); ?>