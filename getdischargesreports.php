<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$creditcompany=$_POST['creditcompany'];

echo "
<tr>
  <th>S.no</th>
  <th>Admission Date</th>
  <th>Discharge Date</th>
  <th>Discharge Mode</th>
  <th>IP Number</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Company</th>
  <th>Under Doctor</th>
  <th>Total Bill</th>
   <th>Total Refunds</th>
   <th>Total Amount Paid</th>
   
  
</tr>
";
if($creditcompany=="all")
{
$inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE discharge_date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
             $adate=$row['admission_date'];
                $adate = date(" d-M-Y h:i a", strtotime($adate));
				$ddate=$row['discharge_date'];
                $ddate = date(" d-M-Y h:i a", strtotime($ddate));
				$patient_ip_id=$row['patient_ip_id'];
				$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
				$underdoctor=$row['admit_under_doctor'];
				$referred=$row['referred_by'];
				$discharge_mode=$row['discharge_mode'];
				$age=$row['age'];
				$credit_company=$row['credit_company'];
				$gender=$sql1['gender'];
				if($referred!="")
				{
					$patient_name=$patient_name."<br/>".$referred."<br/>".$row['referred_num'];
				}
				
				$sql2=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && (status='D' OR status='FSREC')");
				$sql3=mysqli_fetch_array($sql2);
				$totalbill=$sql3['sum(amount)'];
				
				$sql4=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREF'");
				$sql5=mysqli_fetch_array($sql4);
				$totalrefunds=$sql5['sum(amount)'];
				$totalpaid=$totalbill+$totalrefunds;
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$adate</td>
             <td align='center'>$ddate</td>
			 <td align='center'>$discharge_mode</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
			 <td align='center'>$age years</td>
			 <td align='center'>$gender </td>
			 <td align='center'>$credit_company</td>
             <td align='center'>$underdoctor</td>
             <td align='center'>Rs. $totalbill</td>
			  <td align='center'>Rs. $totalrefunds</td>
			   <td align='center'>Rs. $totalpaid</td>
             
             
           </tr>
           ";
           //$amt=$amt+$amount;
           $inc++;
       }
}    
}
else
{
   $inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE discharge_date LIKE '$cdate%' && credit_company='".$creditcompany."'");
       while($row=mysqli_fetch_array($query))
       {
             $adate=$row['admission_date'];
                $adate = date(" d-M-Y h:i a", strtotime($adate));
				$ddate=$row['discharge_date'];
                $ddate = date(" d-M-Y h:i a", strtotime($ddate));
				$patient_ip_id=$row['patient_ip_id'];
				$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
				$underdoctor=$row['admit_under_doctor'];
				$referred=$row['referred_by'];
				$discharge_mode=$row['discharge_mode'];
				$age=$row['age'];
				$credit_company=$row['credit_company'];
				$gender=$sql1['gender'];
				if($referred!="")
				{
					$patient_name=$patient_name."<br/>".$referred."<br/>".$row[referred_num];
				}
				
				$sql2=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && (status='D' OR status='FSREC')");
				$sql3=mysqli_fetch_array($sql2);
				$totalbill=$sql3['sum(amount)'];
				
				$sql4=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREF'");
				$sql5=mysqli_fetch_array($sql4);
				$totalrefunds=$sql5['sum(amount)'];
				$totalpaid=$totalbill+$totalrefunds;
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$adate</td>
             <td align='center'>$ddate</td>
			 <td align='center'>$discharge_mode</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
			  <td align='center'>$age years</td>
			 <td align='center'>$gender </td>
			 <td align='center'>$creditcompany</td>
             <td align='center'>$underdoctor</td>
             <td align='center'>Rs. $totalbill</td>
			  <td align='center'>Rs. $totalrefunds</td>
			   <td align='center'>Rs. $totalpaid</td>
             
             
           </tr>
           ";
           //$amt=$amt+$amount;
           $inc++;
       }
}    	
}

?>