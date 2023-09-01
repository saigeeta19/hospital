<?php
  include "connection.php";
 
 $admit_mode=$_POST["admit_mode"];
 $ward_name=$_POST["ward_name"];
  $query1=mysqli_query($con,"select * FROM name_allotment_wards where category='".$admit_mode."' && ward_name='".$ward_name."' ");
   $count=mysqli_num_rows($query1);
   if($count>0)
   {
  $inc=1;
  echo "<tr>
		<th>S.No</th>
		<th>Bed/Room Number</th>
		</tr>";
  while($result=mysqli_fetch_array($query1)){
  	echo "<tr><td align='center'>$inc</td>";
  	echo "<td align='center'>$result[bed_room_name]</td></tr>";
	$inc=$inc+1;
}
   }
   else
   	{
   		echo "<tr><td colspan='3' align='center'>No names alloted till now!!</td></tr>";
   	}
?>
