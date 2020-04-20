<?php

require_once "bdd.php";

if(isset($_REQUEST['btn_register']))
{
	$username	= strip_tags($_REQUEST['txt_username']);
	$email		= strip_tags($_REQUEST['txt_email']);
	$password	= strip_tags($_REQUEST['txt_password']);
	if(empty($username)){
		$errorMsg[]="Please enter username";
	}
	else if(empty($email)){
		$errorMsg[]="Please enter email";
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="Please enter a valid email address";}
	else if(empty($password)){
		$errorMsg[]="Please enter password";
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password must be atleast 6 characters";
	}
	else
	{
		try
		{
			$select_stmt=$bdd->prepare("SELECT username, email FROM tbl_user WHERE username=:uname OR email=:uemail");

			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

			if($row["username"]==$username){
				$errorMsg[]="Sorry username already exists";
			}
			else if($row["email"]==$email){
				$errorMsg[]="Sorry email already exists";
			}
			else if(!isset($errorMsg))
			{
				$new_password = password_hash($password, PASSWORD_DEFAULT);

				$insert_stmt=$bdd->prepare("INSERT INTO tbl_user	(username,email,password) VALUES(:uname,:uemail,:upassword)");

				if($insert_stmt->execute(array(	':uname'	=>$username,
												':uemail'	=>$email,
												':upassword'=>$new_password))){

					$registerMsg="Register Successfully, Click On Login Account";
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Calendar Register</title>
<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

</head>

	<body>


	<nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

      </div>
    </nav>

	<div class="wrapper">

	<div class="container">

		<div class="col-lg-12">

		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong>WRONG ! <?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($registerMsg))
		{
		?>
			<div class="alert alert-success">
				<strong><?php echo $registerMsg; ?></strong>
			</div>
        <?php
		}
		?>
			<center><h2>Register Page</h2></center>
			<form method="post" class="form-horizontal">


				<div class="form-group">
				<label class="col-sm-3 control-label">Username</label>
				<div class="col-sm-6">
				<input type="text" name="txt_username" class="form-control" placeholder="enter username" />
				</div>
				</div>

				<div class="form-group">
				<label class="col-sm-3 control-label">Email</label>
				<div class="col-sm-6">
				<input type="text" name="txt_email" class="form-control" placeholder="enter email" />
				</div>
				</div>

				<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-6">
				<input type="password" name="txt_password" class="form-control" placeholder="enter passowrd" />
				</div>
				</div>

				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				<input type="submit"  name="btn_register" class="btn btn-primary " value="Register">
				</div>
				</div>

				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				You have a account register here? <a href="index.php"><p class="text-info">Login Account</p></a>
				</div>
				</div>

			</form>

		</div>

	</div>

	</div>

	</body>
</html>
