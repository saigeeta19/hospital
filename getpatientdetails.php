<?php
include 'connection.php';
$uid=$_POST['uid'];
$query=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
if(mysqli_num_rows($query)>0)
{
    
   $row=mysqli_fetch_array($query);
   echo $arr=$row['ntitle']."^".$row['name']."^".$row['co_name']."^".$row['gender']."^".$row['phone_number']."^".$row['address'];

   

}
else {

    echo $arr="no";
  
}

?>