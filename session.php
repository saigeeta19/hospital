<?php
ob_start();
error_reporting(0);
session_start();
$logger=$_SESSION['logger'];
$cd=date("d-m-Y");

if($logger=="")
{
	header("location:index.php");
	exit;
}
/*if($cd=="10-11-2022" OR $cd=="11-11-2022" OR $cd=="12-11-2022" OR $cd=="13-11-2022" OR $cd=="14-11-2022" OR $cd=="15-11-2022" OR $cd=="16-11-2022" )
	{
	$logger="";

	header("location:index.php");
	exit;
	} */
?>