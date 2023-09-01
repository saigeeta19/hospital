<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];
 ?>
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

 $patient_ip_id=$_GET["ip"];
 $query=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
 $admission_date=$result['admission_date'];
 $dischargedate=$result['discharge_date'];
 $bill_number=$result['bill_number'];
 $dischargemode=$result['discharge_mode'];
 $patient_id=$result["patient_id"];
 $under_doctor=$result['admit_under_doctor'];
  $co=explode(",",$under_doctor);
 
 echo "<input type='hidden' name='admission' value='".$admission_date."' />";
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
 $tnurse=0;$trent=0;$cons=0;$thousekeeping=0;
 while($row=mysqli_fetch_array($query))
 {
     $starti=$row['admission_date'];
     $endi=$row['leaving_date'];
     $category=$row['category'];
     $ward_name=$row['ward_name'];
     
     $h=thours($starti,$endi);
      $h=floor($h);
	
     
    
	
    // $chk=ceil($h/24);
     $query1= mysqli_query($con,"SELECT * FROM wards WHERE category='".$category."' && ward_name='".$ward_name."'");
     $row1=mysqli_fetch_array($query1);
     $rent_per=$row1['rent_per_unit'];
	  //Hosekeeping Charge
     $housekeeping_charge=$row1['housekeeping_charge'];
     //Nursing Charge
     $nursing_charge=$row1['nursing_charge'];
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
  echo "<input type='hidden' name='housekeeping_charge' value='".$thousekeeping."' />";
 echo "<input type='hidden' name='nursing_charge' value='".$tnurse."' />";
 echo "<input type='hidden' name='cons' value='".$cons."' />";
 //$trent=$trent+$tnurse;
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
 $row7=mysqli_fetch_array($query7);
 if($row7['sum(amount)']==NULL)
 {
    $consultation_amount= 0;
 }
 else 
 {
    $consultation_amount=$row7['sum(amount)'];
 }
 $consultation_amount=$cons+$consultation_amount;
 
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

 $caution_deposit=2500;
 
 
 $totalbill1=$emer_charge+$regcharge+$trent+$thousekeeping+$tnurse+$otheramount+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$consultation_amount+$nutrition_amount;
 $totalbill=($emer_charge+$regcharge+$thousekeeping+$otheramount+$trent+$tnurse+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$consultation_amount+$nutrition_amount)-$discounts;
 
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
 
 
  
    
    
  /*  $thours=$_REQUEST['thou'];
    $query2=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
    $row2=mysqli_fetch_array($query2);
    $id=$row2['id'];
	
    $category=$row2['category'];
    $ward_name=$row2['ward_name'];
    $bed_room_name=$row2['bed_room_name']; */
   
    
    //Bill Details
    $sql67=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
        $sql68=mysqli_fetch_array($sql67);
        $patient_name=$sql68['name'];
    $registration="Rs. 200";
   
    // For Bill number
	/*
	
       $bd=date("Y/m/");
       $sql56=mysqli_query($con,"SELECT * FROM billnumbers WHERE bill_format='".$bd."'");
       if(mysqli_num_rows($sql56)>0)
       {
           $sql57=mysqli_query($con,"SELECT max(bill_number) FROM billnumbers WHERE bill_format='".$bd."'");
           $sql58=mysqli_fetch_array($sql57);
           $mbill=$sql58['max(bill_number)'];
           $bn=$mbill+1;
           $bill_number=$bd.$bn;
       }
       else {
           $bn=1;
           $bill_number=$bd.$bn;
       }
	   */
       //Bill number ends here
    $t="<html><table width='100%' style='font-size:14px ;padding-top:170px;padding-left:20px;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:center; font-size:18px; text-decoration:underline;padding-right:20px;' colspan='4'> IN-PATIENT BILL </th>
       </tr>
        <tr>
       <th style='text-align:left;padding-left:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:left;padding-left:10px;'>Patient Name: </th>
       <td><b>$patient_name</b></td>
       </tr>
       <th style='text-align:left;padding-left:10px;'>IP Number:  </th>
       <td>$patient_ip_id</td>
       <th style='text-align:left;padding-left:10px;'>Bill Number:</th>
       <td>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:left;padding-left:10px;'>Date of Admission: </th>
       <td>$admission_date</td>
       <th style='text-align:left;padding-left:10px;'>Date of Discharge: </th>
       <td>$dischargedate</td>
       </tr>
       <tr>
       <th style='text-align:left;padding-left:10px;'>Mode of Discharge: </th>
       <td>$dischargemode</td>
       <th style='text-align:left;padding-left:10px;'>Payment Type: </th>
       <td>Cash</td>
       </tr>
       </table>
       <table width='100%' border='1' style='border-collapse:collapse;font-size:14px;margin-top:50px;padding-left:30px;text-align:center;line-height:20px;line-width:15px;'>
       <tr>
        <th width='80%'>Description</th>
        <th  width='20%'>Amount</th>
       </tr>
       <tr>
         <td>Registration Charges</td>
         <td>$registration</td>
         </tr>
         ";
         if($emer_charge!=0)
         {
             $t=$t."<tr>
         <td>Emergency Charges</td>
         <td>Rs. $emer_charge</td>
         </tr>";
         }
		         
        // $roomrent=$trent-$tnurse;
         $t=$t. "<tr>
         <td>Room Rent</td>
         <td>Rs. $trent</td>
         </tr>";
         $t=$t. "<tr>
         <td>Nursing Charges</td>
         <td>Rs. $tnurse</td>
         </tr>";
		  $t=$t. "<tr>
         <td>Hosekeeping Charges</td>
         <td>Rs. $thousekeeping</td>
         </tr>";
		 
         if($investigation_amount!=0)
         {
             $t=$t. "<tr>
         <td>Investigation Charges</td>
         <td>Rs. $investigation_amount</td>
         </tr>";
         }
         if($procedure_amount!=0)
         {
             $t=$t. "<tr>
         <td>Procedure Charges</td>
         <td>Rs. $procedure_amount</td>
         </tr>";
         }
         if($equipments_amount!=0)
         {
             $t=$t. "<tr>
         <td>Medical Equipment Charges</td>
         <td>Rs. $equipments_amount</td>
         </tr>";
         }       
         
             $t=$t. "<tr>
         <td>Consultation Charges</td>
         <td>Rs. $consultation_amount</td>
         </tr>";
         
         if($otheramount!=0)
         {
             $t=$t. "<tr>
         <td>Other Charges</td>
         <td>Rs. $otheramount</td>
         </tr>";
         }   
         if($nutrition_amount!=0)
         {
             $t=$t. "<tr>
         <td>Nutrition Charges</td>
         <td>Rs. $nutrition_amount</td>
         </tr>";
         }   
		 if($ot_entry!=0)
         {
             $t=$t. "<tr>
         <td>OT Charges</td>
         <td>Rs. $ot_entry</td>
         </tr>";
         }     
             $t=$t. "<tr>
         <td>Total Bill</td>
         <td><b>Rs. $totalbill1</b></td>
         </tr>";
         
        
           $sql66=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='D'");
         
         $sql67=mysqli_fetch_array($sql66);
         if($sql67['sum(amount)']==NULL)
         {
            $dep=0;
         }
         else 
         {
             $dep=$sql67['sum(amount)'];
         }
         
             $t=$t. "<tr>
         <td>Total Deposits</td>
         <td>Rs. $dep</td>
         </tr>";
         
          if($discounts!=0)
         {
             $t=$t. "<tr>
         <td>Total Discounts</td>
         <td>Rs. $discounts</td>
         </tr>";
         }  
         
         $sql56=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREC'");
         
         $sql57=mysqli_fetch_array($sql56);
         if($sql57['sum(amount)']==NULL)
         {
            $totalrec=0;
         }
         else 
         {
             $totalrec=$sql57['sum(amount)'];
         }
         
           $refunds=abs($refunds);      
         
         if($refunds!=0)
         {
            $t=$t. "<tr>
         <td>Final Settlement (Refund)</td>
         <td>Rs. $refunds</td>
         </tr>"; 
         $netb=$totalbill1-($totaldeposit+$discounts)+$refunds;
         }
         else if($totalrec!=0) {
             $t=$t. "<tr>
         <td>Final Settlement (Receipt)</td>
         <td>Rs. $totalrec</td>
         </tr>"; 
         $netb=$totalbill1-($totaldeposit+$discounts);
         }
else {
	 
         $netb=$totalbill1-($totaldeposit+$discounts);
}
         
          $t=$t. "<tr>
         <td>Net Balance</td>
         <td>Rs. $netb</td>
         </tr>";
        
        $t=$t."</table><br/><table width='75%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $t=$t."</html>";
		
   ?>
   
   <script>
       
//function printPage()
//{
var html = <?php echo json_encode($t); ?>;

 var printWin = window.open("","","left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0");
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
//}
</script>
  
  
  
