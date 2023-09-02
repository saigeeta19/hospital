<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");



$con=mysqli_connect("localhost","root","","mahadev2023");

$con2=mysqli_connect("localhost","root","","canteen");

if(!$con)
{
	  echo("Connection not successfull");
}
//mysqli_select_db($con,"mahadev");
//mysqli_select_db($con2,"canteen");

?>
