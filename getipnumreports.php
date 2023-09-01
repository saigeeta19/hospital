<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
  <th>S.no</th>
  <th>IP Number</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Admission Date</th>
  <th>Discharge Date</th>
</tr>
";
$inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE admission_date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
             $adate=$row['admission_date'];
                $adate = date(" d-M-Y h:i a", strtotime($adate));
				 $ddate=$row['discharge_date'];
				 if($ddate!="")
				 {
				    $ddate = date(" d-M-Y h:i a", strtotime($ddate));	
				 }
               
				$patient_ip_id=$row[patient_ip_id];
				$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
			 echo "
           <tr>
             <td align='center'>$inc</td>
            
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
              <td align='center'>$adate</td>
              <td align='center'>$ddate</td>
             
             
           </tr>
           ";
           //$amt=$amt+$amount;
           $inc++;
       }
}    


?>