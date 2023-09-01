
<style>
    #breakres
    {
        text-align:center;
        font-weight:bold;
        font-size:18px;
    }
</style>
<?php include("connection.php"); 

echo '<p style="font-size: 20px; width:100%; text-align:center;padding-bottom: 20px; padding-top:20px;">IP Pharmacy</p>';
echo '<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">';

function thours($start,$end)
{
  $t1=strtotime($start);
  $t2=strtotime($end);
  $v = $t2 - $t1;
  $v = $v / ( 60 * 60 ); 
  return  floor($v);
}
 
 $phours=0;
 $trent=0;
 $regcharge=200;
 $dischargedate=date("d-m-Y H:i:s");
 $patient_ip_id=$_GET["ip"];
 $query=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
 $admission_date=$result['admission_date'];
 $under_doctor=$result['admit_under_doctor'];
 $uid=$result['patient_id'];
 $co=explode(",",$under_doctor);
   //emergency check
 $to="08:00";
   $from="21:00";
   $mid1="23:59";
   $mid="00:00";
   $input = date("H:i", strtotime($admission_date));
    if (strtotime($input) > strtotime($from) && strtotime($input) < strtotime($mid1)) 
        {
            $emer_charge=1000; 
        }
    elseif (strtotime($mid) < strtotime($input) && strtotime($input) < strtotime($to))
     {
        $emer_charge=1000;
    }
    else
        {
            $emer_charge=0;
        }
     
 //patientdetail
      echo " <tr>
 <td id='breakres'>Patient IP</td>
 <td  id='breakres'>$patient_ip_id</td>
 
 <td id='breakres'>Admission Date/Discharge Date</td>
 <td  id='breakres'>".$result['admission_date']."/".$result['discharge_date']."</td>
 </tr>";

$query128=mysqli_query($con,"SELECT * FROM attenders WHERE patient_ip_id='".$patient_ip_id."'");
$row128=mysqli_fetch_array($query128);

echo " <tr>
 <td id='breakres'>Attendar Name</td>
 <td  id='breakres'>".$row128['attender_name']."</td>
     <td id='breakres'>Attendar Address</td>
 <td  id='breakres'>".$row128['attender_address']."</td>
 </tr>";

echo " <tr>
 <td id='breakres'>Attendar Contact</td>
 <td  id='breakres'>".$row128['attender_contact']."</td>
 
 <td id='breakres'>Under Doctor</td>
 <td  id='breakres'>".$result['admit_under_doctor']."</td>
 </tr>";

   echo '</table>';     
 echo '<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">';       
        ?>
<tr>
    <th>S.no.</th>
    <th>PID</th>
    <th>Date</th>
    <th>Barcode</th>
    <th>Pharmacy</th>
    <th>Quantity</th>
    <th>Amount</th>
</tr>

        <?php
        $inc=1;$tamount=0;
        $query133=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE patient_id='".$uid."'");
while($row133=mysqli_fetch_array($query133))
{
    echo "<tr><td>".$inc."</td>
        <td>".$row133['pid']."</td>
        <td>".$row133['date']."</td>
        <td>".$row133['barcode']."</td>
        <td>".$row133['pharmacy']."</td>
        <td>".$row133['quantity']."</td>
        <td>".$row133['amount']."</td>
        </tr>";
    $tamount=$tamount+$row133['amount'];
    $inc++;
}

echo "<tr><td colspan='6' align='center'>Total Amount</td><td>Rs. ".round($tamount)."</td></tr>";




 echo "</table>";