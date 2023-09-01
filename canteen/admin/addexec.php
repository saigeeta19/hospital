<?php
include('../store/connect.php');



	if($_POST['Submit'])
	{
                        $type=$_POST['type'];
			$rate=$_POST['rate'];
			$desc=$_POST['desc'];
			$mode=$_POST['for_p'];
					//echo "INSERT INTO je_products (name, price, description, img) VALUES ('$type','$rate','$desc','dummy')";die;
			$update=mysqli_query("INSERT INTO je_products (name,price,description,mode) VALUES ('".$type."','".$rate."','".$desc."','".$mode."')") ;
			header("location: products.php");
			exit();
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
			
			$location=$_FILES["image"]["name"];*/
			
		
		//	}
	//}
	}

?>
