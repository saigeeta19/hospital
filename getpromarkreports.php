<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$procedure=$_POST['procedure'];
$h="";
$inc=1;
if($procedure=="all")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
  <th>IP Number</th>
  <th>Patient Name</th>
  <th>Procedure</th>
  <th>Under Doctor</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM procedures_indents WHERE date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
            $patient_ip_id=$row['patient_ip_id'];
			$sql67=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
			$sql68=mysqli_fetch_array($sql67);
			 $uid=$sql68['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[procedure_name]</td>
            <td align='center'>$sql68[admit_under_doctor]</td>
             
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
  <th>Date</th>
  <th>UID</th>
  <th>IP Number</th>
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Under Doctor</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM procedures_indents WHERE date LIKE '$cdate%' && procedure_name='".$investigation."'");
       while($row=mysqli_fetch_array($query))
       {
            $patient_ip_id=$row['patient_ip_id'];
			$sql67=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
			$sql68=mysqli_fetch_array($sql67);
			 $uid=$sql68['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[procedure_name]</td>
            <td align='center'>$sql68[admit_under_doctor]</td>
             
           </tr>
           ";
           $inc++;
       }
       
}

	
}     
?>