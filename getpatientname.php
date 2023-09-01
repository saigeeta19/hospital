<?php
  include "connection.php";
 
 $patient_id=$_POST["patient_id"];
  $query=mysqli_query($con,"select * FROM patients where uid='".$patient_id."'");
  while($result=mysqli_fetch_array($query)){
      $name=$result['name'];
   echo "<option value='".$name."'>$name</option>" ;
  }
  
?>
