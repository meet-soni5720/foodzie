<?php include('dbh.php'); ?>
<?php include('header.php'); ?>
<!-- <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> -->
<style>
.container {
  position: relative;
  text-align: center;
  color: white;
}
.centered {
  position: absolute;
  top: 60%;
  left: 75%;
  transform: translate(-50%, -50%);
  color: white;
  font-weight: bold;
  font-style: italic;
  font-size: 50px;
}

</style>
<!-- </head>
<body> -->

<h2 style="margin:40px auto;text-align:center;background:black;color:white;">Variety of recipes and cooking-related articles with a focus on thoughtful and stylish living</h2>
<p>How to place text over an image:</p>

<div class="container">
  <img src=<?php echo "static/images/food_blog2.jpg" ?> alt="Snow" style="width:100%;">
  <div class="centered">Calories don’t count on the weekend.!!<br>Eat right, exercise, die anyway.</div>
</div>

<h1 style = "text-align:center;"> Popular Recipes</h1>
<?php 
    $que = "SELECT * FROM post ORDER BY views DESC LIMIT 9";
    $res = mysqli_query($conn, $que) or die(mysqli_error($conn)); ?>
   <?php if(mysqli_num_rows($res) > 0): ?>
    <?php echo "in"; ?>
    <div class = "row">
     <?php while($p = mysqli_fetch_assoc($res)): ?>
  <div class = "col-sm-4">
      <div class="card mb-3" >
      <h4 class="card-header"> <?php echo $p['title']; ?> </h3>
      <img src= <?php echo $p['featured_img']; ?> class="d-block user-select-none" width="100%" height="200" alt="recipe image">
      <div class="card-body">
          <p class="card-text" style = "color: black;"><?php echo $p['description']; ?></p>
      </div>
      <div class="card-body" role = "button" style="background : black;">
          <a href= <?php echo "single_blog.php?id=" . $p['id']; ?> class="card-link" role = "button" style="color:white; display:block"> Show full Recipe </a>
      </div>
      <div class="card-footer text-muted">
          <?php 
              $diff = strtotime("now") - strtotime($p['created_at']);
              $days = floor($diff/(3600*24));

              if($days < 0){
                  $days = 0;
              }
          ?>
          <h5> <?php echo $days . " days ago" ?> </h3>
      </div>
      </div>
      </div>
              <?php endwhile ?>
    </div>
          <?php endif ?>
      <?php

?>
<!-- </body>
</html>  -->

<?php include('footer.php'); ?>