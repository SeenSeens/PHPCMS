<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php //Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
	$UserName = mysqli_real_escape_string($Connection, $_POST["UserName"]); // mysqli_real_escape_string(): sql injection
	$Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
	if (empty($UserName) || empty($Password)) {
		$_SESSION["ErrorMessage"] = "All Fields must be filled out";
		Redirect_to("Login.php");
	} else {
		$Found_Account = Login_Attempt($Username, $Password);
		$_SESSION["User_Id"] = $Found_Account["id"];
		$_SESSION["Username"] = $Found_Account["username"];
		if ($Found_Account) {
			$_SESSION["SuccessMessage"] = "Welcome  {$_SESSION["Username"]}";
			Redirect_to("dashboard.php");
		} else {
			$_SESSION["ErrorMessage"] = "Invalid Username / Password";
			Redirect_to("Login.php");
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Manage Admins</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/adminstyle.css">
	<style type="text/css">
		.FieldInfo {
			color: rgb(251, 174, 44);
			font-family: Bitter, Georgia, "Times New Roman", Times, serif;
			font-size: 1.2em;
		}
		body {
			background-color: #ffffff;
		}
	</style>
</head>
<body>
	<div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-togle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="" class="navbar-brand">
					<img src="images/logo.png" alt="" style="margin-top: -5px;"
					width=200px; height=30" >
				</a>
			</div>

			<div class="collapse navbar-collapse" id="collapse"></div>
		</div>
	</nav>
	<!--<div class="Line" style="height: 10px; background: #27aae1;"></div>-->
	

	
	<div class="container-fluid"> <!-- Start Container -->
		<!-- Start row -->
		<div class="row">
			

			<div class="col-sm-offset-4 col-sm-4">
				<br><br>
				<h1>Welcome</h1>
				<?php
					echo Message();
					echo SuccessMessage();
				 ?>
	
				<div>
					<form action="Login.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="UserName">
									<span class="FieldInfo">UserName:</span>
								</label>
								<div class="input-group input-group-lg">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-envelope text-info"></span>
									</span>
									<input class="form-control" type="text" name="UserName" id="UserName" placeholder="UserName">
								</div>
							</div>
							<div class="form-group">
								<label for="Password">
									<span class="FieldInfo">Password:</span>
								</label>
								<div class="input-group input-group-lg">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock text-primary"></span>
									</span>
									<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
								</div>								
							</div>
							<input class="btn btn-info btn-block" type="submit" name="Submit" value="Login">
						</fieldset> <br> 
					</form>
				</div>

			</div> <!-- Ending of Main Area -->
		</div> <!-- Ending of Row-->
	</div> <!-- Ending of Container -->
</body>
</html>