<?php include 'convert_words.php'; ?> 
<?php include 'session.php';
 include 'connection.php';
 $logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
 $bill=$_GET['bill'];
 
 $query=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE bill_number='".$bill."'");
     $row=mysqli_fetch_array($query);
    $pmaxid=$row['id'];
    $btype=$row['type'];
     if($btype=="OPD")
        {
            $rnum="DL. No. CG-BZ2-18654 CG-BZ2-18655";
        }
 else if($btype=="IPD")
     {
        $rnum="DL. No. CG-BZ2-18622 CG-BZ2-18623";
     }
     $patient_id=$row['patient_id'];
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
	 
     
      $amount=$row['amount'];
       $paidamt=$amount-$discountamt;
     
     $date=$row['date'];
	 $date = date("d-M-Y", strtotime($date));
   	 $uid=$patient_id;
                $sql45=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql15=mysqli_fetch_array($sql45);
                $patient_name=$sql15['name'];
	$inc=1; $tot=0;
     $t="<html><body style='margin:0;border:solid 1px #000000;margin:4px;'>
         <table width='100%' style='font-size:9px; border-bottom:solid 1px #000000;'>
       <tr>
       <td style='text-align:left; font-size:10px;width:50%;'> <b>MAHADEV PHARMACY</b><br/>Mahima Complex, Main Road, <br/>Vyapar Vihar<br/>Bilaspur-CG 495001</td>
       <td style='text-align:right; font-size:8px;width:50%;'>$rnum<br/>TIN: 22424105858</td>
       </tr>
       </table>
        <table width='100%' style='font-size:10px;'>
       <tr>
       <td colspan='4' style='text-align:center; font-size:10px; text-decoration:underline;'> <b>INVOICE</b> </td>
       </tr>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Date:  </th>
       <td style='padding-top:5px;'>$date</td>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Bill Number:</th>
       <td style='padding-top:5px;'>$bill</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;font-size:10px'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;font-size:10px'>Patient Name: </th>
       <td><b>$patient_name</b></td>
       </tr>
        
       </table>
       <table width='95%' border='1' cellpadding='3px' style='border-collapse:collapse;font-size:8px;text-align:center;margin:5px;line-height:10px;'>
       <tr>
        
        <th width='20%'>Batch</th>
        <th width='45%'>Name</th>
        <th width='20%'>Expiry</th>
        <th width='5%'>Qty</th>
        <th width='5%'>Rate</th>
        <th  width='5%'>Amount</th>
	   </tr>
	    ";
	    $query1=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE bill_number='".$bill."'");
		while($row1=mysqli_fetch_array($query1))
		{
			 $barcode=$row1['barcode'];
				$sql67=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
				$sql68=mysqli_fetch_array($sql67);
				$rate=$sql68['price'];
			$t=$t."<tr>
			
			<td>$sql68[batch_number]</td>
			<td>$row1[pharmacy]</td>
                        <td>$sql68[expiry_date]</td>
			<td>$row1[quantity]</td>
			<td>$rate</td>
			<td>$row1[amount]</td>
			</tr>";
			$tot=$tot+$row1['amount'];
			
                        $paitot=round($tot-$discountamt);
                        $amtwords=no_to_words($paitot);
		}
		$t=$t."<tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Sub Total</td>
		<td>Rs. $tot</td>
		</tr><tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Discount</td>
		<td>Rs. $discountamt</td>
		</tr><tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Paid Total</td>
		<td>Rs. $paitot</td>
		</tr>
                <tr>
		<td colspan='6' style='text-align:left;padding-right:11px;font-size:10px;'>Rs. $amtwords only.</td>
		
		</tr>";
        $t=$t."</table><br/><table width='75%' style='font-size:11px ;padding-top:6px;line-height:10px;line-width:15px;'><tr><td width='50%' style='padding-left:20px;'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>
            <table width='100%' style='font-size:9px;'>
       <tr>
       <td style='text-align:left; font-size:8px;width:50%;'> TERMS AND CONDITIONS:<br/>*All disputes subject to Bilaspur Jurisdiction.<br/>*Medicines without batch number and expiry date will not be taken back.<br/>*Please consult Doctor before using medicines.</td>
       
       </tr>
       </table><table width='100%' style='font-size:9px;padding-top:1px;'>
       <tr>
       <td style='text-align:center; font-size:8px;'> GET WELL SOON </td>
       </tr>
       </table>";
        $t=$t."</body></html>";
    
   
     ?>
<script>
       
function printPage()
{
var html = <?php echo json_encode($t); ?>;

 var printWin = window.open("","","left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0");
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>
      

     <?php
     echo "<script>printPage(); window.close();</script>";
     ?>
     