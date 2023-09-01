<?php
include 'connection.php';
$date=$_REQUEST['app_date'];
$query=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$date%'");
$inc=1;
$total1=0;
$totalcheque1=0;
$totalcard1=0;
$totaldue=0;

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
        <th>Details</th>
        <th>Entry By</th>
    </tr>
    <?php
while($row=mysqli_fetch_array($query))
{
    
    $uid=$row['patient_id'];
    $sql23=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
    $sql24=mysqli_fetch_array($sql23);
    $pname=$sql24['name'];
    //if($row[due_status]==0)
    //{
   //      $d="<br/>(Due)";
   //     $totaldue=$totaldue+$row[doctor_fees];
   // }
   // else
  //  {
   //     $d="";
   // }
  if($row['status']=="opd")
  {
      $h="";
  }  
  else {
      $h="<br/>".$row['status'];
  }
  
  $mode=$row[mode];
  if($mode=="Card")
  {
      $mode=$mode."/".$row['bank_name']."/".$row['holder_name'];
  }
  else if($mode=="Cheque")
  {
       $mode=$mode."/".$row['bank_name']."/".$row['holder_name']."/".$row['cheque_number'];
  }
  else if($mode=="Cash")
  {
      $mode=$mode;
  }
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row['bill_number'].$h."</td>
        <td align='center'>".$pname."</td>
        <td align='center'>".$row['doctor']."</td>
        <td align='center'>Rs. ".$row['doctor_fees']."</td>
        <td align='center'>".$mode."</td>
        <td align='center'>".$row['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }


$sql2=mysqli_query($con,"SELECT sum(doctor_fees) FROM opd_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(doctor_fees)'];

//Cheque Collection
$sql2ch=mysqli_query($con,"SELECT sum(doctor_fees) FROM opd_entry WHERE date LIKE '$date%' && mode='Cheque'");
$sql3ch=mysqli_fetch_array($sql2ch);
$totalcheque=$sql3ch['sum(doctor_fees)'];

//Card Collection
$sql2ca=mysqli_query($con,"SELECT sum(doctor_fees) FROM opd_entry WHERE date LIKE '$date%' && mode='Card'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totalcard=$sql3ca['sum(doctor_fees)'];

$totalcash=$total-($totalcard+$totalcheque);

$total1=$total1+$total;
$totalcheque1=$totalcheque1+$totalcheque;
$totalcard1=$totalcard1+$totalcard;
if($totalcheque=="") 
{
    $totalcheque=0;
}
if($totalcard=="") 
{
    $totalcard=0;
}
;


echo "<tr><td colspan='5' align='center'>Total Collection</td><td align='center'>Rs.".$total."/-</td><td></td><td></td></tr>
<tr><td colspan='5' align='center'>Total Cheque Collection</td><td align='center'>Rs.".$totalcheque."/-</td><td></td><td></td></tr>
    <tr><td colspan='5' align='center'>Total Card Collection</td><td align='center'>Rs.".$totalcard."/-</td><td></td><td></td></tr>
        <tr><td colspan='5' align='center'>Total Cash Collection</td><td align='center'>Rs.".$totalcash."/-</td><td></td><td></td></tr>
           
</table>";
?>
<?php
$query1=mysqli_query($con,"SELECT * FROM investigation_entry WHERE date LIKE '$date%' GROUP BY bill_number ORDER BY id DESC");
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
        <th>Details</th>
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
                                
                                $sql21=mysqli_query($con,"SELECT sum(discount_amount) FROM investigations_discounts WHERE bill_number='".$bill_number."'");
				$sql31=mysqli_fetch_array($sql21);
				$disamt=$sql31['sum(discount_amount)'];
                                
                $uid=$row1['patient_id'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                
                if($row1['due_status']==0)
                {
                      $d="<br/>(Due)";
                    $totaldue=$totaldue+$amt;
                }
                else
                {
                    $d="";
                }
                if($row1['status']=="inv")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row1['status'];
                }
                 $mode=$row1['mode'];
  if($mode=="Card")
  {
      $mode=$mode."/".$row1['bank_name']."/".$row1['holder_name'];
  }
  else if($mode=="Cheque")
  {
       $mode=$mode."/".$row1['bank_name']."/".$row1['holder_name']."/".$row1['cheque_number'];
  }
  else if($mode=="Cash")
  {
      $mode=$mode;
  }
      $to=$amt-$disamt;        
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row1['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$invname."</td>
        <td align='center'>Rs. ".$to.$d."</td>
        <td align='center'>".$mode."</td>
        <td align='center'>".$row1['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }




//Discounts
$sql2ca=mysqli_query($con,"SELECT sum(discount_amount) FROM investigations_discounts WHERE date LIKE '$date%'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totaldiscount=$sql3ca['sum(discount_amount)'];


$sql2=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(investigation_fees)']-$totaldiscount;

//Cheque Collection
$sql2ch=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE date LIKE '$date%' && mode='Cheque'");
$sql3ch=mysqli_fetch_array($sql2ch);
$totalcheque=$sql3ch['sum(investigation_fees)'];

//Card Collection
$sql2ca=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE date LIKE '$date%' && mode='Card'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totalcard=$sql3ca['sum(investigation_fees)'];

$totalcash=$total-($totalcard+$totalcheque);


$total1=$total1+$total;
$totalcheque1=$totalcheque1+$totalcheque;
$totalcard1=$totalcard1+$totalcard;
if($totalcheque=="") 
{
    $totalcheque=0;
}
if($totalcard=="") 
{
    $totalcard=0;
}
;


echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td><td></td></tr>
    <tr><td colspan='5' align='center'>Total Discounts</td><td align='center'>Rs.".$totaldiscount."/-</td><td></td><td></td></tr>
<tr><td colspan='5' align='center'>Total Cheque Collection</td><td align='center'>Rs.".$totalcheque."/-</td><td></td><td></td></tr>
    <tr><td colspan='5' align='center'>Total Card Collection</td><td align='center'>Rs.".$totalcard."/-</td><td></td><td></td></tr>
        <tr><td colspan='5' align='center'>Total Cash Collection</td><td align='center'>Rs.".$totalcash."/-</td><td></td><td></td></tr>
</table>";
}
?>



<?php
$query2=mysqli_query($con,"SELECT * FROM procedure_entry WHERE date LIKE '$date%' GROUP BY bill_number ORDER BY id DESC");
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
        <th>Details</th>
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
				$sql3=mysql_fetch_array($sql2);
				$amt=$sql3['sum(procedure_fees)'];
                                
                                  $sql21=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_discounts WHERE bill_number='".$bill_number."'");
				$sql31=mysqli_fetch_array($sql21);
				$disamt=$sql31['sum(discount_amount)'];
                $uid=$row2['patient_id'];
                $sql4=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql14=mysqli_fetch_array($sql4);
                $patient_name=$sql14['name'];
                if($row2['due_status']==0)
                {
                      $d="<br/>(Due)";
                    $totaldue=$totaldue+$amt;
                }
                else
                {
                    $d="";
                }
                
                if($row2['status']=="pro")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row2['status'];
                }
                 $mode=$row2['mode'];
  if($mode=="Card")
  {
      $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name'];
  }
  else if($mode=="Cheque")
  {
       $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name']."/".$row2['cheque_number'];
  }
  else if($mode=="Cash")
  {
      $mode=$mode;
  }
            $to=$amt-$disamt;            
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$to."</td>
        <td align='center'>".$mode."</td>
        <td align='center'>".$row2['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }

//Discounts
$sql2ca=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_discounts WHERE date LIKE '$date%'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totaldiscount=$sql3ca['sum(discount_amount)'];

$sql2=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(procedure_fees)']-$totaldiscount;

//Cheque Collection
$sql2ch=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE date LIKE '$date%' && mode='Cheque'");
$sql3ch=mysqli_fetch_array($sql2ch);
$totalcheque=$sql3ch['sum(procedure_fees)'];

//Card Collection
$sql2ca=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE date LIKE '$date%' && mode='Card'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totalcard=$sql3ca['sum(procedure_fees)'];

$totalcash=$total-($totalcard+$totalcheque);

$total1=$total1+$total;
$totalcheque1=$totalcheque1+$totalcheque;
$totalcard1=$totalcard1+$totalcard;
if($totalcheque=="") 
{
    $totalcheque=0;
}
if($totalcard=="") 
{
    $totalcard=0;
}
;


echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td><td></td></tr>
       <tr><td colspan='5' align='center'>Total Discounts</td><td align='center'>Rs.".$totaldiscount."/-</td><td></td><td></td></tr>
<tr><td colspan='5' align='center'>Total Cheque Collection</td><td align='center'>Rs.".$totalcheque."/-</td><td></td><td></td></tr>
    <tr><td colspan='5' align='center'>Total Card Collection</td><td align='center'>Rs.".$totalcard."/-</td><td></td><td></td></tr>
        <tr><td colspan='5' align='center'>Total Cash Collection</td><td align='center'>Rs.".$totalcash."/-</td><td></td><td></td></tr>
</table>";
}
?>
    
    
    <?php
$query2=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE date LIKE '$date%' GROUP BY bill_number ORDER BY id DESC");
if(mysqli_num_rows($query2)>0)
{
?>

<p align="center" style="font-size:20px;font-weight:bold;text-decoration:underline;">PRO Dental Cash Report (<?php echo $date; ?>)</p>
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <th>S.No.</th>
        <th>UID</th>
        <th>Bill</th>
        <th>Name</th>        
        <th>Dental</th>
        <th>Amount</th>
        <th>Details</th>
        <th>Entry By</th>
    </tr>
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
                                
                                  $sql21=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_dental_discounts WHERE bill_number='".$bill_number."'");
				$sql31=mysqli_fetch_array($sql21);
				$disamt=$sql31['sum(discount_amount)'];
                                
                $uid=$row2['patient_id'];
                $sql4=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql14=mysqli_fetch_array($sql4);
                $patient_name=$sql14['name'];
                
                if($row2['due_status']==0)
                {
                      $d="<br/>(Due)";
                    $totaldue=$totaldue+$amt;
                }
                else
                {
                    $d="";
                }
                if($row2['status']=="pro")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row2['status'];
                }
                 $mode=$row2['mode'];
  if($mode=="Card")
  {
      $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name'];
  }
  else if($mode=="Cheque")
  {
       $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name']."/".$row2['cheque_number'];
  }
  else if($mode=="Cash")
  {
      $mode=$mode;
  }
         $to=$amt-$disamt;        
    echo "
    <tr>
        <td align='center'>".$inc."</td>
        <td align='center'>".$uid."</td>
        <td align='center'>".$row2['bill_number'].$h."</td>
        <td align='center'>".$patient_name."</td>
        <td align='center'>".$proname."</td>
        <td align='center'>Rs. ".$to.$d."</td>
        <td align='center'>".$mode."</td>
        <td align='center'>".$row2['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }
//Discounts
$sql2ca=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_dental_discounts WHERE date LIKE '$date%'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totaldiscount=$sql3ca['sum(discount_amount)'];

$sql2=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(dental_fees)']-$totaldiscount;

//Cheque Collection
$sql2ch=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE date LIKE '$date%' && mode='Cheque'");
$sql3ch=mysqli_fetch_array($sql2ch);
$totalcheque=$sql3ch['sum(dental_fees)'];

//Card Collection
$sql2ca=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE date LIKE '$date%' && mode='Card'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totalcard=$sql3ca['sum(dental_fees)'];

$totalcash=$total-($totalcard+$totalcheque);

$total1=$total1+$total;
$totalcheque1=$totalcheque1+$totalcheque;
$totalcard1=$totalcard1+$totalcard;
if($totalcheque=="") 
{
    $totalcheque=0;
}
if($totalcard=="") 
{
    $totalcard=0;
}
;


echo "<tr><td colspan='5' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td><td></td></tr>
       <tr><td colspan='5' align='center'>Total Discounts</td><td align='center'>Rs.".$totaldiscount."/-</td><td></td><td></td></tr>
<tr><td colspan='5' align='center'>Total Cheque Collection</td><td align='center'>Rs.".$totalcheque."/-</td><td></td><td></td></tr>
    <tr><td colspan='5' align='center'>Total Card Collection</td><td align='center'>Rs.".$totalcard."/-</td><td></td><td></td></tr>
        <tr><td colspan='5' align='center'>Total Cash Collection</td><td align='center'>Rs.".$totalcash."/-</td><td></td><td></td></tr>
</table>";
}
?>




<?php
$query2=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$date%' GROUP BY bill_number ORDER BY id DESC");
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
        <th>Details</th>
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
                                
                                  $sql21=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_dental_discounts WHERE bill_number='".$bill_number."'");
				$sql31=mysqli_fetch_array($sql21);
				$disamt=$sql31['sum(discount_amount)'];
               
               if($row2['due_status']==0)
                {
                     $d="<br/>(Due)";
                    $totaldue=$totaldue+$amt;
                } 
                else
                {
                    $d="";
                }
                
                if($row2['status']=="can")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row2['status'];
                }
                 $mode=$row2['mode'];
  if($mode=="Card")
  {
      $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name'];
  }
  else if($mode=="Cheque")
  {
       $mode=$mode."/".$row2['bank_name']."/".$row2['holder_name']."/".$row2['cheque_number'];
  }
  else if($mode=="Cash")
  {
      $mode=$mode;
  }
             $to=$amt-$disamt;     
    echo "
    <tr>
        <td align='center'>".$inc."</td>
       
        <td align='center'>".$row2['bill_number'].$h."</td>
      
        <td align='center'>".$canname."</td>
        <td align='center'>Rs. ".$to.$d."</td>
             <td align='center'>".$mode."</td>
        <td align='center'>".$row2['entry_person']."</td>
        
    </tr>

    ";
    $inc++;
  }

