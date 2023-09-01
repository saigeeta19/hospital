<?php
include 'connection.php';
$id=$_POST['id'];
$query=mysqli_query($con,"DELETE FROM dental_list WHERE id='".$id."'");
if($query)
{
	echo "done";
}
?>