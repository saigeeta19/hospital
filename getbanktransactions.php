<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$stype=$_POST['stype'];
$status=$_POST['status'];
echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>Reason</th>
  <th>Type</th>
  <th>By</th>
  <th>Status</th>
  <th>Amount</th>
  <th>Entry By</th>

</tr>
";
$inc=1;$amt=0;

for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
	  
	   //if type is selected and status is all
	   if($stype!="" && $status=="")
	   {
	   $query=mysqli_query($con,"SELECT * FROM banktransactions WHERE date LIKE '$cdate%' && stype='".$stype."'");
	   }
	   
	   //if status is selected and type is all
	    else if($stype=="" && $status!="")
		 {
	   $query=mysqli_query($con,"SELECT * FROM banktransactions WHERE date LIKE '$cdate%' && status='".$status."'");
		 }
		  else if($stype!="" && $status!="")
		 {
	   $query=mysqli_query($con,"SELECT * FROM banktransactions WHERE date LIKE '$cdate%' && status='".$status."' && stype='".$stype."'");
		 }
		 else{
			 //if type and status is all
       $query=mysqli_query($con,"SELECT * FROM banktransactions WHERE date LIKE '$cdate%'");
	    
		 }
	   
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$row[reason]</td>
			 <td align='center'>$row[stype]</td>
             <td align='center'>".$row['person']."</td>
			 <td align='center'>$row[status]</td>
             <td align='center'>Rs. $row[amount]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $amt=$amt+$row['amount'];
           $inc++;
       }
}    
echo "<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Collection</td>
<td style='text-align:center;'>Rs. $amt</td>
<td></td>
</tr>";


?>