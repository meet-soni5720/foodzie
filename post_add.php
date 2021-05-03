<?php 
  include('dbh.php');
?>

<?php 
  if(!isset($_SESSION['user'])){
	  header('Location:login.php');
  }
?>

<?php
  $user_id = $_SESSION['user']['id'];
  if(isset($_POST['submit'])){
	$msg = '';
	if(isset($_FILES['t_image'])){
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$body = $_POST['body'];

		if($title != '' && $body != '' && $desc != ''){
			$upload_ok = 1;
			$file_name = $_FILES['t_image']['name'];
			$file_size = $_FILES['t_image']['size'];
			$file_tmp = $_FILES['t_image']['tmp_name'];
			$file_type = $_FILES['t_image']['type'];
			$target_dir = "includes/uploads";

			$target_file = $target_dir . basename($_FILES['t_image']['name']);
			$check = getimagesize($_FILES['t_image']['tmp_name']);
			
			$file_path = explode('.', $_FILES['t_image']['name']);
			$file_ext_temp = end($file_path);
			$file_ext = strtolower($file_ext_temp);
			// echo $file_ext;

			$extensions = array("jpeg","jpg","png");
			if(in_array($file_ext,$extensions) == false){
				$msg = "please insert image in jpeg,jpg or png format!";
			}

			if(file_exists($target_file)){
				$msg = "Sorry file already exists!";
			}

			if($check == false){
				$msg = "file is not an image!";
			}

			if(empty($msg)){
				move_uploaded_file($file_tmp, "includes/uploads/" . $file_name);

				$url = $_SERVER['HTTP_REFERER'];
				$seg = explode('/',$url);
				$path = $seg[0] . '/' . $seg[1] . '/' . $seg[2] . '/' . $seg[3];
				$full_url = $path . '/' . 'includes/uploads/' . $file_name;

				$que = "INSERT INTO post(user_id, title, description, body, featured_img, created_at) VALUES ($user_id, '$title', '$desc', '$body', '$full_url', now())";
				$res = mysqli_query($conn, $que) or die(mysqli_error($conn));

				if($res){
					$post_id = mysqli_insert_id($conn);
					$checkbox = $_POST['ing'];
					if(empty($checkbox)){
						$msg = "please select atleast one ingredient!";
					}
					else{
					foreach($checkbox as $ing){
						// echo "$ing";
						$q1 = "SELECT ing_id from ingredients where name = '$ing'";
						$r = mysqli_query($conn, $q1);
						$ing_id = mysqli_fetch_array($r);
						$i_id = $ing_id['ing_id'];
						$que = "INSERT INTO pi_relation(post_id, ingredient_id) VALUES($post_id, $i_id)";

						$res = mysqli_query($conn, $que) or die(mysqli_error($conn));
						if($res){
							header('Location:dashboard.php');
						}
						else{
							$msg = "error adding ingredients";
						}
					}
				}
			}
		}

			
		}
		else{
			$msg = "Please fill all the details!";
		}
	}
		else{ $msg = "Please Insert all the details including title image!"; }
  }

?>
<style type="text/css">
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}



.button:hover {
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
.box
{
	/*border:4px solid black ;*/
	margin-top: 30px;
	margin-bottom: 60px;
	 box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.1);
}


</style>

<?php include('header.php') ?>
<div class="box" style="color: black">
	<br>
<div style="width: 80%; margin: 40px auto;">
<?php if(isset($_POST['submit'])): ?>
  <div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Warning!</h4>
  <p class="mb-0"> <?php echo $msg; ?> </p>	
</div>
<?php endif ?>
<form action="post_add.php" method="POST" enctype="multipart/form-data">
	<h2 style="text-align: center;">Add Your Recipe</h2>
  	<div class="form-group">
		<label for="title">Recipe Name:</label>
		<input type="text"class="form-control" style="width: 60%" name="title" required>
	</div>
	<div class="form-group">
		<label for="desc">description:</label>
		<textarea name="desc" class="form-control" rows="5" scroll="true" required> </textarea><br>
	</div>
	
  <fieldset class="form-group">
			<label>ingredients</label><br>
			<?php 
				$sql = "SELECT * from `ingredients`";
				$result = mysqli_query($conn, $sql);
			?>

			<?php if(mysqli_num_rows($result) > 0): ?>
				<?php while($row = mysqli_fetch_array($result)): ?>
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" name="ing[]" value = <?php echo $row[1]; ?> >
			<label class="form-check-label"> <?php echo $row[1]; ?> </label> 
	 		</div>
			<?php endwhile ?>
			<?php endif ?>
	</fieldset>

	<div class="form-group">
		<label for="body"> Main Recipe </label>
		<textarea name="body" class="form-control" rows="5" scroll="true" required> </textarea>
	</div>

	<div class = "form-group">
		<label for="t_image"> Title Image </label>
		<input type="file" class="form-control-file" name="t_image" id="t_image" aria-describedby="fileHelp" required>
		<small id="fileHelp" class="form-text text-muted">Upload image in .jpg, .jpeg or .png file format only</small>
	</div>

	<input type="submit" name="submit" value = "Add Recipe" class=" button" >
	<br>
</form>
</div>
<br>
</div>


<?php include('footer.php') ?>