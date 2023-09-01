<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
   <th>S.No.</th>
                 <th>Entry on</th>
                <th>Company</th>
                <th>Challan</th>
                <th>Barcode</th>
                <th>Batch Number</th>
                <th>Pharmacy</th>
                <th>Quantity</th>
                <th>Purchase Rate</th>
                <th>Sale Rate</th>
                <th>Expiry </th>
</tr>
";
$inc=1;$amt=0;$dueamount=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE quantity>0 && date_time LIKE '$cdate%' ORDER BY id DESC");
       while($row=mysqli_fetch_array($query))
       {
             $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
				$com=$row['company_name'];
			    $sql67=mysqli_query($con,"SELECT * FROM company_list WHERE id='".$com."'");
			   $sql68=mysqli_fetch_array($sql67);
				
				
                
               
           echo "
           <tr>
             <td align='center'>$inc</td>
                <td align='center'>$row[date_time]</td>
                <td align='center'>$sql68[company_name]</td>
                    <td align='center'>$row[challan_num]</td>
            <td align='center'>$row[barcode]$h</td>
            <td align='center'>$row[batch_number]</td>
            <td align='center'>$row[name]</a></td>
            <td align='center'>$row[quantity]</td>
            <td align='center'>$row[purchase_rate]</td>
            <td align='center'>$row[price]</td>
            <td align='center'>$row[expiry_date]</td>
           </tr>
           ";
         
           $inc++;
       }
}   



?>