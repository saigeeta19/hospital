<?php
  include "connection.php";
 
 $admit_mode=$_POST["admit_mode"];
  $query=mysqli_query($con,"select * FROM wards where category='".$admit_mode."'");
  echo "<option value=''>Select..</option>";
  while($result=mysqli_fetch_array($query)){
   echo "<option value='".$result['ward_name']."'>$result[ward_name]</option>" ;
  }
  
  
?>
