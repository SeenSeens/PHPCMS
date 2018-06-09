<?php require_once ("Include/Session.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
	<div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="Blog.php"><img style="margin-top: -7px;" src="images/logo.png" alt="" width="200" height="30"></a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li class="active"><a href="Blog.php" target="_blank">Blog</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				<form action="Blog.php" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name="Search">
					</div>
					<button class="btn btn-default" name="SearchButton">Go</button>
				</form>
			</div>
		</div>
	</nav>
	<div class="line" style="height: 10px; background: #27aae1;"></div>
	<!-- Start Container -->
	<div class="container-fluid">

		<!-- Start row -->
		<div class="row">
			<div class="col-sm-2">
				<br><br>
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li class="active"><a href="dashboard.php"><span class="glyphicongly glyphicon-th"></span>&nbsp; DashBoard</a></li>
					<li ><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
					<li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp; Categories</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
					<li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
				</ul>
			</div> <!-- Ending of Side area --> 

			<div>
				
			</div>
			<div class="col-sm-10"> <!-- Main Area -->
				<h1>Admin Dashboard</h1>
				<?php echo Message();
				echo SuccessMessage(); ?>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Post Title</th>
							<th>Date & Time</th>
							<th>Author</th>
							<th>Category</th>
							<th>Banner</th>
							<th>Comments</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
						<?php
						$Connection;
						$ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc";
						$Execute = mysqli_query($Connection, $ViewQuery);
						$SrNo = 0;
						while ($DataRows = mysqli_fetch_array($Execute)) {
						    $Id = $DataRows["id"];
						    $DateTime = $DataRows["datetime"];
						    $Title = $DataRows["title"];
						    $Category = $DataRows["category"];
						    $Admin = $DataRows["author"];
						    $Image = $DataRows["image"];
						    $Post = $DataRows["post"];
						    $SrNo++;
							?>
							<tr>
								<td><?php echo $SrNo; ?></td>
								<td style="color: #5e5eff;">
									<?php if (strlen($Title) > 20) { $Title = substr($Title, 0, 20).'...'; }
									echo $Title; ?>
								</td>
								<td>
									<?php if (strlen($DateTime) > 11) { $DateTime = substr($DateTime, 0, 11).'...'; }
									echo $DateTime; ?>	
								</td>
								<td>
									<?php if (strlen($Admin) > 6) { $Title = substr($Admin, 0, 6).'...'; }
									echo $Admin; ?>
								</td>
								<td>
									<?php if (strlen($Category) > 8) { $Title = substr($Category, 0, 8).'...'; }
									echo $Category; ?>
								</td>
								<td><img src="Upload/<?php echo $Image; ?>" width="170px"; height="60px"></td>
								<td>Processing</td>
								<td>
									<a href="EditPost.php?Edit=<?php echo $Id; ?>"> <span class="btn btn-warning">Edit</span></a> 
									<a href="DeletePost.php?Delete=<?php echo $Id; ?>"> <span class="btn btn-danger">Delete</span></a>
								</td>
								<td>
									<a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
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