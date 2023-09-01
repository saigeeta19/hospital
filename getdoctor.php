<?php
  include "connection.php";
 
 $doctor_name=$_POST["doctor_name"];
 
 $query=mysqli_query($con,"select * FROM doctor_list where doctor_name='".$doctor_name."'");
 $result=mysqli_fetch_array($query);
 
 
   echo "
    <tr>
     <td>Doctor Designation</td>
     <td><input type='text' name='designation' value='".$result['designation']."' /></td>
   </tr>
   <tr>
     <td>Doctor Fees</td>
     <td><input type='text' name='doctor_fees' value='".$result['doctor_fees']."' /></td>
   </tr>
   
   " ;
  
  
?>
