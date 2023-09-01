<?php
include 'connection.php';
$cdate=$_REQUEST['app_date'];

$inc=1;$totalexpenses=0;
?>
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">IP Total Cash Report (<?php echo $cdate; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>Bill Number</th>
        <th>IP Number</th>        
        <th>Patient Name</th>
        <th>Status</th>
        <th>Details</th>
        <th>Amount</th>
    </tr>
    <?php

       $query=mysqli_query($con,"SELECT * FROM deposits WHERE date LIKE '$cdate%' ");
       while($row=mysqli_fetch_array($query))
       {
           $uid=$row['patient_id'];
           $patient_ip_id=$row['patient_ip_id'];
           $date=$row['date'];
		   $mode=$row['mode'];
           $bill_number=$row['bill_number'];
           $date = date(" d-M-Y", strtotime('$date'));
           $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];    
            $amount=$row['amount'];  
            $amount=abs('$amount');
            $id=$row['id'];
             echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$bill_number</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$patient_name</td>
             <td align='center'>$row[status]</td>
             ";
                  if($mode=="Card")
             {
                  echo "<td align='center'>$mode/$row[bank_name]/$row[holder_name]</td>";
             }
             else if($mode=="Cheque")
             {
                  echo "<td align='center'>$mode/$row[bank_name]/$row[holder_name]/$row[cheque_number]</td>";
             }
             else
             {
                 echo "<td align='center'>$mode</td>";
             }
             
             echo "   
             <td align='center'>Rs. $amount</td>
             
           </tr>
           ";
          
           $inc++;
       }
       
       $sql37=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && (status!='CR'AND status!='FSREF')");
       $sql38=mysqli_fetch_array($sql37);
       $totalcoll=$totalcoll+$sql38['sum(amount)'];
       
       $sql3=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && mode='Cash' &&  (status!='CR'AND status!='FSREF')");
       $sql2=mysqli_fetch_array($sql3);
       $cashtotal=$cashtotal+$sql2['sum(amount)'];
       
        $sql331=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && mode='Card' &&  (status!='CR'AND status!='FSREF')");
       $sql231=mysqli_fetch_array($sql331);
       $cardtotal=$cardtotal+$sql231['sum(amount)'];
       
        $sql431=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && mode='Cheque' &&  (status!='CR'AND status!='FSREF')");
       $sql432=mysqli_fetch_array($sql431);
       $chequetotal=$chequetotal+$sql432['sum(amount)'];
       
        $sql4=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' &&  status='CM'");
       $sql5=mysqli_fetch_array($sql4);
       $cautiontotal=$cautiontotal+$sql5['sum(amount)'];
       
         $sql6=mysqli_query($con,"SELECT sum(amount) FROM expenses WHERE date LIKE '$cdate%'");
       $sql7=mysqli_fetch_array($sql6);
       $totalexpenses=$totalexpenses+$sql7['sum(amount)'];
       
       $sql=mysqli_query($con,"SELECT * FROM deposits WHERE date LIKE '$cdate%' && (status='CR' OR status='FSREF')");
       while($sql1=mysqli_fetch_array($sql))
       {
       $cautionrefund=$sql1['amount'];
       $cautionrefund=abs('$cautionrefund');
       $ref=$ref+$cautionrefund;
       }
       
       $balance=$cashtotal-$ref;
       $totbal=$balance-$totalexpenses;

echo "<tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Collection</td>
<td style='text-align:center;'>Rs. $totalcoll</td>
<td></td>
</tr>
<tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Cheque Collection</td>
<td style='text-align:center;'>Rs. $chequetotal</td>
<td></td>
</tr>
 <tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Card Collection</td>
<td style='text-align:center;'>Rs. $cardtotal</td>
<td></td>
</tr>
 <tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. $cashtotal</td>
<td></td>
</tr>
<tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Refunds</td>
<td style='text-align:center;'>Rs. $ref</td>
<td></td>
</tr>
<tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Expenses</td>
<td style='text-align:center;'>Rs. $totalexpenses</td>
<td></td>
</tr>
<tr>
<td colspan='7' style='text-align:right; padding-right:10px;'>Total Balance Cash</td>
<td style='text-align:center;'>Rs. $totbal</td>
<td></td>
</tr>
";
echo "</table>";
?>


