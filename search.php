<?php include('dbh.php'); ?>
<?php include('header.php') ?>

<?php

function search($conn,$val){
//   $sql = "SELECT post.id FROM post JOIN pi_relation on post.id = pi_relation.post_id JOIN ingredients on pi_relation.ingredient_id = ingredients.ing_id WHERE ingredients.name = $name";
    // $sql = "SELECT `post_id` FROM `pi_relation` JOIN `ingredients` ON `pi_relation`.`ingredient_id` = `ingredients`.`ing_id` WHERE `name` = '$val'";
    $c = sizeof($val);
    $j = 0;
    $val = implode("','",$val);
    $val = strtolower($val);
   
    $sql = "SELECT  `post_id` FROM `pi_relation` JOIN `ingredients` ON `pi_relation`.`ingredient_id` = `ingredients`.`ing_id` WHERE `name` IN ('".$val."') GROUP BY post_id HAVING COUNT(*) = $c";
    //  print_r($sql);
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if(mysqli_num_rows($res) > 0){
    // while($row = mysqli_fetch_array($res)){
    // print_r($row);
    // echo "<br>"; }
      
        return $res;
    }
    else{
        echo "<h1>no recipe found! </h1><br>";}
}
    
?>

  <?php 
    if(isset($_POST['search_btn'])): ?>
      <?php  $se_input = $_POST['search_input'];
        $se_arr = explode(" ", $se_input);
            
        $res = search($conn, $se_arr);
        $op_arr = array();
        if(!is_null($res)){
        while($row = mysqli_fetch_array($res)){
            // print_r($row['post_id']);
            array_push($op_arr, $row['post_id']);
             }
        }
       
    ?>
        <div class = "row">
        <?php
       
        foreach($op_arr as $row): ?>
        <?php
           
            $r_id = $row;
            $s = "select * from post where id = '$r_id'";
            $respo = mysqli_query($conn, $s) or die(mysqli_error($conn));
        ?>

            <?php if(mysqli_num_rows($respo) > 0): ?>
                <?php $p = mysqli_fetch_array($respo); ?>
                <div class = "col-sm-4">
                <div class="card mb-3 cards" >
                
                <img src= <?php echo $p['featured_img']; ?> class="d-block user-select-none" width="100%" height="200" alt="recipe image">
                <div class="card-body">
                <h3 class="cardHeader"> <?php echo $p['title']; ?> </h3>
      <hr/>
                    <p class="card-text" style = "color: black;"><?php
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
                </div>

            <?php endif ?>
            
        
        <?php endforeach ?>
     </div>
   <?php endif ?>

<?php include('footer.php'); ?>