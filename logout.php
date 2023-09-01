<?php
session_start();
$logger=$_SESSION['logger'];
session_destroy();
$logger="";
header("Location: index.php");
exit;

?>