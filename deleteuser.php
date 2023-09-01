<?php
include 'connection.php';
$id=$_POST['id'];

$query=mysqli_query($con,"DELETE FROM users WHERE username='".$id."'");
if($query)
{
	echo "done";
}

?>