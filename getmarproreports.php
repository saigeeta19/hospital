<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$pro_name=$_POST['pro_name'];
$h="";
$inc=1;
if($pro_name=="all")
{
    $amt=0;
	$refu=0;
    echo "
<tr>
  <th>S.no</th>
  <th>DOR</th>
  <th>UID</th>
  <th>Name</th>
  <th>Address</th>
  <th>Phone No.</th>
  <th>Referred By</th>
  <th>Referred no.</th>
  <th>PRO</th>
 
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
            $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
            $address=$sql1['address'];   
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
               
            $amt=$amt+$row['doctor_fees'];
           if($row[status]=="opd")
           {
               $h="";
           }
			else {
				$h="<br/>".$row[status];
			}
               
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
              <td align='center'>$uid</td>
              <td align='center'>$patient_name</td>
              <td align='center'>$address</td>
              <td align='center'>$sql1[phone_number]</td>
             <td align='center'> $referred</td>
             <td align='center'> $row[referred_by_num]</td>
            <td align='center'>$row[pro_name]</td>
          
             
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
  <th>DOR</th>
  <th>UID</th>
  <th>Name</th>
  <th>Address</th>
  <th>Phone No.</th>
  <th>Referred By</th>
  <th>Referred no.</th>
  <th>PRO</th>
 
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && pro_name='".$pro_name."'");
       while($row=mysqli_fetch_array($query))
       {
            $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
            $address=$sql1['address'];   
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
               
            $amt=$amt+$row['doctor_fees'];
           if($row[status]=="opd")
           {
               $h="";
           }
			else {
				$h="<br/>".$row[status];
			}
               
           echo "
           <tr>
             <td align='center'>$inc</td>
              <td align='center'>$date</td>
              <td align='center'>$uid</td>
              <td align='center'>$patient_name</td>
              <td align='center'>$address</td>
              <td align='center'>$sql1[phone_number]</td>
             <td align='center'> $referred</td>
             <td align='center'> $row[referred_by_num]</td>
            <td align='center'>$row[pro_name]</td>
       
             
           </tr>
           ";
           $inc++;
       }
}

	
}     
?>