<?php include('dbh.php'); ?>

<?php include('header.php'); ?>

<?php 
    if(!isset($_SESSION['user'])){
        header('Location:login.php');
    }
?>

<h1 style="margin:20px auto"> Welcome back <?php echo $_SESSION['user']['username']; ?> </h1>
<br> <br>

<?php
    $id = $_SESSION['user']['id'];
    $sql = "SELECT * FROM post WHERE user_id = $id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 0){ 
        ?>
    <div class = "jumbotron">
    <h4> Glad you join the community of amazing cooks! want to share your first recipe?</h4>
    <a href="post_add.php" class = "btn btn-success">Add your first recipe</a>
    </div>
    <?php
    }
    else{
        ?>
        <div class = "jumbotron">
        <h4> Want to add more recipe? </h4>
        <a href="post_add.php" class = "btn btn-success" role="button">Add recipe</a>
        </div> 
    <div class="row">
    <?php  while($p = mysqli_fetch_assoc($res)): ?>
    <div class = "col-sm-4">
    <div class="card mb-3" >
    <h4 class="card-header"> <?php echo $p['title']; ?> </h3>
    <img src= <?php echo $p['featured_img']; ?> class="d-block user-select-none" width="100%" height="200" alt="recipe image">
    <div class="card-body">
        <p class="card-text"><?php echo $p['description']; ?></p>
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
        <?php
    }
?>

<?php include('footer.php'); ?>