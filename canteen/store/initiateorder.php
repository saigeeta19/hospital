<?php
error_reporting(0);
include('connect.php');

	
	/*$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);*/

	
		
			//move_uploaded_file($_FILES["image"]["tmp_name"],"design/" . $_FILES["image"]["name"]);
			
		//	$location="design/".$_FILES["image"]["name"];
		
			$transnum = $_POST['transnum'];
			$qty 	  = $_POST['select2'];
			$name 	  = $_POST['pname'];
			$note 	  = $_POST['note'];
			$total	  = $_POST['txtDisplay'];
			
			mysql_query("INSERT INTO je_orders (product, qty, confirmation, total, note,date) VALUES('$name', '$qty', '$transnum', '$total', '$note', now())");
			
			header("location: index.php");

?>
