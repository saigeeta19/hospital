<?php
  include "connection.php";
 
 $admit_mode=$_POST["admit_mode"];
 $ward_name=$_POST["ward_name"];
 $query=mysqli_query($con,"select * FROM wards where category='".$admit_mode."' && ward_name='".$ward_name."' ");
 $result=mysqli_fetch_array($query);
 $total=$result['number_beds_rooms'];
 $query1=mysqli_query($con,"select * FROM name_allotment_wards where category='".$admit_mode."' && ward_name='".$ward_name."' ");
 $query2=mysqli_num_rows($query1) ;
 $unnamed=$total-$query2;
echo "<option value=$unnamed>$unnamed</option>" ;
 
?>
 