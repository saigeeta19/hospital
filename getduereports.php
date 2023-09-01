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
  <th>Type</th>
  <th>Amount</th>
  <th>Reason</th>
  <th>Due Cleared By</th>
</tr>
";
$inc=1;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       
       $query=  mysqli_query($con,"SELECT * FROM due_amounts  WHERE date_time LIKE '$cdate%'");
       while($row=  mysqli_fetch_array($query))
       {
           if($row['opd_type']=='inv')
           {
               $tbl="investigation_entry";
           }
           else if($row['opd_type']=='pro')
           {
               $tbl="procedure_entry";
           }
           else if($row['opd_type']=='dpro')
           {
               $tbl="procedure_dental_entry";
           }
           else if($row['opd_type']=='nut')
           {
               $tbl="canteen_entry";
           }
            $query1=  mysqli_query($con,"SELECT * FROM $tbl WHERE bill_number='".$row['bill_number']."'");
               $row1=  mysqli_fetch_array($query1);
               $reason=$row1['due_reason'];
           echo '<tr>  
           <td>'.$inc.'</td>
           <td>'.$row['date_time'].'</td>
          <td>'.$row['bill_number'].'</td>
          <td>'.$row['opd_type'].'</td>
          <td>'.$row['totalamount'].'</td>
          <td>'.$reason.'</td>
          <td>'.$row['entry_person'].'</td>
           
           </tr>';
            $inc++;
       }
      
       
}


?>