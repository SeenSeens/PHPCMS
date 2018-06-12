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
					<li><a href="dashboard.php"><span class="glyphicongly glyphicon-th"></span>&nbsp; DashBoard</a></li>
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
					<li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp; Categories</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
					<li class="active"><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
					<li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
				</ul>
			</div> <!-- Ending of Side area --> 

			<div>
				
			</div>
			<div class="col-sm-10"> <!-- Main Area -->
				<?php echo Message();
				echo SuccessMessage(); ?>
				<h1>Un-Approved Comments</h1>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Delete Comment</th>
							<th>Details</th>
						</tr>
						<?php
						$Connection;
						$Query = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY datetime desc";
						$Execute = mysqli_query($Connection, $Query);
						$SrNo = 0;
						while ($DataRows = mysqli_fetch_array($Execute)) {
							$CommentId = $DataRows['id'];
							$DateTimeOfComment = $DataRows['datetime'];
							$PersonName = $DataRows['name'];
							$PersonComment = $DataRows['comment'];
							$CommentedPostId = $DataRows['admin_panel_id'];
							$SrNo++;
							//if (strlen($PersonComment) > 18) {$PersonComment = substr($PersonComment, 0, 18).'...';}
							if (strlen($PersonName) > 10) {$PersonName = substr($PersonName, 0, 10).'...';}
						?>
						<tr>
							<td><?php echo htmlentities($SrNo); ?></td>
							<td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
							<td><?php echo htmlentities($DateTimeOfComment); ?></td>
							<td><?php echo htmlentities($PersonComment); ?></td>
							<td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
							<td><a href="DeleteComments.php?id=<?php echo $CommentId ?>"><span class="btn btn-danger">Delete</span></a></td>
							<td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target = "_blank"><span class="btn btn-primary">Details</span></a></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>

						<h1>Approved Comments</h1>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comment</th>
							<th>Approve By</th>
							<th>Revert Approve</th>
							<th>Delete Comment</th>
							<th>Details</th>
						</tr>
						<?php
						$Connection;
						//$Admin = "TruongTuanIT";
						$Query = "SELECT * FROM comments WHERE status = 'ON' ORDER BY datetime desc";
						$Execute = mysqli_query($Connection, $Query);
						$SrNo = 0;
						while ($DataRows = mysqli_fetch_array($Execute)) {
							$CommentId = $DataRows['id'];
							$DateTimeOfComment = $DataRows['datetime'];
							$PersonName = $DataRows['name'];
							$PersonComment = $DataRows['comment'];
							$ApprovedBy = $DataRows['approvedby'];
							$CommentedPostId = $DataRows['admin_panel_id'];
							$SrNo++;
							//if (strlen($PersonComment) > 18) {$PersonComment = substr($PersonComment, 0, 18).'...';}
							if (strlen($PersonName) > 10) {$PersonName = substr($PersonName, 0, 10).'...';}
						?>
						<tr>
							<td><?php echo htmlentities($SrNo); ?></td>
							<td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
							<td><?php echo htmlentities($DateTimeOfComment); ?></td>
							<td><?php echo htmlentities($PersonComment); ?></td>
							<td><?php echo htmlentities($ApprovedBy); ?></td>
							<td><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
							<td><a href="DeleteComments.php?id=<?php echo $CommentId ?>"><span class="btn btn-danger">Delete</span></a></td>
							<td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target = "_blank"><span class="btn btn-primary">Details</span></a></td>
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