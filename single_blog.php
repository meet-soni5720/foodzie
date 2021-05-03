<?php include('dbh.php'); ?>

<?php include('header.php'); ?>
<?php $post_id = $_GET['id']; ?>

<?php
  if(isset($_SESSION['user'])){
  $uid = $_SESSION['user']['id'];
  $nq = "SELECT * FROM views WHERE `post_id` = $post_id and `user_id` = $uid";
  $res = mysqli_query($conn, $nq) or die(mysqli_error($conn));
  if(mysqli_num_rows($res) == 0){
    $q = "INSERT INTO views(`post_id`, `user_id`) VALUES($post_id, $uid)";
    $r = mysqli_query($conn, $q) or die(mysqli_error($conn));
    $q1 = "UPDATE post SET `views` = `views` + 1 where `id` = $post_id";
    $r1 = mysqli_query($conn, $q1) or die(mysqli_error($conn));
  }
}

  $qe = "SELECT `views` FROM `post` WHERE `id` = '$post_id'";
  $re = mysqli_query($conn, $qe) or die(mysqli_error($conn));
  $tv = mysqli_fetch_assoc($re);
  $views = $tv['views'];
?>

<style>

.jumbotron{
     background-color:white;
     padding:2rem;
}

 .comment{
   background-color:rgba(241, 238, 238, 0.733);
 }

 .comment_input{
   width:50vw;
   height:3rem;
   margin-left:1rem;
 }

 .comment .btn-primary{
   color:white;
   background-color:rgba(78, 81, 240, 0.733);
   border-radius:30px;
   height:3rem;
   padding:0.3rem;
   width: 10rem;
 }

 .commenter{
   background-color:white;
   padding:0.5rem;
   margin:1rem;
   width:50vw;
   /* border-radius:20px; */
   box-shadow: 10px 9px 35px -17px rgba(0,0,0,0.75);
-webkit-box-shadow: 10px 9px 35px -17px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 9px 35px -17px rgba(0,0,0,0.75);
margin-bottom: 0;
 }

 .atn-danger{
   color:rgba(146, 146, 148, 0.733);
   padding:none;
   margin:0;
   background-color:white;
   border:none;
   margin-left: 1rem;
   width : 50vw;
   text-align: left;
 }

 .atn-danger:hover{
   color:rgb(17, 124, 17)
 }

</style>

<?php

  function update_up($conn , $id){
    $q = "SELECT * FROM counter WHERE `post_id` = '$id'";
    $r = mysqli_query($conn,$q);
      if(mysqli_num_rows($r) > 0){
      $update_voteu= $conn->prepare("UPDATE `counter` SET `up`= up +1 WHERE post_id = ?");
    $update_voteu->bind_param("i",$id);
  //   $id = $_GET['id'];
    if ($update_voteu->execute()) {
      //echo "You like this recipe";
    }
  }else{
    $que = "INSERT INTO counter(post_id,up,down) VALUES($id,1,0)";
    $res = mysqli_query($conn, $que) or die(mysqli_error($conn));
    //echo "You like this recipe";
  }
}

function update_down($conn , $id){
  $q = "SELECT * FROM counter WHERE `post_id` = '$id'";
    $r = mysqli_query($conn,$q);
      if(mysqli_num_rows($r) > 0){
  $update_voted= $conn->prepare("UPDATE `counter` SET `down`= down +1 WHERE post_id = ?");
  $update_voted->bind_param("i",$id);
  if ($update_voted->execute()) {
    // echo "you dislike this recipe";
  }
}else{
  $que = "INSERT INTO counter(post_id,up,down) VALUES($id, 0, 1)";
    $res = mysqli_query($conn, $que) or die(mysqli_error($conn));
    // echo "You dislike this recipe";
}
}




function vote_numby_id($conn,$id){

  $getVote = $conn->prepare("SELECT * FROM `counter` WHERE `id`=?");
  $getVote->bind_param("i", $id);
  if ($getVote->execute()) {
    $ans=($getVote->get_result())->fetch_assoc();
    $up = $ans['up'];
    // echo "$up";
    $down = $ans['down'];
    // echo "$down";
    }

}

function chk($conn,$user_id,$id){
  $sql = "SELECT * FROM vote where `user_id`='$user_id' and `post_id` = '$id'";
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  if(mysqli_num_rows($res) > 0){
    return false;}
  return true;
}

