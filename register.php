<?php ini_set('display_errors',1); ?>
<?php include('dbh.php'); ?>

<?php include('includes/register_login.php'); ?>
<?php include('header.php'); ?>


    <div style="width: 80%; margin: 60px auto;">

		<form method="post" action= "register.php" >
			<h2>Register on FoodBlog</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<div class="form-group">
				<label for="username">Username</label>
				<input  type= "text" id="username" class="form-control" name="username" value="<?php echo $username; ?>" placeholder="Enter Username"><br>
			</div>

			<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" aria-describedby="emailHelp" placeholder="Email"><br>
			<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>

			<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password_1" placeholder="Password"><br>
			</div>

			<div class="form-group">
			<label for="password_2">Confirm password</label>
			<input type="password" class="form-control" id="password_2" name="password_2" placeholder="Password confirmation"><br>
			</div>
			<button type="submit" class="btn btn-primary" name="reg_user">Register</button><br>
			<p>
				Already a member? <a href="login.php">Sign in</a>
			</p>
		</form>
	</div>
<?php include('footer.php'); ?>