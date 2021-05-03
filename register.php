<?php ob_start(); ?>
<?php ini_set('display_errors',1); ?>
<?php include('dbh.php'); ?>

<?php include('includes/register_login.php'); ?>
<?php include('header.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  
}


.container {
  position: relative;
  border-radius: 5px;
  /*background-color: #f2f2f2;*/
  padding: 20px 0 0 0;
} 

/* style inputs and link buttons */
input,
.btn {
  width: 20%;
  padding: 12px;
  border: none;
  border-radius: 4px;
  margin: 5px 0;
  opacity: 0.85;
  display: inline-block;
  font-size: 17px;
  line-height: 20px;
  text-decoration: none; /* remove underline from anchors */
}

input:hover,
.btn:hover {
  opacity: 1;
}



.google {
  background-color: #dd4b39;
  color: white;
}

.fc{
	box-shadow: 0 8px 1px -7px black;
	width: 70%;
}

</style>


<div style="width: 80%; margin: 60px auto;color: black">

<form method="post" action= "register.php" style="margin-left: 160px">
	<h2 style="text-shadow: 3px 3px 3px #ababab;margin-left: 180px">Register </h2>
	<?php include(ROOT_PATH . '/includes/errors.php') ?>
	<br>
	<div class="form-group">
		<label for="username">Username</label>
		<input  type= "text" id="username" class="form-control fc" name="username" value="<?php echo $username; ?>" placeholder="Enter Username"><br>
	</div>

	<div class="form-group">
	<label for="email">Email</label>
	<input type="email" class="form-control fc" id="email" name="email" value="<?php echo $email ?>" aria-describedby="emailHelp" placeholder="Email"><br>
	<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>

	<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control fc" id="password" name="password_1" placeholder="Password"><br>
	</div>

	<div class="form-group">
	<label for="password_2">Confirm password</label>
	<input type="password" class="form-control fc" id="password_2" name="password_2" placeholder="Password confirmation"><br>
	</div>

	<button type="submit" class="btn btn-primary" name="reg_user">Register</button>

	<?php

		include('config.php');

		$login_button = '';


		if(isset($_GET["code"]))
		{

		$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


		if(!isset($token['error']))
		{
		
		$google_client->setAccessToken($token['access_token']);

		
		$_SESSION['access_token'] = $token['access_token'];


		$google_service = new Google_Service_Oauth2($google_client);

		
		$data = $google_service->userinfo->get();

		
		if(!empty($data['given_name']))
		{
			$_SESSION['user_first_name'] = $data['given_name'];
			$user_name = $data['given_name'];
		}


		if(!empty($data['email']))
		{
			$_SESSION['user_email_address'] = $data['email'];
			$email = $data['email'];
		}

		$user_check = "SELECT * FROM `users` WHERE `username` = '$user_name' AND `email` = '$email' LIMIT 1";
		$res = mysqli_query($conn, $user_check);
		if(mysqli_num_rows($res) > 0){
			$arr = mysqli_fetch_assoc($res);

			$_SESSION['user'] = $arr;
			$_SESSION['message'] = "You are now logged in";
			header('location: dashboard.php');
			}
		else{
			$password_1 = $user_name;
			$password = md5($password_1);//encrypt the password before saving in the database
			$s = "INSERT INTO `users` ( `username`, `email`, `password`, `created_at`, `updated_at`) 
					  VALUES('$user_name', '$email', '$password', now(), now())";
			$result = mysqli_query($conn, $s);

			if($result){
				$reg_user_id = mysqli_insert_id($conn); 
	
				$_SESSION['user'] = getUserById($reg_user_id);
				$_SESSION['message'] = "You are now logged in";
				header('location: dashboard.php');	
				}
			}
		}
	}

		if(!isset($_SESSION['access_token']))
		{
			$login_button = '<a href="'.$google_client->createAuthUrl().'" class="google btn" style="width: 37%"><i class="fa fa-google fa-fw"></i> Signup with Google</a>';
		}
 
		if($login_button != ''){
			echo  $login_button ;
		}
	?>
		
	  
	  <p>
		Already a member? <a href="login.php" style="color: blue">Sign in</a>
	</p>
	

	
</form>
</div>
	

<?php include('footer.php'); ?>
<?php ob_end_flush(); ?>