//Discounts
$sql2ca=mysqli_query($con,"SELECT sum(discount_amount) FROM canteen_discounts WHERE date LIKE '$date%'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totaldiscount=$sql3ca['sum(discount_amount)'];

$sql2=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE date LIKE '$date%'");
$sql3=mysqli_fetch_array($sql2);
$total=$sql3['sum(amount)']-$totaldiscount;

//Cheque Collection
$sql2ch=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE date LIKE '$date%' && mode='Cheque'");
$sql3ch=mysqli_fetch_array($sql2ch);
$totalcheque=$sql3ch['sum(amount)'];

//Card Collection
$sql2ca=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE date LIKE '$date%' && mode='Card'");
$sql3ca=mysqli_fetch_array($sql2ca);
$totalcard=$sql3ca['sum(amount)'];

$totalcash=$total-($totalcard+$totalcheque);

$total1=$total1+$total;
$totalcheque1=$totalcheque1+$totalcheque;
$totalcard1=$totalcard1+$totalcard;
if($totalcheque=="") 
{
    $totalcheque=0;
}
if($totalcard=="") 
{
    $totalcard=0;
}
;


echo "<tr><td colspan='3' align='center'>Total Amount</td><td align='center'>Rs.".$total."/-</td><td></td><td></td></tr>
     <tr><td colspan='5' align='center'>Total Discounts</td><td align='center'>Rs.".$totaldiscount."/-</td><td></td><td></td></tr>
<tr><td colspan='3' align='center'>Total Cheque Collection</td><td align='center'>Rs.".$totalcheque."/-</td><td></td><td></td></tr>
    <tr><td colspan='3' align='center'>Total Card Collection</td><td align='center'>Rs.".$totalcard."/-</td><td></td><td></td></tr>
        <tr><td colspan='3' align='center'>Total Cash Collection</td><td align='center'>Rs.".$totalcash."/-</td><td></td><td></td></tr>
</table>";
}
$totalcash1=$total1-($totalcard1+$totalcheque1);

