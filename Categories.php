<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php //Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
	$Category = mysqli_real_escape_string($Connection, $_POST["Category"]); // mysqli_real_escape_string(): sql injection
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$CurrentTime = time();
	$DateTime = strftime("%Y-%m-%d	%H:%M:%S", $CurrentTime);
	//$DateTime = strftime("%B-%d-%Y	%H:%M:%S", $CurrentTime);
	$DateTime;

	$Admin = "TruongTuanIT";
	//$Admin = $_SESSION['Username'];
	if (empty($Category)) {
		$_SESSION["ErrorMessage"] = "All Fields must be filled out";
		Redirect_to("Categories.php");
	} elseif (strlen($Category) > 99 ) {
		$_SESSION["ErrorMessage"] = "Too long name for category";
		Redirect_to("Categories.php");;
	} else {
		//require_once 'Include/DB.php';
		global $Connection;
		$Query = "INSERT INTO category(datetime, name, creatorname) VALUES ('$DateTime', '$Category', '$Admin')";
		$Execute = mysqli_query($Connection, $Query);
		if ($Execute) {
			$_SESSION["SuccessMessage"] = "Category Added Successfully";
			Redirect_to("Categories.php");
		} else {
			$_SESSION["ErrorMessage"] = "Category faild to add";
			Redirect_to("Categories.php");
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Manage Categories</title>
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
<body><!--
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
	-->

	<!-- Start Container -->
	<div class="container-fluid">
		<!-- Start row -->
		<div class="row">
			<div class="col-sm-2"> <br>
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li><a href="#"><span class="glyphicongly glyphicon-th"></span>&nbsp; DashBoard</a></li>
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
					<li class="active"><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp; Categories</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
					<li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
				</ul>
			</div> <!-- Ending of Side area --> 

			<div class="col-sm-10">
				<h1>Manage Categories</h1>
				<?php
					echo Message();
					echo SuccessMessage();
				 ?>

				<div>
					<form action="Categories.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="categoryname"><span class="FieldInfo">Name:</span></label>
								<input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
							</div> <br>
							<input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Category">
						</fieldset>  <br>
					</form>
				</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<tr>
						<th>Sr No.</th>
						<th>Date & Time</th>
						<th>Category Name</th>	
						<th>Creator Name</th>
						<th>Action</th>
					</tr>

					<?php
					// require_once 'Include/DB.php';
					global $Connection;
					$ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
					$Execute = mysqli_query($Connection, $ViewQuery);
					$SrNo = 0;
					while ($DataRows = mysqli_fetch_array($Execute)) {
					    $Id = $DataRows["id"];
					    $DateTime = $DataRows["datetime"];
					    $CategoryName = $DataRows["name"];
					    $CreatorName = $DataRows["creatorname"];
					    $SrNo++;
						?>
						<tr>
							<td><?php echo $SrNo; ?></td>
							<td><?php echo $DateTime; ?></td>
							<td><?php echo $CategoryName; ?></td>
							<td><?php echo $CreatorName; ?></td>
							<td>
								<a href="DeleteCategory.php?id=<?php echo $Id;?>">
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