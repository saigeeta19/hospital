<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$entry=$_POST['entry'];

echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>Bill Number</th>
  <th>IP Number</th>
  <th>Name</th>
  <th>Status</th>
  <th>Amount</th>
  
  <th>Action</th>
</tr>
";



	$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$entry."'");
$entry1=mysqli_fetch_array($entry);
$entry=$entry1['name'];
	$inc=1;$cashtotal=0;$ref=0;$cautiontotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM deposits WHERE date LIKE '$cdate%' && entry_person='".$entry."'");
       while($row=mysqli_fetch_array($query))
       {
           $uid=$row['patient_id'];
           $patient_ip_id=$row['patient_ip_id'];
           $date=$row['date'];
           $bill_number=$row['bill_number'];
           $date = date(" d-M-Y h:i a", strtotime($date));
           $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];    
            $amount=$row['amount'];  
            $amount=abs($amount);
            $id=$row['id'];
             echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$bill_number</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[status]</td>
             <td align='center'>Rs. $amount</td>
             <td align='center'><a target='_blank' href='printdep.php?id=".$id."'><input type='button' name='print' id='print' value='Print'/></a>
             </td>
           </tr>
           ";
          
           $inc++;
       }
       
       $sql3=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && entry_person='".$entry."' && (status!='CR'AND status!='FSREF')");
       $sql2=mysqli_fetch_array($sql3);
       $cashtotal=$cashtotal+$sql2['sum(amount)'];
       
        $sql4=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' &&  entry_person='".$entry."' && status='CM'");
       $sql5=mysqli_fetch_array($sql4);
       $cautiontotal=$cautiontotal+$sql5['sum(amount)'];
       
       $sql=mysqli_query($con,"SELECT * FROM deposits WHERE date LIKE '$cdate%' && entry_person='".$entry."' && (status='CR' OR status='FSREF')");
       while($sql1=mysqli_fetch_array($sql))
       {
       $cautionrefund=$sql1['amount'];
       $cautionrefund=abs($cautionrefund);
       $ref=$ref+$cautionrefund;
       }
       
}    

 
     


$balance=$cashtotal-$ref;

echo "<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. $cashtotal</td>
<td></td>
</tr>

<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Refunds</td>
<td style='text-align:center;'>Rs. $ref</td>
<td></td>
</tr>
<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Balance Cash</td>
<td style='text-align:center;'>Rs. $balance</td>
<td></td>
</tr>
";

?>