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
  <th>Bill Number</th>
  <th>Nutrition</th>
  <th>Amount</th>
  <th>Entry By</th>
</tr>
";
$inc=1;$amt=0;$dueamount=0;$discountamt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $sql21=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_dental_discounts WHERE date LIKE '$cdate%'");
				$sql31=mysqli_fetch_array($sql21);
				$amount=$sql31['sum(discount_amount)'];
                                $discountamt=$discountamt+$amount;
       $query=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$cdate%' GROUP BY bill_number ORDER BY id DESC");
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				$bill_number=$row['bill_number'];
				$canname="";
				
				$sql=mysqli_query($con,"SELECT * FROM canteen_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$canname=$canname.$sql1['canteen']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysqli_fetch_array($sql2);
				$amount=$sql3['sum(amount)'];
                
                
                if($row['status']=="can")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row['status'];
                }
                
                
                  $ghd=  mysqli_query($con,"SELECT * FROM due_amounts WHERE bill_number='".$row[bill_number]."' && opd_type='nut'");
                if(mysqli_num_rows($ghd)>0)
                {
                    // $d="<br/>(Due)";
                   // $k="<br/><a href='changestatus.php?type=pro&bill=".$row[bill_number]."'><input type='button' value='Change' /></a>";
                  //  $dueamount=$dueamount+$amount;
                }
                else
                {
                      if($row[due_status]==0)
                {
                    $d="<br/>(Due)";
                      $k="<br/><a href='changestatus.php?type=nut&bill=".$row['bill_number']."'><input type='button' value='Change' /></a>";
                    $dueamount=$dueamount+$amount;
                }
                else
                {
                    $d="";
                    $k="";
                }
                }
               
              
               
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$row[bill_number]</td>
            
             <td align='center'>$canname</td>
             <td align='center'>Rs. $amount $d $k</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $amt=$amt+$amount;
           $inc++;
       }
}    
$cashbalance=($amt-$dueamount)-$discountamt;
echo "<tr>
<td colspan='4' style='text-align:right; padding-right:10px;'>Total Collection</td>
<td style='text-align:center;'>Rs. $amt</td>
<td></td>
</tr>";
echo "<tr>
<td colspan='4' style='text-align:right; padding-right:10px;'>Total Cash Due</td>
<td style='text-align:center;'>Rs. $dueamount</td>
<td></td>
</tr>";
echo "<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Discounts</td>
<td style='text-align:center;'>Rs. $discountamt</td>
<td></td>
</tr>";
echo "<tr>
<td colspan='4' style='text-align:right; padding-right:10px;'>Total Cash Collection</td>
<td style='text-align:center;'>Rs. $cashbalance</td>
<td></td>
</tr>";
?>