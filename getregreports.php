<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
  <th>S.no</th>
  <th>DOR</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Phone</th>
  <th>Entry By</th>
</tr>
";
$inc=1;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patients WHERE date LIKE '$cdate%'");
       while($row=mysqli_fetch_array($query))
       {
            $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
               
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$row[uid]</td>
             <td align='center'>$row[name]</td>
             <td align='center'>$row[phone_number]</td>
             <td align='center'>$row[entry_person]</td>
           </tr>
           ";
           $inc++;
       }
}     
?>