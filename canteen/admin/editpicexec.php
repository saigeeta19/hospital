<?php
include('../store/connect.php');
	if (!isset($_FILES['image']['tmp_name'])) {
	echo "";
	}else{
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);

	
		if ($image_size==FALSE) {
		
			echo "That's not an image!";
			
		}else{
			
			move_uploaded_file($_FILES["image"]["tmp_name"],"../store/img/products/" . $_FILES["image"]["name"]);
			
			$location=$_FILES["image"]["name"];
			$roomid=$_POST['roomid'];
			
			if(!$update=mysql_query("UPDATE je_products SET img = '$location' WHERE id='$roomid'")) {
			
				echo mysql_error();
				
				
			}
			else{
			
			header("location: products.php");
			exit();
			}
			}
	}


?>