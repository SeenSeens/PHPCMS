<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php //Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
	$UserName = mysqli_real_escape_string($Connection, $_POST["UserName"]); // mysqli_real_escape_string(): sql injection
	$Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
	$ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$CurrentTime = time();
	$DateTime = strftime("%Y-%m-%d	%H:%M:%S", $CurrentTime);
	//$DateTime = strftime("%B-%d-%Y	%H:%M:%S", $CurrentTime);
	$DateTime;

	$Admin = "TruongTuanIT";
	//$Admin = $_SESSION['Username'];
	if (empty($UserName) || empty($Password) || empty($ConfirmPassword)) {
		$_SESSION["ErrorMessage"] = "All Fields must be filled out";
		Redirect_to("Admins.php");
	} elseif (strlen($Password) < 6 ) {
		$_SESSION["ErrorMessage"] = "Atleast 6 Characters For Password are required";
		Redirect_to("Admins.php");;
	} elseif ($Password !== $ConfirmPassword) {
		$_SESSION["ErrorMessage"] = "Password / ConfirmPassword does not match";
		Redirect_to("Admins.php");
	} else {
		//require_once 'Include/DB.php';
		global $Connection;
		$Query = "INSERT INTO registration (datetime, username, password, addedby) VALUES ('$DateTime', '$UserName', '$Password', '$Admin')";
		$Execute = mysqli_query($Connection, $Query);
		if ($Execute) {
			$_SESSION["SuccessMessage"] = "Admin Added Successfully";
			Redirect_to("Admins.php");
		} else {
			$_SESSION["ErrorMessage"] = "Admin faild to add";
			Redirect_to("Admins.php");
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
					<img src="images/logo.png" alt="" style="margin-top: -12px;"
					width=200px; height=30" >
				</a>
			</div>

			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				<form action="" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" class="form-control" name="Search" placeholder="Search">
					</div>
					<button class="btn btn-default" name="SearchButton">Go</button>
				</form>
			</div>
		</div>
	</nav>
	<div class="Line" style="height: 10px; background: #27aae1;"></div>
	

	<!-- Start Container -->
	<div class="container-fluid">
		<!-- Start row -->
		<div class="row">
			<div class="col-sm-2"> <br>
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li><a href="dashboard.php"><span class="glyphicongly glyphicon-th"></span>&nbsp; DashBoard</a></li>
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
					<li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp; Categories</a></li>
					<li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
					<li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
					<li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
				</ul>
			</div> <!-- Ending of Side area --> 

			<div class="col-sm-10">
				<h1>Manage Admin Access</h1>
				<?php
					echo Message();
					echo SuccessMessage();
				 ?>

				<div>
					<form action="Admins.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="UserName"><span class="FieldInfo">UserName:</span></label>
								<input class="form-control" type="text" name="UserName" id="UserName" placeholder="UserName">
							</div>
							<div class="form-group">
								<label for="Password"><span class="FieldInfo">Password:</span></label>
								<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
								<input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype same Password">
							</div>
							<input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin">
						</fieldset> <br> 
					</form>
				</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<tr>
						<th>Sr No.</th>
						<th>Date & Time</th>
						<th>Admin Name</th>	
						<th>Added By</th>
						<th>Action</th>
					</tr>

					<?php
					// require_once 'Include/DB.php';
					global $Connection;
					$ViewQuery = "SELECT * FROM registration ORDER BY id desc";
					$Execute = mysqli_query($Connection, $ViewQuery);
					$SrNo = 0;
					while ($DataRows = mysqli_fetch_array($Execute)) {
					    $Id = $DataRows["id"];
					    $DateTime = $DataRows["datetime"];
					    $Username = $DataRows["username"];
					    $Admin = $DataRows["addedby"];
					    $SrNo++;
						?>
						<tr>
							<td><?php echo $SrNo; ?></td>
							<td><?php echo $DateTime; ?></td>
							<td><?php echo $Username; ?></td>
							<td><?php echo $Admin; ?></td>
							<td>
								<a href="DeleteAdmin.php?id=<?php echo $Id;?>">
								<span class="btn btn-danger">Delete</span></a>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			</div> <!-- Ending of Main Area -->
		</div> <!-- Ending of Row-->
	</div> <!-- Ending of Container -->

	<div id="Footer">
		<hr><p>Theme by | TruongTuanIT | &copy; 2018 --- All right reserved.</p>
	</div> <!-- Footer -->

	<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>