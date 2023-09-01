<?php
include 'connection.php';
$sql=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist ORDER BY name");
while($sql1=mysqli_fetch_array($sql))
{
    $id=$sql1['id'];
    $expiry=$sql1['expiry_date'];
    $date=date_create($expiry);
    $nexpiry= date_format($date,"d-m-Y");
  $query=  mysqli_query($con,"UPDATE pharmacy_stocklist SET expiry_date='".$nexpiry."' WHERE id='".$id."'");  
}
?>