<?php
include 'connection.php';
$fdate=$_POST['from_date'];
$fdate=strtotime($fdate);
$tdate=$_POST['to_date'];
$tdate=strtotime($tdate);
$entry=$_POST['entry'];
$entry45=mysqli_query($con,"SELECT * FROM users WHERE username='".$entry."'");
$entry1=mysqli_fetch_array($entry45);
$entry_person=$entry1['name'];

if($entry=="all")
{
   $inc=1;$cashtotal=0;$ref=0;$cautiontotal=0;
?>
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Consultation Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
         <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Doctor</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
<?php
$contotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
      $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' ");
$inc=1;
?>


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
        <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row['bill_number'].$h."</td>
        <td align='center'>".$pname."</td>
        <td align='center'>".$row['doctor']."</td>
        <td align='center'>Rs. ".$row['doctor_fees']."</td>
        <td align='center'>".$row['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $contotal=$contotal+$row['doctor_fees'];
  }
}




echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$contotal."/-</td><td></td></tr>

</table>";
?>
  <p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">INV Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
         <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Investigation</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>  
<?php
$invtotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query1=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%'  GROUP BY bill_number ORDER BY id DESC");

?>


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
            <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row1['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$invname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row1['entry_person']."</td>
        
    </tr>

    ";
    $invtotal=$invtotal+$amt;
    $inc++;
}

}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$invtotal."/-</td><td></td></tr>

</table>";

?>


<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">PRO Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
<?php
$prototal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM procedure_entry WHERE date LIKE '$cdate%'  GROUP BY bill_number ORDER BY id DESC");

?>


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
            <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $prototal=$prototal+$amt;
  }
}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$prototal."/-</td><td></td></tr>

</table>";

?>
   
    
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Dental PRO Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>    
<?php
$dentotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE date LIKE '$cdate%'  GROUP BY bill_number ORDER BY id DESC");

?>


    <?php
while($row2=mysqli_fetch_array($query2))
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
             <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $dentotal=$dentotal+$amt;
  }
}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$dentotal."/-</td><td></td></tr>

</table>";

?>    
    
   <p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Canteen Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
       <th>Date</th>
        <th>Bill</th>
         
        <th>Nutrition</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr> 

 <?php
 $cantotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$cdate%'  GROUP BY bill_number ORDER BY id DESC");

?>


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
            <td align='center'>".$cdate."</td>
       
        <td align='center'>".$row2['bill_number'].$h."</td>
      
        <td align='center'>".$canname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
    $cantotal=$cantotal+$amt;
  }


}

echo "<tr><td colspan='4' align='center'>Total Amount</td><td align='center'>Rs.".$cantotal."/-</td><td></td></tr>

</table>";
 
}
 else {
    


$inc=1;$cashtotal=0;$ref=0;$cautiontotal=0;
?>
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Consultation Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
         <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Doctor</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
<?php
$contotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
      $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && entry_person='".$entry_person."'");
$inc=1;
?>


    <?php
while($row=mysqli_fetch_array($query))
{
    $uid=$row['patient_id'];
    $sql23=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
    $sql24=mysqli_fetch_array($sql23);
    $pname=$sql24['name'];
  if($row[status]=="opd")
  {
      $h="";
  }  
  else {
      $h="<br/>".$row[status];
  }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row['bill_number'].$h."</td>
        <td align='center'>".$pname."</td>
        <td align='center'>".$row['doctor']."</td>
        <td align='center'>Rs. ".$row['doctor_fees']."</td>
        <td align='center'>".$row['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $contotal=$contotal+$row['doctor_fees'];
  }
}




echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$contotal."/-</td><td></td></tr>

</table>";
?>
  <p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">INV Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
         <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Investigation</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>  
<?php
$invtotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query1=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$cdate%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");

?>


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
                if($row[status]=="inv")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row[status];
                }
              
    echo "
    <tr>
        <td align='center'>".$inc."</td>
            <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row1['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$invname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row1['entry_person']."</td>
        
    </tr>

    ";
    $invtotal=$invtotal+$amt;
    $inc++;
}

}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$invtotal."/-</td><td></td></tr>

</table>";

?>


<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">PRO Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>
<?php
$prototal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM procedure_entry WHERE date LIKE '$cdate%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");

?>


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
				$sql3=mysql_fetch_array($sql2);
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
            <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $prototal=$prototal+$amt;
  }
}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$prototal."/-</td><td></td></tr>

</table>";

?>
   
    
<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Dental PRO Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Procedure</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr>    
<?php
$dentotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE date LIKE '$cdate%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");

?>


    <?php
while($row2=mysqli_fetch_array($query2))
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
                if($row[status]=="pro")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row[status];
                }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
             <td align='center'>".$cdate."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_person']."</td>
    </tr>
    ";
    $inc++;
    $dentotal=$dentotal+$amt;
  }
}


echo "<tr><td colspan='6' align='center'>Total Amount</td><td align='center'>Rs.".$dentotal."/-</td><td></td></tr>

</table>";

?>    
    
   <p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">Canteen Cash Report </p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
       <th>Date</th>
        <th>Bill</th>
         
        <th>Nutrition</th>
        <th>Amount</th>
        <th>Entry By</th>
    </tr> 

 <?php
 $cantotal=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
$query2=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$cdate%' && entry_person='".$entry_person."' GROUP BY bill_number ORDER BY id DESC");

?>


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
            <td align='center'>".$cdate."</td>
       
        <td align='center'>".$row2['bill_number'].$h."</td>
      
        <td align='center'>".$canname."</td>
        <td align='center'>Rs. ".$amt."</td>
        <td align='center'>".$row2['entry_persons']."</td>
        
    </tr>

    ";
    $inc++;
    $cantotal=$cantotal+$amt;
  }


}

echo "<tr><td colspan='4' align='center'>Total Amount</td><td align='center'>Rs.".$cantotal."/-</td><td></td></tr>

</table>";


 }
?>
