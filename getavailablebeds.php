<?php
  include "connection.php";
 
 $admit_mode=$_POST["admit_mode"];
 $ward_name=$_POST["ward_name"];
 $query=mysqli_query($con,"select * FROM name_allotment_wards where category='".$admit_mode."' && ward_name='".$ward_name."' && status='vacant'");
 while($result=mysqli_fetch_array($query)){
   echo "<option value='".$result['bed_room_name']."'>$result[bed_room_name]</option>" ;
  }
  
?>
