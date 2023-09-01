<?php
  include "connection.php";
 
 $patient_ip_id=$_POST["patient_ip_id"];
 
 $query=mysqli_query($con,"select * FROM patient_admission where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
 $uid=$result['patient_id'];
 $query1=mysqli_query($con,"select * from patients where uid='".$uid."'");
 $query2=mysqli_fetch_array($query1);
 $patient_name=$query2['ntitle']." ".$query2['name'];
 
   echo "<option value='".$result['patient_id']."'>$result[patient_id] / $patient_name</option>" ;
 
 ?>
