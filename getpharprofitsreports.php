<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>UID/PID</th>
  <th>Pharmacy Name</th>
  <th>Type</th>
  <th>Bill Number</th>
  <th>Bill Amount</th>
  <th>Purchase Amount</th>
  <th>Quantity</th>
  <th>Profit</th>
</tr>
";
$inc=1;$profitamt=0;$selamt=0;$costamt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE date LIKE '$cdate%' ORDER BY id DESC");
      
            while($row=mysqli_fetch_array($query))
            {
                $pmaxid=$row['id'];
                $uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                $qty=$row['quantity'];
                $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
                $barcode=$row['barcode'];
				$sql67=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
				$sql68=mysqli_fetch_array($sql67);
				$rate=$sql68['price'];
                                $purrate=$sql68['purchase_rate'];
                                $purqty=$sql68['quantity'];
                $status=$row['status'];
                if($status=='cancel' || $status=='refund')
                {
                    $bill_num=$row['bill_number']." (Bill".$status.")";
                }
                else {
                     $bill_num=$row['bill_number'];
                }
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
                
                $puramt=$purrate*$qty;
                
                
                $amount=$row['amount'];
                $paidamt=round($amount-$discountamt);
                $profit=$paidamt-$puramt;
                $profitamt=$profitamt+$profit;
                $selamt=$selamt+$paidamt;
                $costamt=$costamt+$puramt;
                
            echo "
            <tr>
             <td align='center'>$inc</td>
            <td align='center'>$date</td>
            
            <td align='center'>$row[patient_id]/$row[pid]</td>
            
            <td align='center'>$row[pharmacy]</td>
                <td align='center'>$row[type]</td>
            <td align='center'>$bill_num</td>
            
           
               <td align='center'>Rs. $paidamt</td>
           
             <td align='center'>$puramt</td>
                    <td align='center'>$qty</td>
             <td align='center'>$profit</td>
            </tr>
            ";
            $inc++;
            }
            
       
}   
$returnamt=0;$rpuramt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
	$query=mysqli_query($con,"SELECT * FROM pharmacy_returned WHERE date_time LIKE '$cdate%' ORDER BY id DESC");
      
            while($row=mysqli_fetch_array($query))
            {
      			$uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                 $date=$row['date_time'];
                 $qty=$row['quantity'];
                 $paidamt=$row['price'];
                 $bill_num=$row['bill_number'];
                $date = date(" d-M-Y h:i a", strtotime($date));
                $barcode=$row['barcode'];
                $sql67=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
				$sql68=mysqli_fetch_array($sql67);
				$rate=$sql68['price'];
                                $purrate=$sql68['purchase_rate'];
                                $purqty=$sql68['quantity'];
                                $pharmacy=$sql68['name'];
                $puramt=$purrate*$qty;
                $profit=$paidamt-$puramt;
		$rpuramt=$rpuramt+$puramt;
               // $puramt=$paidamt=$profit=0;
               $returnamt=$returnamt+$paidamt;
               
                
                 echo "
            <tr>
             <td align='center'>$inc</td>
            <td align='center'>$date</td>
            
            <td align='center'>$row[patient_id]/$row[pid]<br/>(Return)</td>
            
            <td align='center'>$pharmacy</td>
                <td align='center'>$row[type]</td>
            <td align='center'>$bill_num</td>
            
           
               <td align='center'>Rs. $paidamt</td>
           
             <td align='center'>$puramt</td>
                    <td align='center'>$qty</td>
             <td align='center'>$profit</td>
            </tr>
            ";
            $inc++;
                
			}
	
} 
$finalselling=$selamt-$returnamt;
$finalpurchase=$costamt-$rpuramt;
//$finalprofit=$finalselling-$costamt;
$finalprofit=$finalselling-$finalpurchase;

/*echo "<tr>
<td colspan='6' style='text-align:right; padding-right:10px;'>Total Collection</td>
<td>Rs. $selamt</td>
<td>Rs. $costamt</td>
<td></td>
<td style='text-align:center;'>Rs. $profitamt</td>

</tr>";*/
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Purchase Amount</td>
<td>Rs. $costamt</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Selling Amount</td>
<td>Rs. $selamt</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Profit Amount</td>
<td>Rs. $profitamt</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Returned Amount</td>
<td>Rs. $returnamt</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Purchase Amount(After Return)</td>
<td>Rs. $finalpurchase</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Total Selling Amount(After Return)</td>
<td>Rs. $finalselling</td>
</tr>";
echo "<tr>
<td colspan='9' style='text-align:right; padding-right:10px;'>Final Profit Amount</td>
<td>Rs. $finalprofit</td>
</tr>";
?>