//after deducting Due
$tocashfin=$totalcash1-$totaldue;

//Due Collection of Previous Transactions
$d=mysqli_query($con,"SELECT sum(totalamount) FROM due_amounts WHERE date_time LIKE '$date%'");
$e=mysqli_fetch_array($d);
$duecollectionprev=$e['sum(totalamount)'];


?>
    
<table id="table1" width="100%" border="1" align="center" cellpadding="2" cellspacing="3" style="border-collapse: collapse;">
    <tr>
        <td>Total Collection</td>
        <td>Rs. <?php echo $total1; ?></td>
    </tr>
    <tr>
        <td>Total Due Collection</td>
        <td>Rs. <?php echo $totaldue; ?></td>
    </tr>
    <tr>
        <td>Total Cheque Collection</td>
        <td>Rs. <?php echo $totalcheque1; ?></td>
    </tr>
    <tr>
        <td>Total Card Collection</td>
        <td>Rs. <?php echo $totalcard1; ?></td>
    </tr>
    
    <tr>
        <td>Total Cash Collection</td>
        <td>Rs. <?php echo $tocashfin; ?></td>
    </tr>
      <tr>
        <td>Total Due Collection from Previous Days Transactions</td>
        <td>Rs. <?php echo $duecollectionprev; ?></td>
    </tr>
    
    
</table>
