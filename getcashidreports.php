<?php
include 'session.php';
include 'connection.php';

$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
 $entry_person=$entry1['name'];
$date=$_REQUEST['app_date'];
$query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."'");
$inc=1;
?>
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Consultation Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Doctor</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row=mysqli_fetch_array($query))
{
    $uid=$row['patient_id'];
    $sql23=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
    $sql24=mysqli_fetch_array($sql23);
    $pname=$sql24['name'];
  if($row['status']=="opd")
  {
      $h="";
  }  
  else {
      $h="<br/>".$row['status'];
  }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row['bill_number'].$h."</td>
        <td align='center'>".$pname."</td>
        <td align='center'>".$row['doctor']."</td>
        <td align='center'>Rs. ".$row['doctor_fees']."</td>
        <td align='center'>".$row['entry_person']."</td>
    </tr>
    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(doctor_fees) FROM opd_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(doctor_fees)'];
;


echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td></tr>

</table>";
?>
<?php
$query1=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");
if(mysqli_num_rows($query1)>0)
{
?>

<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">INV Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Investigation</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row1=mysqli_fetch_array($query1))
{
    $bill_number=$row1['bill_number'];
				$invname="";
				//$sql2=mysqli_query("SELECT sum(investigation_fees) FROM investigation_entry WHERE  ")
				$sql=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$invname=$invname.$sql1['investigation']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysqli_fetch_array($sql2);
				$amt=$sql3['sum(investigation_fees)'];
                $uid=$row1['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                if($row['status']=="inv")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row['status'];
                }
              
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row1['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$invname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row1['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(investigation_fees)'];
;


echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td></tr>

</table>";
}
?>



<?php
$query2=mysqli_query($con,"SELECT * FROM procedure_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");
if(mysqli_num_rows($query2)>0)
{
?>

<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">PRO Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row2=mysqli_fetch_array($query2))
{
    $bill_number=$row2['bill_number'];
				$proname="";
				
				$sql=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$proname=$proname.$sql1['procedure']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysqli_fetch_array($sql2);
				$amt=$sql3['sum(procedure_fees)'];
                $uid=$row2['patient_id'];
                $sql4=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql14=mysqli_fetch_array($sql4);
                $patient_name=$sql14['name'];
                if($row['status']=="pro")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row['status'];
                }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(procedure_fees)'];
;
echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td></tr>

</table>";
}
?>
    
<?php
$query2=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");
if(mysqli_num_rows($query2)>0)
{
?>

<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Dental PRO Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row2=mysql_fetch_array($query2))
{
    $bill_number=$row2['bill_number'];
				$proname="";
				
				$sql=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$proname=$proname.$sql1['dental_name']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysqli_fetch_array($sql2);
				$amt=$sql3['sum(dental_fees)'];
                $uid=$row2['patient_id'];
                $sql4=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql14=mysqli_fetch_array($sql4);
                $patient_name=$sql14['name'];
                if($row['status']=="pro")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row['status'];
                }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(dental_fees)'];
;
echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td></tr>

</table>";
}
?>    
    
    

 <?php
$query2=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$date%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");
if(mysqli_num_rows($query2)>0)
{
?>

<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Canteen Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
       
        <th>Bill</th>
         
        <th>Nutrition</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row2=mysqli_fetch_array($query2))
{
    $bill_number=$row2['bill_number'];
				$canname="";
				
				$sql=mysqli_query($con,"SELECT * FROM canteen_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$canname=$canname.$sql1['canteen']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysqli_fetch_array($sql2);
				$amt=$sql3['sum(amount)'];
               
                
                
                if($row['status']=="can")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row['status'];
                }
              
    echo "
    <tr>
        <td align='center'>".$inc."</td>
       
        <td align='center'>".$row2['bill_number'].$h."</td>
      
        <td align='center'>".$canname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(amount)'];
;


echo "<tr><td colspan='3' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td></tr>

</table>";
}

?>   


