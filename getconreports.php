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
  <th>Bill Number</th>
  <th>Date</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  <th>Doctor</th>
  <th>Amount</th>
  <th>Entry By</th>
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
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
                if($referred=="")
                {
                    
                }
                else
                    {
                        $patient_name=$patient_name."<br/>(".$referred.")";
                    }
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
             <td align='center'>$row[bill_number] $h</td>
             <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[age]</td>
             <td align='center'>$row[doctor]</td>
             <td align='center'>Rs. $row[doctor_fees]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
}

echo "
<tr>
  <td colspan='7' align='center'>Total Cash Collected</td>
  <td align='center'>Rs. $amt</td>
  <td></td>
</tr>
";
echo "
<tr>
<td colspan='9' align='center'></td>
</tr>
<tr>
<th colspan='9' align='center'>Cash Refunds</th>
</tr>

<tr>
  <th>S.no</th>
  <th>Bill Number</th>
  <th>Date</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  <th>Doctor</th>
  <th>Refund Amount/<br/> Reason</th>
  <th>Entry By</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && status!='opd'");
       while($row=mysqli_fetch_array($query))
       {
       	     $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
                if($referred=="")
                {
                    
                }
                else
                    {
                        $patient_name=$patient_name."<br/>(".$referred.")";
                    }
            $refu=$refu+$row['transaction_amount'];
          
               
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$row[bill_number]</td>
             <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[age]</td>
             <td align='center'>$row[doctor]</td>
             <td align='center'>Rs. $row[transaction_amount] /<br/> $row[reason]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
  }
echo "
<tr>
  <td colspan='7' align='center'>Total Cash Refunds</td>
  <td align='center'>Rs. $refu</td>
  <td></td>
</tr>
";
   
}
else {
    $amt=0;
	$refu=0;
      echo "
<tr>
  <th>S.no</th>
  <th>Bill Number</th>
  <th>Date</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  <th>Amount</th>
  <th>Entry By</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && doctor='".$doctor."'");
       while($row=mysqli_fetch_array($query))
       {
            $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
                if($referred=="")
                {
                    
                }
                else
                    {
                        $patient_name=$patient_name."<br/>(".$referred.")";
                                            }
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
             <td align='center'>$row[bill_number] $h</td>
             <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[age]</td>
             <td align='center'>Rs. $row[doctor_fees]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
}
echo "
<tr>
  <td colspan='6' align='center'>Total Cash Collected</td>
  <td align='center'>Rs. $amt</td>
  <td></td>
</tr>
";
echo "
<tr>
<td colspan='8' align='center'></td>
</tr>
<tr>
<th colspan='8' align='center'>Cash Refunds</th>
</tr>

<tr>
  <th>S.no</th>
  <th>Bill Number</th>
  <th>Date</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Age</th>
  
  <th>Refund Amount/<br/> Reason</th>
  <th>Entry By</th>
</tr>
";
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && doctor='".$doctor."' && status!='opd'");
       while($row=mysqli_fetch_array($query))
       {
       	     $uid=$row['patient_id'];
            $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $patient_name=$sql1['name'];
                
            $date=$row['date'];
            $date = date(" d-M-Y h:i a", strtotime($date));
             $referred=$row['referred_by'];
                if($referred=="")
                {
                    
                }
                else
                    {
                        $patient_name=$patient_name."<br/>(".$referred.")";
                    }
            $refu=$refu+$row['transaction_amount'];
          
               
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$row[bill_number]</td>
             <td align='center'>$date</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[age]</td>
            
             <td align='center'>Rs. $row[transaction_amount] /<br/> $row[reason]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
  }
echo "
<tr>
  <td colspan='6' align='center'>Total Cash Refunds</td>
  <td align='center'>Rs. $refu</td>
  <td></td>
</tr>
";
	
}     
?>