function vote($conn,$user_id,$post_id,$voted){
    if(chk($conn,$user_id,$post_id)){
  
    $vote = $conn->prepare("INSERT INTO `vote`(`post_id`, `user_id`) VALUES (?,?)"); //pair recoded
    $vote->bind_param("ii",$post_id,$user_id);
    if ($vote->execute()) {
      // echo "inserted in to vote";
    }
  
        if(strtolower($voted) == 'up'){
          update_up($conn , $post_id);
        }
        if(strtolower($voted) == 'down'){
          update_down($conn , $post_id);
        }
  
    }
  }

?>

<?php 
 if (isset($_GET['vote'])) {
     vote($conn,$_SESSION['user']['id'],$post_id,$_GET['vote']);
 }

?>

<?php 
  if(isset($_GET['comment'])){
    $comment_text = $_GET['comment'];
    $p_id = $_GET['id'];
    $u_id = $_SESSION['user']['id'];

    $comment_sql = "INSERT INTO `comment_table`(`post_id`,`user_id`,`comment_text`) VALUES ('$p_id', '$u_id', '$comment_text')";
    $res = mysqli_query($conn, $comment_sql) or die(mysqli_error($conn));
  }
?>

<?php 
  if(isset($_GET['delete_comment'])){
    $p_id = $_GET['id'];
    $c_id = $_GET['comment_id'];

    $q = "DELETE FROM `comment_table` WHERE `comment_id` = $c_id";
    $r = mysqli_query($conn, $q) or die(mysqli_error($conn));

  }
?>

<?php 
    $sql = "SELECT * FROM post WHERE id = $post_id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
        while($p = mysqli_fetch_assoc($res)){ ?>
            <!-- <h1 style = "margin : 20px auto; text-align:center;"> <?php echo $p['title']; ?> </h1><br><br> -->

            <?php 
            $diff = strtotime("now") - strtotime($p['created_at']);
            $days = floor($diff/(3600*24));

            if($days < 0){
                $days = 0;
            }

            $y = "SELECT username FROM users join post on users.id = post.user_id where post.id = $post_id";
            $u = mysqli_query($conn, $y) or die(mysqli_error($conn));

            if(mysqli_num_rows($u) > 0){
                while($temp = mysqli_fetch_assoc($u)){
                    $author = $temp['username'];
                }
            }

            ?>

          <div class="imgAndDesc" style = "margin:4rem auto; display:flex; justify-content:space-around;" >
               
               <div style="display:flex;flex-direction:column">
                  <img src = <?php echo $p['featured_img']; ?> style = "height:400px; border-radius:30px" alt="recipe image"/>
              </div>
                 <div style="display:flex;flex-direction:column">
                 <h1 style = "margin : 2rem auto; font-size:3rem "> <?php echo $p['title']; ?> </h1>
                 <h6 style = "font-weight:700; margin:1rem"> <?php echo "Created by  : "; ?> <strong style="font-size:1rem"> <?php echo $author ?> </strong> </h6>
                 <h6 style = "font-weight:700 ;margin:1rem" ><?php echo " " . $days . "days ago." ?> </h6>
                <h6 style = "font-weight:700 ;margin:1rem; font-size:1.5rem" ><i class="fa fa-eye" aria-hidden="true"></i><?php echo "  ". $views; ?>
                
                </h6>
                
                 </div>
                  
          </div>
          <style>
            @media only screen and (max-width: 600px) {
                        .imgAndDesc{
                          flex-direction:column;
                        }
                 }
          </style>

          <div>
               
            </div>

          <div class = "jumbotron">
                <h3> Description: </h3>
                <p> <?php echo $p['description'] ?> </p>
            </div>
            
            <div class="jumbotron">
            <h3> ingredients: </h3>
            <?php
                $q = "SELECT name FROM ingredients JOIN pi_relation ON ingredients.ing_id = pi_relation.ingredient_id
                        WHERE pi_relation.post_id = $post_id";
                $r = mysqli_query($conn,$q);
                
                if(mysqli_num_rows($r) > 0){
                    ?>
                    <ul>
                        <?php while($t = mysqli_fetch_assoc($r)): ?>
                            <li> <?php echo $t['name']; ?> </li>
                    
                        <?php endwhile; ?>
                    </ul>
                    <?php
                }
            ?>
            </div>

            <div class = "jumbotron">
                <h3> Recipe: </h3>
                <p> <?php print_r($p['body']); ?> </p>
            </div>
        <?php
        }
    }
