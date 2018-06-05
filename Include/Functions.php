<?php require_once 'Include/DB.php'; ?>
<?php require_once 'Include/Session.php'; ?>

<?php
function Redirect_to($New_Location) {
	header("Location:".$New_Location);
	exit();
}
?>