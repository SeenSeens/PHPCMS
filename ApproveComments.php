<?php require_once ("Include/Session.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php
if (isset($_GET['id'])) {
	$IdFromURL = $_GET['id'];
	$Connnection;
	$Query = "UPDATE comments SET status = 'ON' WHERE id = '$IdFromURL'";
	$Exectute = mysqli_query($Connnection, $Query);
	if ($Exectute) {
		$_SESSION["SuccessMessage"] = "Comment Approved Successfully!!!";
		Redirect_to("Comments.php");
	} else {
		$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!!!";
		Redirect_to("Comments.php");
	}
}
?>