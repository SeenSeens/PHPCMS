<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php //Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
	$Title = mysqli_real_escape_string($Connection, $_POST["Title"]); // mysqli_real_escape_string(): sql injection
	$Category = mysqli_real_escape_string($Connection, $_POST["Category"]);
	$Post = mysqli_real_escape_string($Connection, $_POST["Post"]);
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$CurrentTime = time();
	$DateTime = strftime("%Y-%m-%d	%H:%M:%S", $CurrentTime);
	//$DateTime = strftime("%B-%d-%Y	%H:%M:%S", $CurrentTime);
	$DateTime;

	$Admin = "TruongTuanIT";
	$Image = $_FILES["Image"]["name"];
	$Target = "Upload/".basename($_FILES["Image"]["name"]);
	//$Admin = $_SESSION['Username'];
	if (empty($Title)) {
		$_SESSION["ErrorMessage"] = "Title can't be empty";
		Redirect_to("AddNewPost.php");
	} elseif (strlen($Title) < 2) {
		$_SESSION["ErrorMessage"] = "Title Should be at-least 2 Characters";
		Redirect_to("AddNewPost.php");
	} else {
		//require_once 'Include/DB.php';
		global $Connection;
		$EditFromURL = $_GET['Edit'];
		$Query = "UPDATE admin_panel SET datetime = '$DateTime', title = '$Title', category = '$$Category', author = '$Admin', image = '$Image', post = '$Post' WHERE id = '$EditFromURL'";
		$Execute = mysqli_query($Connection, $Query);
		move_uploaded_file($_FILES["Image"]["tmp_name"], $Target); // Chuyen hinh anh sang thu muc
		if ($Execute) {
			$_SESSION["SuccessMessage"] = "Post Update Successfully";
			Redirect_to("Dashboard.php");
		} else {
			$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
			Redirect_to("Dashboard.php");
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Edit Post</title>
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
					<li><a href="dashboard.php"><span class="glyphicongly glyphicon-th"></span>&nbsp; DashBoard</a></li>
					<li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
					<li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp; Categories</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
					<li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
				</ul>
			</div> <!-- Ending of Side area --> 

			<div class="col-sm-10">
				<h1>Edit Post</h1>
				<?php
					//require_once 'Include/Session.php';
					echo Message();
					echo SuccessMessage();
				 ?>

				<div>
					<?php
					$SearchQueryParameter = $_GET['Edit'];
					$Connection;
					$Query = "SELECT * FROM admin_panel WHERE id = '$SearchQueryParameter'";
					$Execute = mysqli_query($Connection, $Query);
					while ($DataRows = mysqli_fetch_array($Execute)) {
						$TitleToBeUpdated = $DataRows['title'];
						$CategoryToBeUpdated = $DataRows['category'];
						$ImageToBeUpdated = $DataRows['image'];
						$PostToBeUpdated = $DataRows['post'];
					}
					?>
					<form action="EditPost.php?Edit=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"><span class="FieldInfo">Title:</span></label>
								<input class="form-control" type="text" name="Title" id="title" value="<?php echo $TitleToBeUpdated; ?>" placeholder="Title">
							</div>

							<div class="form-group">
								<span class="FieldInfo">Existing Category:</span>
								<?php echo $CategoryToBeUpdated; ?>
							</div>

							<div class="form-group">
								<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
								<select class="form-control" name="Category" id="categoryselect">
									<?php
									// require_once 'Include/DB.php';
									global $Connection;
									$ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
									$Execute = mysqli_query($Connection, $ViewQuery);
									while ($DataRows = mysqli_fetch_array($Execute)) {
									    $Id = $DataRows["id"];
									    $CategoryName = $DataRows["name"];
										?>
										<option value=""><?php echo $CategoryName; ?></option>
										<?php
									}
									?>

								</select>
							</div>
							
							<div class="form-group">
								<span class="FieldInfo">Existing Image:</span>
								<img src="Upload/<?php echo $ImageToBeUpdated; ?>" width=150px; height=50px;>
							</div>

							<div class="form-group">
								<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
								<input type="File" class="form-control" name="Image" id="imageselect">
							</div>

							<div class="form-group">
								<label for="postarea"><span class="FieldInfo">Post:</span></label>
								<textarea class="form-control" name="Post" id="postarea">
									<?php echo $PostToBeUpdated; ?>
								</textarea>
							</div>
							 <br>
							<input class="btn btn-success btn-block" type="submit" name="Submit" value="Update Post">
						</fieldset>  <br>
					</form>
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