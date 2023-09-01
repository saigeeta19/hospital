<?php
	include('../store/connect.php');
	$roomid = $_POST['roomid'];
	$type=$_POST['type'];
	$rate=$_POST['rate'];
	$mode=$_POST['for_p'];
	$description=$_POST['description'];
	//$image = $_POST['image'];
	/*if (!isset($_FILES['image']['tmp_name'])) {
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
		}
	}	*/
	//if($location != "")
		//mysql_query("UPDATE je_products SET name='$type', price='$rate', description='$description', img='$location' WHERE id='$roomid'");
	//else
		mysql_query("UPDATE je_products SET name='$type', price='$rate', description='$description',mode='$mode' WHERE id='$roomid'");
	
	header("location: products.php");
?>