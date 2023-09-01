<?php
	include('store/connect.php');
	$name = $_POST['name'];
	$email = $_POST['email'];	
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	mysqli_query("INSERT INTO message (name, email, subject, message) VALUES ('$name','$email','$subject','$message')");
	header("location: sending.php");
?>