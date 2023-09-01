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
  <th>PID</th>
  <th>UID</th>
  

  <th>Amount</th>
 
</tr>
";

if($entry=="all")
{
$inc=1;$cashtotal=0;$ref=0;$cashreturn=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE date LIKE '$cdate%' GROUP BY bill_number ");
       while($row=mysqli_fetch_array($query))
       {
           $uid=$row['patient_id'];
           $pmaxid=$row['id'];
            $sql33=  mysqli_query($con,"SELECT * FROM pharmacy_discounts WHERE bill_number='".$row[bill_number]."'");
                if(mysqli_num_rows($sql33)>0)
                {
                $sql34=  mysqli_fetch_array($sql33);
                $discountamt=$sql34['discount_amount'];
                }
                else
                {
                    $discountamt=0;
                }
           
           $date=$row['date'];
		   $pid=$row['pid'];
           $bill_number=$row['bill_number'];
           $date = date(" d-M-Y h:i a", strtotime($date));
          $query3=mysqli_query($con,"SELECT sum(amount) FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
		  $query4=mysqli_fetch_array($query3);
		  
            $amount=$query4['sum(amount)']; 
			$amount=$amount-$discountamt;
			
         
            
             echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$bill_number</td>
             <td align='center'>$pid</td>
             <td align='center'>$uid</td>
            
             <td align='center'>Rs. $amount</td>
             
           </tr>
           ";
          $cashtotal=$cashtotal+$amount;
           $inc++;
       }
 $swe=mysqli_query($con,"SELECT sum(price) FROM pharmacy_returned WHERE date_time LIKE '$cdate%'");
          $swe1=mysqli_fetch_array($swe);
           $caret=$swe1['sum(price)'];
          $cashreturn=$cashreturn+$caret;
	$cashreturn=round($cashreturn);
  }    

$cashbal=round($cashtotal-$cashreturn);
echo "<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. ".round($cashtotal)." </td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Returned</td>
<td style='text-align:center;'>Rs. $cashreturn</td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Balance</td>
<td style='text-align:center;'>Rs. $cashbal</td>

</tr>
";

}
else {


	$inc=1;$cashtotal=0;$cashreturn=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE date LIKE '$cdate%' && pid='".$entry."' GROUP BY bill_number ");
       while($row=mysqli_fetch_array($query))
       {
           $uid=$row['patient_id'];
           
           $pmaxid=$row['id'];
            $sql33=  mysqli_query($con,"SELECT * FROM pharmacy_discounts WHERE pharmacy_id='".$pmaxid."'");
                if(mysqli_num_rows($sql33)>0)
                {
                $sql34=  mysqli_fetch_array($sql33);
                $discountamt=$sql34['discount_amount'];
                }
                else
                {
                    $discountamt=0;
                }
           
           $date=$row['date'];
		   $pid=$row['pid'];
           $bill_number=$row['bill_number'];
      
           $date = date(" d-M-Y h:i a", strtotime($date));
           $query3=mysqli_query($con,"SELECT sum(amount) FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
		  $query4=mysqli_fetch_array($query3);
		  
            $amount=$query4['sum(amount)']; 
			$amount=$amount-$discountamt;
			
                        
            echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$bill_number</td>
             <td align='center'>$pid</td>
             <td align='center'>$uid</td>
            
             <td align='center'>Rs. $amount</td>
             
           </tr>
           ";
           $cashtotal=$cashtotal+$amount;
           $inc++;
       }
       
      $swe=  mysqli_query($con,"SELECT sum(price) FROM pharmacy_returned WHERE date_time LIKE '$cdate%' && pid='".$entry."'");
          $swe1=  mysqli_fetch_array($swe);
          $caret=$swe1['sum(price)'];
          $cashreturn=$cashreturn+$caret;  
$cashreturn=round($cashreturn);
       
}    

 
  $cashbal=round($cashtotal-$cashreturn); 




echo "<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. ".round($cashtotal)."</td>

</tr>
</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Returned</td>
<td style='text-align:center;'>Rs. $cashreturn</td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Balance</td>
<td style='text-align:center;'>Rs. $cashbal</td>

</tr>
";
}

?>