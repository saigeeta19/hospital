<?php
	include('../store/connect.php');
	$roomid = $_POST['roomid'];
	$status=$_POST['status'];
	mysql_query("UPDATE je_orders SET status='$status' WHERE id='$roomid'");
	header("location: index.php");
?>