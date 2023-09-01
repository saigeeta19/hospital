<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$investigation=$_POST['investigation'];
$h="";
$inc=1;
if($investigation=="all")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
 
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%'");
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
            $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
            <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
       $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
       
}
echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";

   
}
else if($investigation=="ct")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
  
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%' && investigation_name LIKE 'CT-%'");
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
             $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
             <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
        $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && investigation LIKE 'CT-%'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
}

echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";
   
}
else if($investigation=="xray")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
  
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%' && investigation_name LIKE 'X-RAY%'");
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
             $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
            <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
        $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && investigation LIKE 'X-RAY%'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
       
}
echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";

   
}

else if($investigation=="sono")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
  
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%' && investigation_name LIKE 'USG%'");
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
             $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
            <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
        $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && investigation LIKE 'USG%'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
       
}
echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";

   
}


else if($investigation=="patho")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>
 
  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%' && investigation_name NOT LIKE 'X-RAY%' && investigation_name NOT LIKE 'CT-%' && investigation_name NOT LIKE 'USG%'");
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
             $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
             
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
            <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
        $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && investigation NOT LIKE 'X-RAY%' && investigation NOT LIKE 'CT-%'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
}
echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";

   
}
else {
    $amt=0;
	$refu=0;
      echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID</th>

  <th>Patient Name</th>
  <th>Investigation</th>
  <th>Amount</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM investigations_indents WHERE date LIKE '$cdate%' && investigation_name='".$investigation."'");
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
             $amt=$amt+$row['amount'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
             
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation_name]</td>
            <td align='center'>$row[amount]</td>
             
           </tr>
           ";
           $inc++;
       }
        $query=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && investigation='".$investigation."'");
       while($row=mysqli_fetch_array($query))
       {
           
			 $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i", strtotime($date));
            $amt=$amt+$row['investigation_fees'];
           
          
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
             <td align='center'>$uid</td>
            
             <td align='center'>$patient_name</td>
             <td align='center'>$row[investigation]</td>
            <td align='center'>$row[investigation_fees]</td>
             
           </tr>
           ";
           $inc++;
       }
}
echo "<tr><td colspan='5' style='text-align:right;'>Total Cash</td><td style='text-align:center;'>Rs. ".$amt."</td></tr>";
	
}     
?>