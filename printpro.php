 <?php 
 include 'session.php';
 include 'connection.php';
 $logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
 $bill=$_GET['bill'];
 
 $query=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
     $row=mysqli_fetch_array($query);
    
     $patient_id=$row['patient_id'];
	 $age=$row['age'];
	 $gender=$row['gender'];
     
      $procedure_fees=$row['procedure_fees'];
     
     $date=$row['date'];
     $date = date("d-M-Y", strtotime($date));
   	 $uid=$patient_id;
                $sql45=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql15=mysqli_fetch_array($sql45);
                $patient_name=$sql15['name'];
                
                
                 $query23=mysqli_query($con,"SELECT * FROM procedures_discounts WHERE bill_number='".$bill."'");
        $row23=  mysqli_fetch_array($query23);
	$inc=1; $tot=0;
    $t="<html><table width='75%' style='font-size:14px ;padding-top:100px;padding-left:90px;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:center; font-size:18px;padding-left:100px; text-decoration:underline;' colspan='4'> OPD BILL </th>
       </tr>
       <tr>
       <th style='text-align:center; font-size:16px;padding-left:100px; text-decoration:underline;' colspan='4'> INVOICE </th>
       </tr>
       <th style='text-align:right;padding-right:10px;'>Date:  </th>
       <td>$date</td>
       <th style='text-align:right;padding-right:10px;'>Bill Number:</th>
       <td>$bill</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;'>Patient Name: </th>
       <td>$patient_name</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Age: </th>
       <td>$age</td>
       <th style='text-align:right;padding-right:10px;'>Gender: </th>
       <td>$gender</td>
       </tr>
       </table>
       <table width='70%' border='1' style='border-collapse:collapse;font-size:14px;margin-left:100px;padding-left:120px;text-align:center;line-height:20px;line-width:15px;'>
       <tr>
        <th width='5%'>S.No.</th>
        <th width='70%'>Description</th>
        <th  width='20%'>Amount</th>
	   </tr>
	    ";
	    $query1=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
	  while($row1=mysqli_fetch_array($query1))
		{
	    $pro1=$row1['procedure'];
	    $amt=$row1['procedure_fees'];
			$t=$t."<tr>
			<td>$inc</td>
			<td>$pro1</td>
			<td>Rs. $amt</td>
			</tr>";
			$tot=$tot+$amt;
		$inc++;	
		}
                  $dis=$row23['discount_amount'];
                if($dis=="")
                {
                    $dis=0;
                }
                $to=$tot-$dis;
		$t=$t."<tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Total</td>
		<td>Rs. $tot</td>
		</tr> 
                <tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Discount</td>
		<td>Rs. $dis</td>
		</tr><tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Total</td>
		<td>Rs. $to</td>
		</tr>";
        $t=$t."</table><br/><table width='75%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $t=$t."</html>";
    
    
   
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
     