?>

<?php if(isset($_SESSION['user'])): ?>
<div class = "jumbotron">

    <?php
         $s = "SELECT * FROM counter WHERE post_id = $post_id";
         $a = mysqli_query($conn,$s) or die(mysqli_error($conn));
         if(mysqli_num_rows($a) > 0){
         $no = mysqli_fetch_assoc($a);
         }else{
             $no = array("up" => 0, "down" => 0);
         }
    ?>
<form action= ' ' method="get">
<div class = "row">
<input style = "visibility: hidden; position: absolute;" type="text" name = "id" value = <?php echo $_GET['id']; ?>>
        <div class = "col-sm-1">
        <!-- <input type="submit" name="vote" value="up" role="button" class="form-controlfas fa-thumbs-up"> -->
        <button  style="border:none;" type="submit" name="vote" value="up"><i style="font-size:2rem" class="fa fa-thumbs-up" aria-hidden="true"></i></i></button>
        <h4> <?php 
                    echo $no['up']
                ?>
        </h4>
        </div>
        <div class = "col-sm-1">
        <button style="border:none" type="submit" name="vote" value="down"><i style="font-size:2rem;"  class="fa fa-thumbs-down" aria-hidden="true"></i></button>
        <!-- <input type="submit" name="vote" value="down" class="fas fa-thumbs-down"> -->
        <h4> <?php 
                    echo $no['down']
                ?>
        </h4>
        </div>
        <span style="width:28rem"></span>
        <br/>
        <br/>
        <?php if($_SESSION['user']['username'] == $author): ?>
        <div class = "col-sm-2">
        <input type="submit" class = "btn btn-warning" formaction=<?php echo "post_update.php?id=" . $post_id; ?> name="submit" value="update">
        </div>
        <div class = "col-sm-2">
        <input type="submit" class = "btn btn-danger" formaction=<?php echo "delete.php?id=" . $post_id; ?> name="submit" value="delete">
        </div>
        <?php endif ?>

</div>
</form>
</div>

<?php if(isset($_SESSION['user'])): ?>
<div class = "jumbotron comment">
<form action = ' ' method = "get">
<input style = "visibility: hidden; position: absolute;" type="text" name = "id" value = <?php echo $_GET['id']; ?>>
<input class="comment_input" type="text" name="comment" placeholder="Enter the comment for the post">
<input type="submit" name = "insert_comment" class="btn btn-primary" value = "add comment">
</form> <br><br>


<?php 
  $p_id = $_GET['id'];
  $qu = "SELECT * FROM `comment_table` WHERE `post_id` = '$post_id'";
  $res = mysqli_query($conn, $qu) or die(mysqli_error($conn)); ?>
  <?php if(mysqli_num_rows($res) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($res)): ?>
      <?php 
        $u_id = $row['user_id'];
        $comment_text = $row['comment_text'];
        $q = "SELECT `username` from `users` where `id` = '$u_id'";
        $r = mysqli_query($conn, $q);  
      ?>
      <?php if(mysqli_num_rows($r) > 0): ?>
        <?php
          $c = mysqli_fetch_assoc($r);
          $commentor = $c['username'];
        ?>
        <div class="commenter">
      <span style="color:blue;font-weight:800;margin-right:2rem"><?php echo $commentor; ?></span><?php echo $comment_text; ?>
        </div>
        <?php if($_SESSION['user']['username'] == $commentor): ?>
          <form  action = ' ' method="get">
            <input style = "visibility: hidden; position: absolute;" type="text" name = "id" value = <?php echo $_GET['id']; ?>>
            <input style = "visibility: hidden; position: absolute;" type="text" name = "comment_id" value = <?php echo $row['comment_id']; ?>>
            <input type = "submit" name = "delete_comment" value = "delete" class = "atn-danger"> 
          </form>
        <?php endif ?>
      <?php endif ?>
      <br>
    <?php endwhile ?>
  <?php endif ?>


</div>
<?php endif ?>

</div>
  <?php endif ?>

<?php include('footer.php'); ?>
