<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>IP Number</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Other Name</th>
  <th>Total Amount</th>
  <th>Entry By</th>
</tr>
";
$inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM other_entry WHERE app_date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['app_date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				$patient_ip_id=$row['patient_ip_id'];
				$sql2=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
				$sql3=mysqli_fetch_array($sql2);
				$uid=$sql3['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
				$amount=$row['amount'];
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[other_name]</td>
             <td align='center'>Rs. $amount</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $amt=$amt+$amount;
           $inc++;
       }
}    
echo "<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. $amt</td>
<td></td>
</tr>";


?>