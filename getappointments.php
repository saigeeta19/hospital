<?php
  include "connection.php";
 
 $app_date=$_POST["app_date"];
  $query=mysqli_query($con,"select * FROM appointments where appointment_date='".$app_date."' ORDER BY id ASC");
   $count=mysqli_num_rows($query);
   if($count>0)
   {
  $inc=1;
  
  echo "<tr><td colspan='6' align='center' id='table_head' style='color:yellow'><b>Total Appointments for ".$app_date." :- ".$count."</b></td></tr>";
  echo "<tr>
						<th>S.No</th>
						<th>Patient Name</th>
						<th>Doctor</th>
						<th>Appointment Time</th>
						<th>Phone</th>
						<th>Action</th>
		</tr>";
  while($result=mysqli_fetch_array($query)){
      $id=$result['id'];
      $status=$result['status'];
  	echo "<tr><td align='center'>$inc</td>
  	<td align='center'>$result[patient_name]</td>
  	<td align='center'>$result[doctor_name]</td>
  	<td align='center'>$result[app_time]</td>
  	<td align='center'>$result[phone]</td>
	<td align='center'><a href='updatestatus.php?id=".$id."&status=".$status."' style='text-decoration:none;color:#FFF;'>";if($status=='completed'){ echo "Done &nbsp;&nbsp; <input type='button' name='undo' value='Undo'/>"; } 
	else if($status=='booked') { echo "<input type='button' name='complete' value='Complete'/>"; } echo "</a>
	 &nbsp;<a href='getcancelappointment.php?id=".$id."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a>
	</td></tr>";
	$inc=$inc+1;
}
   }
   else
   	{
   		echo "<tr><td colspan='3' align='center'>No appointments till now!!</td></tr>";
   	}
?>
