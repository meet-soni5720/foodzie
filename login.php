<?php ob_start(); ?>
<?php include('dbh.php'); ?>
<?php include('includes/register_login.php'); ?>
<?php include('header.php') ?>

<style>

body {
  font-family: Arial, Helvetica, sans-serif;
  background-color:  #ffffff;
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
	margin-left: 100px;
}



</style>
    <div style="width: 80%; margin: 20px auto;color: black;">
		<form method="post" action="login.php" style="margin-left: 100px">
			<h2 style="text-align: center;text-shadow: 3px 1px 5px #ababab;">Login</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<div class="form-group">
				<label for="username" style="margin-left: 100px">Username</label>
				<input type="text" class="form-control fc" id="username" name="username" value="<?php echo $username; ?>" value="" placeholder=" Enter Username" >
			</div>
			<div class="form-group">
				<label for="password" style="margin-left: 100px">Password</label>
				<input type="password" id="password" class = "form-control fc" name="password" placeholder="Enter Password">
			</div>
			<button type="submit" class="btn btn-primary" name="login_btn"style="margin-left: 100px">Login</button>
				
			<?php

			include('config_login.php');

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
				$login_button = '<a href="'.$google_client->createAuthUrl().'" class="google btn" style="width: 37%"><i class="fa fa-google fa-fw"></i> Signin with Google</a>';
			}

			if($login_button != ''){
				echo $login_button ;
			}

			?>
      		
			<p style="margin-left: 100px">
				Not yet a member? <a href="register.php" style="color: blue">Create an Account</a>
			</p>
		</form>
	</div>

<?php include('footer.php'); ?>
<?php ob_end_flush(); ?>