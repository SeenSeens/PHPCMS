<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
$CurrentTime = time();
//$DateTime = strftime("%Y-%m-%d	%H:%M:%S", $CurrentTime);
$DateTime = strftime("%B-%d-%Y	%H:%M:%S", $CurrentTime);
echo $DateTime;
?>