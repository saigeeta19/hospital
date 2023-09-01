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
  <th>IP Number</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  <th>Adhaar Number</th>
  <th>Covid Report Number</th>
  
</tr>
";
if($creditcompany=="all")
{
$inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE admission_date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['admission_date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				$patient_ip_id=$row['patient_ip_id'];
				$age=$row['age'];
				$adhaar_num=$row['adhaar_num'];
				$covid_report_num=$row['covid_report_num'];
				$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
				
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
			 <td align='center'>$age years</td>
			 <td align='center'>$adhaar_num</td>
			 <td align='center'>$covid_report_num</td>
             
             
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
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE admission_date LIKE '$cdate%' && credit_company='".$creditcompany."'");
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['admission_date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				$patient_ip_id=$row['patient_ip_id'];
				$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
				
				
			 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             
             
           </tr>
           ";
           //$amt=$amt+$amount;
           $inc++;
       }
}  	
}	


?>