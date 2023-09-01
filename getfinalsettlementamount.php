
<?php
function thours($start,$end)
{
  $t1=strtotime($start);
  $t2=strtotime($end);
  $v = $t2 - $t1;
  $v = $v / ( 60 * 60 ); 
  return  floor($v);
}
 include "connection.php";
 $phours=0;
 $trent=0;
 $deposit=0;
 $discounts=0;
 $regcharge=200;
 $dischargedate=date("d-m-Y H:i:s");
 $patient_ip_id=$_POST["patient_ip_id"];
 $query=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
 $admission_date=$result['admission_date'];
 $under_doctor=$result['admit_under_doctor'];
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
     
    
echo "<input type='hidden' name='emergency' value='".$emer_charge."' />";
   
   
 
 $query=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' ORDER BY id");
 $tnurse=0;$cons=0;$thousekeeping=0;
 while($row=mysqli_fetch_array($query))
 {
     $starti=$row['admission_date'];
     $endi=$row['leaving_date'];
     $category=$row['category'];
     $ward_name=$row['ward_name'];
     if($endi=="")
     {
         $endi=date("d-m-Y H:i:s");
     }
     $h=thours($starti,$endi);
      $h=floor($h);
	
	 
	
	
    // $chk=ceil($h/24);
     $query1= mysqli_query($con,"SELECT * FROM wards WHERE category='".$category."' && ward_name='".$ward_name."'");
     $row1=mysqli_fetch_array($query1);
     $rent_per=$row1['rent_per_unit'];
     //Nursing Charge
     $nursing_charge=$row1['nursing_charge'];
	  //Hosekeeping Charge
     $housekeeping_charge=$row1['housekeeping_charge'];
     $nh=$h;
     $ni=$h/24;
     $nc=ceil($ni);
     $nursing_amount=$nc*$nursing_charge;
     $tnurse=$tnurse+$nursing_amount;
	 $housekeeping_amount=$nc*$housekeeping_charge;
     $thousekeeping=$thousekeeping+$housekeeping_amount;
     
	 foreach($co as $co1)
	{
    	

		$query90=mysqli_query($con,"SELECT * FROM doctor_ipd_consultation WHERE category_name='".$category."' && ward_name='".$ward_name."' && doctor_name='".$co1."'");
	
	  $query91=mysqli_fetch_array($query90);
	  $conam=$query91['consultation_amount'];
	   $conam=$nc*$conam;
      $cons=$cons+$conam;
	}
	 
	
		  $remainder = $h % 12;
	 
      $quotient = ($h - $remainder) / 12;
      
	  $rent=$quotient*$rent_per/2+$rent_per/2;
	
   
   
     $phours=$phours+$h;
     $trent=$trent+$rent;
 }
 echo "<input type='hidden' name='room_rent' value='".$trent."' />";
 echo "<input type='hidden' name='nursing_charge' value='".$tnurse."' />";
 echo "<input type='hidden' name='housekeeping_charge' value='".$thousekeeping."' />";
 echo "<input type='hidden' name='cons' value='".$cons."' />";
 $trent=$trent+$tnurse+$thousekeeping+$cons;
 $query2=mysqli_query($con,"SELECT sum(amount) FROM investigations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 $row2=mysqli_fetch_array($query2);
 if($row2['sum(amount)']==NULL)
 {
    $investigation_amount= 0;
  
      
 }
 else {
 
     $investigation_amount=$row2['sum(amount)'];
 }
echo "<input type='hidden' name='investigation' value='".$investigation_amount."' />";
$query3=mysqli_query($con,"SELECT sum(amount) FROM discounts WHERE patient_ip_id='".$patient_ip_id."'");
 $row3=mysqli_fetch_array($query3);
 if($row3['sum(amount)']==NULL)
 {
    $discounts= 0;
  
      
 }
 else {
 
     $discounts=$row3['sum(amount)'];
 }
 
echo "<input type='hidden' name='discount' value='".$discounts."' />"; 


$query4=mysqli_query($con,"SELECT sum(amount) FROM procedures_indents WHERE patient_ip_id='".$patient_ip_id."'");
 $row4=mysqli_fetch_array($query4);
 if($row4['sum(amount)']==NULL)
 {
    $procedure_amount= 0;
  
      
 }
 else {
 
     $procedure_amount=$row4['sum(amount)'];
 }
 
 echo "<input type='hidden' name='procedure' value='".$procedure_amount."' />";

 $query5=mysqli_query($con,"SELECT sum(amount) FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."'");
 $row5=mysqli_fetch_array($query5);
 if($row5['sum(amount)']==NULL)
 {
    $equipments_amount= 0;
  
      
 }
 else {
 
     $equipments_amount=$row5['sum(amount)'];
 }
 echo "<input type='hidden' name='equipment' value='".$equipments_amount."' />";
 
 $query6=mysqli_query($con,"SELECT sum(total_amount) FROM ot_entry WHERE patient_ip_id='".$patient_ip_id."'");
 $row6=mysqli_fetch_array($query6);
 if($row6['sum(total_amount)']==NULL)
 {
    $ot_entry= 0;
  
 }
 else {
 
     $ot_entry=$row6['sum(total_amount)'];
 }
echo "<input type='hidden' name='ot_amount' value='".$ot_entry."' />";
 
 $query7=mysqli_query($con,"SELECT sum(amount) FROM consultations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 $row7=mysql_fetch_array($query7);
 if($row7['sum(amount)']==NULL)
 {
    $consultation_amount= 0;
 }
 else 
 {
    $consultation_amount=$row7['sum(amount)'];
 }
 echo "<input type='hidden' name='consultation' value='".$consultation_amount."' />";
 
  $query750=mysqli_query($con,"SELECT sum(amount) FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."'");
 $row750=mysqli_fetch_array($query750);
 if($row750['sum(amount)']==NULL)
 {
    $nutrition_amount= 0;
 }
 else 
 {
    $nutrition_amount=$row750['sum(amount)'];
 }
 
 echo "<input type='hidden' name='nutrition' value='".$nutrition_amount."' />";
 
 $sql33=mysqli_query($con,"SELECT sum(amount) FROM other_entry WHERE patient_ip_id='".$patient_ip_id."'");
 $sql43=mysqli_fetch_array($sql33);
 if($sql43['sum(amount)']==NULL)
 {
    $otheramount=0;
 }
 else 
 {
     $otheramount=$sql43['sum(amount)'];
 }
 
  echo "<input type='hidden' name='otheramt' value='".$otheramount."' />";
 
 

$query8=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREF'");
 $row8=mysqli_fetch_array($query8);
 if($row8['sum(amount)']==NULL)
 {
    $refunds= 0;
 }
 else 
 {
    $refunds=$row8['sum(amount)'];
 }
 
 $caution_deposit=2500;
 
 
 $totalbill1=$emer_charge+$regcharge+$trent+$otheramount+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$consultation_amount+$nutrition_amount;
 $totalbill=($emer_charge+$regcharge+$trent+$otheramount+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$consultation_amount+$nutrition_amount)-$discounts;
 
 echo "<input type='hidden' name='total_bill' value='".$totalbill1."' />";
 
 $sql=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && (status='D' OR status='FSREC')");
 $sql1=mysqli_fetch_array($sql);
 if($sql1['sum(amount)']==NULL)
 {
    $totaldeposit=0;
 }
 else 
 {
     $totaldeposit=$sql1['sum(amount)'];
 }

echo "<input type='hidden' name='total_deposit' value='".$totaldeposit."' />";
 
$sql2=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='CM'");
 if(mysqli_num_rows($sql2)>0)
 {
     $caution_deposit=2500;
 }
 else {
     $caution_deposit=0;
 }
 
$sql3=mysqli_query($con,"SELECT sum(amount) FROM caution_deduction WHERE patient_ip_id='".$patient_ip_id."'");
 $sql4=mysqli_fetch_array($sql3);
 if($sql4['sum(amount)']==NULL)
 {
    $totalcautionded=0;
 }
 else 
 {
     $totalcautionded=$sql4['sum(amount)'];
 }
 
 
 $refunds=abs($refunds);
 echo "<input type='hidden' name='refunds' value='".$refunds."' />";
 
 
 
 
 $remainingamount=$totalbill-$totaldeposit+$refunds;
 /*
 $status="hy";
 $sql34=mysqli_query($con,"SELECT count(id) FROM dispatch_inv WHERE patient_ip_id='".$patient_ip_id."' && status='issued'");
 $sql35=mysqli_fetch_array($sql34);
 $v1=$sql35['count(id)'];
 
 $sql36=mysqli_query($con,"SELECT count(id) FROM dispatch_inv WHERE patient_ip_id='".$patient_ip_id."' && status='returned'");
 $sql37=mysqli_fetch_array($sql36);
 $v2=$sql37['count(id)'];
 
 if($v1==$v2)
 {
     $status="All Clear";
 }
 
 else {
     $status="Pending";
 }
  
  */
 $tdeposit=$totaldeposit+$caution_deposit;
 $amtcau=$caution_deposit-$totalcautionded;
 
 echo "<input type='hidden' name='cauded' value='".$totalcautionded."'";
  
  echo "<tr>
    <td><b>Total Bill</b></td>
    <td align='center'><b>Rs. $totalbill1</b></td>
</tr>
<tr>
    <td><b>Discount</b></td>
    <td align='center'><b>Rs. $discounts</b></td>
</tr>
<tr>
    <td><b>Deposits</b></td>
    <td align='center'><b>Rs. $totaldeposit</b></td>
</tr>
<tr>
    <td><b>Caution Deposit</b></td>
    <td align='center'><b>Rs. $caution_deposit</b></td>
</tr>
<tr>
    <td><b>Caution Deductions</b></td>
    <td align='center'><b>Rs. $totalcautionded </b></td>
</tr>
<tr>
    <td><b>Caution Amout to be paid</b></td>
    <td align='center'><b>Rs. $amtcau </b></td>
</tr>
<tr>
    <td><b>Remaining Amount</b></td>
    <td align='center'><b>Rs.$remainingamount</b><input type='hidden' name='remain' id='remain' value=$remainingamount /></td>
</tr>

" ;
  
  
?>
