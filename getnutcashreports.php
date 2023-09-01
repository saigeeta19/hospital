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
  <th>IP Number</th>
  <th>UID</th>
  <th>Patient Name</th>
  <th>Amount</th>
  </tr>
";
$inc=1;$amt=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE discharge_date LIKE '$cdate%'");
        while($row=mysqli_fetch_array($query))
       {
             $date=$row['discharge_date'];
             $dischargedate = date(" d-M-Y h:i a", strtotime($date));
             $uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                $patient_ip_id=$row['patient_ip_id'];
                $sql2=  mysqli_query($con,"SELECT sum(amount) FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."'");
                $sql3=mysqli_fetch_array($sql2);
                $tamount=$sql3['sum(amount)'];
                if($tamount!="")
                {          
                 echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$dischargedate</td>
             <td align='center'>$patient_ip_id</td>
             <td align='center'>$uid</td>
             <td align='center'>$patient_name</td>
             <td align='center'>Rs. $tamount</td>
             
           </tr>
           ";
           $amt=$amt+$tamount;
           $inc++;
                }
                
       }
}    
echo "<tr>
<td colspan='5' align='right'>Total Cash Collected</td>
<td>Rs. ".$amt."</td>

</tr>";


?>