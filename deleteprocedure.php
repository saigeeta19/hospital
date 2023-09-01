<?php
include 'connection.php';
$id=$_POST['id'];
$query=mysqli_query($con,"DELETE FROM procedures_list WHERE id='".$id."'");
if($query)
{
	echo "done";
}
?>