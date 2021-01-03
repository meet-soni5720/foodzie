<?php 
  include('dbh.php');
?>

<?php
    $id = $_GET['id'];
    $sql_que = "SELECT * FROM post WHERE id = $id";
    $res = mysqli_query($conn, $sql_que) or die(mysqli_error($conn));
    // print_r(mysqli_fetch_assoc($res));

    if(mysqli_num_rows($res) > 0){
        while($p = mysqli_fetch_assoc($res)){
            $title = $p['title'];
            $desc = $p['description'];
            $body = $p['body'];
            $featured_img = $p['featured_img'];
        }
    }

    $sql_que_2 = "SELECT ingredients.name FROM ingredients INNER JOIN pi_relation ON ingredients.ing_id = pi_relation.ingredient_id WHERE pi_relation.post_id = $id";
    $res2 = mysqli_query($conn, $sql_que_2) or die(mysqli_error($conn));

    $arr = array();
    if(mysqli_num_rows($res2) > 0){
        while($c = mysqli_fetch_assoc($res2)){
            // print_r($c);
            array_push($arr,$c['name']);
        }
    }
?>

<?php include('header.php'); ?>

<form action="update.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
	<label for="title">Recipe Name:</label>
    <input type="text" name="title" class = "form-control" value = "<?php echo strval($title);?>" required> <br>
    </div>
    <input type = "hidden" name = "id" value = <?php echo $id; ?> >
    <input type = "hidden" name="feat_img" value = "<?php echo $featured_img ?>" >
    <div class="form-group">
	<label for="desc">Recipe Summary:</label>
	<input type="text" class="form-control" name="desc" value = "<?php echo strval($desc); ?>" required> <br>
    </div>
	<div class="form-group">
		<label>ingredients</label> <br>
		<?php 
			$sql = "SELECT * from ingredients";
			$result = mysqli_query($conn, $sql);
		?>

		<?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <?php if(in_array($row[1], $arr)): ?>
            <div class="form-check form-check-inline">
            <input type="checkbox" class="form-check-input" name="ing[]" value = <?php echo $row[1]; ?> checked>
            <label class="form-check-label"><?php echo $row[1]; ?></label>
            </div>
            <?php else: ?>
                <div class="form-check form-check-inline">
                <input type="checkbox" name="ing[]" class="form-check-input" value = <?php echo $row[1]; ?> >
                <label class="form-check-label"><?php echo $row[1]; ?></label>
                </div>
            <?php endif ?>
		<?php endwhile ?>
		<?php endif ?>
    </div>
    
    <div class="form-group">
        <label for="body"> Main Recipe </label>
        <textarea name="body" class = "form-control" rows="5" scroll="true" required> <?php echo $body; ?>  </textarea> <br>
    </div>

    <div class = "form-group">
		<label for="t_image"> Title Image </label>
		<input type="file" class="form-control-file" name="t_image" id="t_image" aria-describedby="fileHelp">
		<small id="fileHelp" class="form-text text-muted">Upload image in .jpg, .jpeg or .png file format only</small>
	</div>

	<input type="submit" name="submit" value = "update" class="btn btn-primary">
</form>

<?php if($_GET['msg']): ?>
  <div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Warning!</h4>
  <p class="mb-0"> <?php echo $_GET['msg']; ?> </p>	
</div>
<?php endif ?>

<?php include('footer.php'); ?>