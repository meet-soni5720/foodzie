<?php include('dbh.php'); ?>
<?php include('includes/register_login.php'); ?>
<?php include('header.php') ?>

    <div style="width: 80%; margin: 20px auto;">
		<form method="post" action="login.php" >
			<h2>Login</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" class = "form-control" name="password" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-primary" name="login_btn">Login</button>
			<p>
				Not yet a member? <a href="register.php">Sign up</a>
			</p>
		</form>
	</div>
</body>
</html>