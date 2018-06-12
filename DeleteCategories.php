<?php require_once ("Include/Session.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once ("Include/DB.php"); ?>
<?php
if (isset($_GET["delete"])) {
	$IdFromURL = $_GET["delete"];
	$Connnection;
	$Query = "DELETE FROM category WHERE id = '$IdFromURL'";
	$Exectute = mysqli_query($Connnection, $Query);
	if ($Exectute) {
		$_SESSION["SuccessMessage"] = "Category Delete Successfully!!!";
		Redirect_to("Categories.php");
	} else {
		$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!!!";
		Redirect_to("Categories.php");
	}
}
?>