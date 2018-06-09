<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Session.php"); ?>	
<?php require_once("Include/Functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
	$Name = mysqli_real_escape_string($Connection, $_POST["Name"]); // mysqli_real_escape_string(): sql injection
	$Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
	$Comment = mysqli_real_escape_string($Connection, $_POST["Comment"]);
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$CurrentTime = time();
	$DateTime = strftime("%Y-%m-%d	%H:%M:%S", $CurrentTime);
	$PostId = $_GET['id'];
	$DateTime;
	if (empty($Name) || empty($Email) || empty($Comment)) {
		$_SESSION["ErrorMessage"] = "All fields are required";
	} elseif (strlen($Comment) > 500) {
		$_SESSION["ErrorMessage"] = "Only 500  characters are allowed in comment";
	} else {
		//require_once 'Include/DB.php';
		global $Connection;
		$PostIDFromURL = $_GET['id'];
		$Query = "INSERT INTO comments (datetime, name, email, comment, appprovedby, status, admin_panel_id) VALUES ('$DateTime', '$Name', '$Email', '$Comment', 'Pending', 'OFF', '$PostIDFromURL')";
		$Execute = mysqli_query($Connection, $Query);
		if ($Execute) {
			$_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
			Redirect_to("FullPost.php?id={$PostId}");
		} else {
			$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
			Redirect_to("FullPost.php?id={$PostId}");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Blog Page</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/publicstyles.css">
	<style>
		.col-sm-8 {
			/*
			 * background-color: red;
			 */
		}
		.col-sm-3 {
			/*
			 * background-color: green;
			 */
		}
		nav ul li {
			float: left;
		}
		.FieldInfo {
			color: rgb(251, 174, 44);
			font-family: Bitter, Georgia, "Times New Roman", Times, serif;
			font-size: 1.2em;
		}
		.CommentBlock {
			background-color: #F6F7F9;
		}
		.Comment-Info {
			color: #365899;
			font-family: sans-serif;
			font-size: 1.1em;
			font-weight: bold;
			padding-top: 10px;
		}
		.Comment {
			margin-top: -2px;
			padding-bottom: 10px;
			font-size: 1.1em;
		}
	</style>
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
					<li class="active"><a href="Blog.php">Blog</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				<form action="FullPost.php" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name="Search">
					</div>
					<button class="btn btn-default" name="SearchButton">Go</button>
				</form>
			</div>
		</div>
	</nav>
	<div class="line" style="height: 10px; background: #27aae1;"></div>

	<div class="container">  <!-- Container -->
		<div class="blog-header">
			<h1>The Complete Responsive CMS Blog</h1>
			<p class="lead">The complete blog using PHP by TruongTuanIT</p>
		</div>

		<div class="row"> <!-- Row -->
			<div class="col-sm-8"> <!-- Main Blog Area -->
				<?php
					echo Message();
					echo SuccessMessage();
				 ?>
				<?php
				global $Connection;
				// Query when Search Button is Active
				if (isset($_GET['SearchButton'])) {
					$Search = $_GET['Search'];
					$ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%Search%' OR post LIKE '%$Search%'";
				} else {
					$PostIDFromURL = $_GET['id'];
					$ViewQuery = "SELECT * FROM admin_panel ORDER BY id desc";
				}
					$Execute = mysqli_query($Connection, $ViewQuery);
					while ($DataRows = mysqli_fetch_array($Execute)) {
						$PostId = $DataRows["id"];
						$DateTime = $DataRows["datetime"];
						$Title = $DataRows["title"];
						$Category = $DataRows["category"];
						$Admin = $DataRows["author"];
						$Image = $DataRows["image"];
						$Post = $DataRows["post"];
					?>
					<div class="blogpost thumbnail">
						<img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>">
						<div class="caption">
							<h1 id="heading"><?php echo htmlentities($Title); ?></h1>
							<p class="description">Category: <?php echo htmlentities($Category); ?> Published on <?php echo htmlentities($DateTime); ?>
								<?php
								global $Connection;
								$QueryApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$PostId' AND status = 'ON'";
								$ExecuteApproved = mysqli_query($Connection, $QueryApproved);
								$RowsApproved = mysqli_fetch_array($Connection, $ExecuteApproved);
								$TotalApproved = array_shift($RowsApproved);
								if ($TotalApproved > 0) {
									?>
									<span class="badge pull-right">Comments: <?php echo $TotalApproved; ?></span>
									<?php
								}
								?>
							</p>
							<p class="post">
								<?php
								echo $Post;
								?>
							</p>
						</div>

					</div>
					<?php
					}
				?>
				
				<span class="FieldInfo">Comments</span>

				<?php
				global $Connection;
				$PostIdFromComment = $_GET['id'];
				$ExtractingCommentQuery = "SELECT * FROM comments WHERE admin_panel_id = '$PostIdFromComment'";
				$Execute = mysqli_query($Connection, $ExtractingCommentQuery);
				while ($DataRows = mysqli_fetch_array($Execute)) {
				    $CommentDate = $DataRows['datetime'];
				    $CommentName = $DataRows['name'];
				    $Comments = $DataRows['comment'];
				?>
				<div class="CommentBlock">
					<img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" alt="" width="50px" height="50px">
					<p style="margin-left: 90px" class="Comment-Info"><?php echo $CommentName ?></p>
					<p style="margin-left: 90px" class="description"><?php echo $CommentDate; ?></p>
					<p style="margin-left: 90px" class="Comment"><?php echo $Comments; ?></p>
				</div> <br>
				<?php
				}
				?>
				<br>
				<span class="FieldInfo">Share your thoughts about this post</span>

				<div>
					<form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="Name"><span class="FieldInfo">Name:</span></label>
								<input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
							</div>

							<div class="form-group">
								<label for="Email"><span class="FieldInfo">Email:</span></label>
								<input class="form-control" type="Email" name="Email" id="Email" placeholder="Email">
							</div>

							<div class="form-group">
								<label for="commentarea"><span class="FieldInfo">Comment:</span></label>
								<textarea class="form-control" name="Comment" id="commentarea">
									
								</textarea>
							</div>
							 <br>
							<input class="btn btn-primary" type="submit" name="Submit" value="Submit">
						</fieldset>  <br>
					</form>
				</div>
				<nav>
					<ul class="pagination pull-left pagination-lg">
						<?php
						if (isset($Page)) {
							if ($Page > 1) { ?>
								<li><a href="Blog.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
								<?php
							}
							?>
							<?php
							global $Connection;
							$QueryPagination = "SELECT COUNT(*) FROM admin_panel";
							$ExecutePagination = mysqli_query($Connection, $QueryPagination);
							$RowPagination = mysqli_fetch_array($ExecutePagination);
							$TotalPosts = array_shift($RowPagination);
							// echo
							$PostPagination = $TotalPosts / 3;
							$PostPagination = ceil($PostPagination);
							// echo
							for ($i = 1; $i <= $PostPagination; $i++){
								if (isset($Page)) {
									if ($i == $Page) { ?>
										<li class="active"><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li> <?php
									} else { ?>
										<li><a href="Blog.php?Page=<?php echo $i; ?>"></a><?php echo $i; ?></li>
										<?php
									}
								}
							}
							?>
							<!-- Creating Forward Button -->
							<?php
							if (isset($Page)) {
								if ($Page + 1 <= $PostPagination) {
									?>
									<li><a href="Blog.php?Page=<?php echo $Page + 1; ?>">&raquo;</a></li>
									<?php
								}
							}
						}
							?>
						</ul>
					</nav>
				</div> <!--Main Blog Area Ending-->
			<div class="col-sm-offset-1 col-sm-3"> <!-- Side Area -->
				<h2>About me</h2>
				<img class="img-responsive img-circle" src="" alt="">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
				, sed do eiusmod tempor incididunt ut labore et dolore magna
				aliqua. Ut enim ad minim veniam, quis nostrud exercitation ul
				lamco laboris nisi ut aliquip ex ea commodo consequat. Duis a
				ute irure dolor in reprehenderit in voluptate velit esse cill
				um dolore eu fugiat nulla pariatur. Excepteur sint occaecat c
				upidatat non proi
				dent, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Categories</h2>
					</div>
					<div class="panel-body">
						<?php
						global $Connection;
						$ViewQuery = "SELECT * FROM category ORDER BY id desc";
						$Execute = mysqli_query($Connection, $ViewQuery);
						while ($DataRows = mysqli_fetch_array($Execute)) {
						    $Id = $DataRows['id'];
						    $Category = $DataRows['name'];
							?>
							<a href="Blog.php?Category=<?php echo $Category; ?>">
								<span id="heading"><?php echo $Category."<br>"; ?></span>
							</a>
							<?php
						}
						?>
					</div>
					<div class="panel-footer"></div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Recent Posts</h2>
					</div>
					<div class="panel-body background">
						<?php
						global $Connection;
						$ViewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5";
						$Execute = mysqli_query($Connection, $ViewQuery);
						while ($DataRows = mysqli_fetch_array($Execute)) {
						    $Id = $DataRows['id'];
						    $Title = $DataRows['title'];
						    $DateTime = $DataRows['datetime'];
						    $Image = $DataRows['image'];
						    if (strlen($DateTime) > 11) {
						    	$DateTime = substr($DateTime, 0, 12);
						    }
						    ?>
						    <div>
						    	<img class="pull-left" style="margin-top: 10px; margin-left: 0px;" width="120" height="60" src="Upload/<?php echo htmlentities($Image); ?>">
						    	<a href="FullPost.php?id=<?php echo $Id; ?>">
						    		<p id="heading" style="margin-left: 130px; padding-top: 10px;"><?php echo htmlentities($Title); ?></p>
						    	</a>
						    	<p class="description" style="margin-top: 130px;"><?php echo htmlentities($DateTime); ?></p> <hr>
						    </div>
						    <?php
						}
						?>
					</div>
					<div class="panel-footer"></div>
				</div>
			</div> <!-- Ending Side Area -->
		</div> <!-- Ending Row -->
	</div> <!-- Ending Container -->
	<div id="Footer">
		<hr><p>Theme by | TruongTuanIT | &copy; 2018 --- All right reserved.</p>
	</div> <!-- Footer -->
	
	<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>