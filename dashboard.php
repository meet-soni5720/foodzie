<?php include('dbh.php'); ?>

<?php include('header.php'); ?>

<?php 
    if(!isset($_SESSION['user'])){
        header('Location:login.php');
    }
?>

<style>
    
.btn-success{
  margin:1rem auto;
   padding:1rem ;
   background-color:#ff8000;
   border-radius:10px;
}

.btn-success:hover{
  background-color: #a85807;
}
</style>

<h2 style="margin:20px auto"> Welcome back <?php echo $_SESSION['user']['username']; ?> </h2>
<br> <br>

<?php
    $id = $_SESSION['user']['id'];
    $sql = "SELECT * FROM post WHERE user_id = $id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 0){ 
        ?>
    <div class = "jumbotron" style="background-color:white; text-align:center; ">
    <h4 style="margin:1rem auto; padding:1rem; line-height:1.8rem"> Glad you join the community of amazing cooks! want to share your first recipe?</h4>
    <a  href="post_add.php" class = "btn btn-success  ">Add your first recipe</a>
    </div>
    <?php
    }
    else{
        ?>
        <div class = "jumbotron"  style="background-color:white; text-align:center;">
        <h4 style="margin:1rem auto; "> Want to add more recipe? </h4>
        <a  href="post_add.php" class = " btn btn-success  " role="button">Add recipe</a>
        </div> 
    <div class="row">
    <?php while($p = mysqli_fetch_assoc($res)): ?>
        <a href= <?php echo "single_blog.php?id=" . $p['id']; ?> style="text-decoration:none">
  <div class = "col-sm-4">
 
      <div class="card mb-3 cards" >
      <img src= <?php echo $p['featured_img']; ?> class="d-block user-select-none" width="100%" height="200" alt="recipe image">
      <div class="card-body">
      <h3 class="cardHeader"> <?php echo $p['title']; ?> </h3>
      <hr/>
          <p class="card-text" style = "color: black;">
          <?php
         echo implode(' ', array_slice(explode(' ', $p['description']), 0, 12)).".....\n";
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
     
      </div>
      </a>

     <?php endwhile ?>
    </div>
        <?php
    }
?>

<?php include('footer.php'); ?>