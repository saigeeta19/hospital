<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$doctor=$_POST['doctor'];
$h="";
$inc=1;
if($doctor=="all")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>UID</th>
  <th>IP Number</th>
  <th>Patient Name</th>
  <th>Diagnosis</th>
  <th>Admission</th>
  <th>Discharge</th>
  <th>Doctor</th>
  <th>Entry By</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE admission_date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
            $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['admission_date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
            
            $date1=$row['discharge_date'];
			if($date1=="")
			{
				$date1="";
			}
			else {
				$date1 = date(" d-M-Y h:i a", strtotime($date1))."<br/> ( ".$row['discharge_mode']." )";
			}
            
          
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$uid</td>
             <td align='center'>$row[patient_ip_id]</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[problem_diagnosed]</td>
             <td align='center'>$date</td>
             <td align='center'>$date1</td>
             <td align='center'>$row[admit_under_doctor]</td>
             <td align='center'>$sql1[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
}


   
}
else {
    $amt=0;
	$refu=0;
      echo "
<tr>
  <th>S.no</th>
  <th>UID</th>
  <th>IP Number</th>
  <th>Patient Name</th>
  <th>Diagnosis</th>
  <th>Admission</th>
  <th>Discharge</th>
  <th>Doctor</th>
  <th>Entry By</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE admission_date LIKE '$cdate%' && admit_under_doctor LIKE '%$doctor%'");
       while($row=mysqli_fetch_array($query))
       {
            $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['admission_date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
            
            $date1=$row['discharge_date'];
			if($date1=="")
			{
				$date1="";
			}
			else {
				$date1 = date(" d-M-Y h:i a", strtotime($date1));
			}
            
          
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$uid</td>
             <td align='center'>$row[patient_ip_id]</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[problem_diagnosed]</td>
             <td align='center'>$date</td>
             <td align='center'>$date1</td>
             <td align='center'>$row[admit_under_doctor]</td>
             <td align='center'>$sql1[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
}

	
}     
?>