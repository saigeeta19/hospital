
<style>
    #breakres
    {
        text-align:center;
        font-weight:bold;
        font-size:18px;
    }
</style>
<?php include("connection.php"); 

echo '<p style="font-size: 20px; width:100%; text-align:center;padding-bottom: 20px; padding-top:20px;">IP Break Up</p>';
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
        
 echo " <tr>
 <td colspan='2' id='breakres'>Registration Charge</td>
 <td  id='breakres'>Rs. $regcharge</td>
 </tr>";
 echo " <tr>
 <td colspan='2' id='breakres'>Emergency Charges</td>
 <td  id='breakres'>Rs. $emer_charge</td>
 </tr>";
 
 $query=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' ORDER BY id");
 echo "
 <tr>
   <th>Description</th>
   <th>Date</th>
   <th>Amount</th>
 </tr>";
 if(mysqli_num_rows($query)>0)
 {
 echo "
 <tr>
 <td colspan='3' id='breakhead'>Room Rent</td>
 </tr>";
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
    $ad_date = date(" d-M-Y h:i a", strtotime($starti));
    $le_date = date(" d-M-Y h:i a", strtotime($endi));
    
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
     echo "
 <tr>
      <td>$ward_name(Bed No: $row[bed_room_name])  </td>
      <td>$ad_date - $le_date</td>
      <td>Rs. $rent</td>
      </tr>
      <tr>
      <td>Nursing Charges  </td>
      <td>$ad_date - $le_date</td>
      <td>Rs. $nursing_amount</td>
      </tr>
	  <tr>
      <td>Housekeeping Charges  </td>
      <td>$ad_date - $le_date</td>
      <td>Rs. $housekeeping_amount</td>
      </tr>
       <tr>
      <td>Consultation Charges </td>
      <td>Under Doctor - $under_doctor</td>
      <td>Rs. $cons</td>
      </tr>
     ";
 }
$trent= $trent+$tnurse+$cons+$thousekeeping;
echo " <tr>
 <td colspan='2' id='breakres'>Total Room Rent + Nursing Charges + Housekeeping Charges + Consultation</td>
 <td  id='breakres'>Rs. $trent</td>
 </tr>
 
 ";
 
  
 }
 
 $query2=mysqli_query($con,"SELECT * FROM investigations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query2)>0)
 {
 $investigation_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Investigation</td>
 </tr>";
 while($row2=mysqli_fetch_array($query2))
 {
    $idate=$row2['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $invamt=$row2['amount'];
    $investigation_amount=$investigation_amount+$invamt;
    echo "<tr>
      <td>$row2[investigation_name]  </td>
      <td>$idate</td>
      <td>Rs. $invamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Investigations</td>
 <td  id='breakres'>Rs. $investigation_amount</td>
 </tr>";
 }
$query3=mysqli_query($con,"SELECT * FROM procedures_indents WHERE patient_ip_id='".$patient_ip_id."'");
if(mysqli_num_rows($query3)>0)
 {
 $procedure_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Procedures</td>
 </tr>";
 while($row3=mysqli_fetch_array($query3))
 {
    $idate=$row3['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $proamt=$row3['amount'];
    $procedure_amount=$procedure_amount+$proamt;
    echo "<tr>
      <td>$row3[procedure_name]  </td>
      <td>$idate</td>
      <td>Rs. $proamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Procedures</td>
 <td id='breakres'>Rs. $procedure_amount</td>
 </tr>";
 }
 
 
 $query4=mysqli_query($con,"SELECT * FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query4)>0)
 {
 $equipments_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Equipments</td>
 </tr>";
 while($row4=mysqli_fetch_array($query4))
 {
    $sdate=$row4['start_time'];
    $edate=$row4['end_time'];
    $sdate=date(" d-M-Y h:i a", strtotime($sdate));
    $edate=date(" d-M-Y h:i a", strtotime($edate));
    $equamt=$row4['amount'];
    $equipments_amount=$equipments_amount+$equamt;
    echo "<tr>
      <td>$row4[equipments_name]  </td>
      <td>$sdate - $edate</td>
      <td>Rs. $equamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Equipments</td>
 <td id='breakres'>Rs. $equipments_amount</td>
 </tr>";
 }
 
$query5=mysqli_query($con,"SELECT * FROM ot_entry WHERE patient_ip_id='".$patient_ip_id."'");
if(mysqli_num_rows($query5)>0)
 {
 $ot_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>OT</td>
 </tr>";
 while($row5=mysqli_fetch_array($query5))
 {
    $idate=$row5['app_date'];
    $idate=date(" d-M-Y", strtotime($idate));
    $otamt=$row5['total_amount'];
    $ot_amount=$ot_amount+$otamt;
    echo "<tr>
      <td>$row5[surgery_name]  </td>
      <td>$idate ($row5[surgeon_name])</td>
      <td>Rs. $row5[surgery_amount] </td>
      </tr>
      <tr>
      <td>OT Charges  </td>
      <td></td>
      <td>Rs. $row5[ot_amount] </td>
      </tr>
      <tr>
      <td>Anesthetist Charges  </td>
      <td></td>
      <td>Rs. $row5[anesthetist_amount] </td>
      </tr>
      <tr>
      <td>Assistant Surgeon Charges  </td>
      <td></td>
      <td>Rs. $row5[assistant_amount] </td>
      </tr>
      <tr>
      <td>Scrub Nurse Charges  </td>
      <td></td>
      <td>Rs. $row5[scrubnurse_amount] </td>
      </tr>
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total OT</td>
 <td id='breakres'>Rs. $ot_amount</td>
 </tr>";
 }

 $query6=mysqli_query($con,"SELECT * FROM consultations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query6)>0)
 {
 $consultation_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Consultations</td>
 </tr>";
 while($row6=mysqli_fetch_array($query6))
 {
    $idate=$row6['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $conamt=$row6['amount'];
    $consultation_amount=$consultation_amount+$conamt;
    echo "<tr>
      <td>$row6[doctor_name]  </td>
      <td>$idate</td>
      <td>Rs. $conamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Consultations</td>
 <td id='breakres'>Rs. $consultation_amount</td>
 </tr>";
 }
 
 $query656=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query656)>0)
 {
 $nutrition_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Nutritions</td>
 </tr>";
 while($row656=mysqli_fetch_array($query656))
 {
 	$nudate=$row656['date'];
 	$nudate=date(" d-M-Y h:i a", strtotime($nudate));
 	$nutamt=$row656['amount'];
	$nutrition_amount=$nutrition_amount+$nutamt;
 	echo "<tr>
      <td>$row656[nutri_name]  </td>
      <td>$nudate</td>
      <td>Rs. $nutamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Nutritions</td>
 <td id='breakres'>Rs. $nutrition_amount</td>
 </tr>";
 }
 
 
 $query61=mysqli_query($con,"SELECT * FROM other_entry WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query61)>0)
 {
 $other_amount=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Other Entries</td>
 </tr>";
 while($row61=mysqli_fetch_array($query61))
 {
    $idate=$row61['app_date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $othamt=$row61['amount'];
    $other_amount=$other_amount+$othamt;
    echo "<tr>
      <td>$row61[other_name]  </td>
      <td>$idate</td>
      <td>Rs. $othamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Others</td>
 <td id='breakres'>Rs. $other_amount</td>
 </tr>";
 }
 
 
 
 
 $query7=mysqli_query($con,"SELECT * FROM discounts WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query7)>0)
 {
 $discounts=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Discounts</td>
 </tr>";
 while($row7=mysqli_fetch_array($query7))
 {
    $idate=$row7['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $disamt=$row7['amount'];
    $discounts=$discounts+$disamt;
    echo "<tr>
      <td>$row7[reason]  </td>
      <td>$idate</td>
      <td>Rs. $disamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Discounts</td>
 <td id='breakres'>Rs. $discounts</td>
 </tr>";
 
 }
 
 $query8=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && (status!='FSREF' AND status!='CM' AND status!='CR')");
 
 $deposits=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Deposits</td>
 </tr>";
 while($row8=mysqli_fetch_array($query8))
 {
    $idate=$row8['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $depamt=$row8['amount'];
    $deposits=$deposits+$depamt;
    echo "<tr>
      <td> $row8[status]  </td>
      <td>$idate</td>
      <td>Rs. $depamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Deposits</td>
 <td id='breakres'>Rs. $deposits</td>
 </tr>";
 
 
 $query8=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREF'");
 
 $refunds=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Refunds</td>
 </tr>";
 while($row8=mysqli_fetch_array($query8))
 {
    $idate=$row8['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $depamt=$row8['amount'];
    $depamt1=abs($depamt);
    $refunds=$refunds+$depamt;
    echo "<tr>
      <td> $row8[status]  </td>
      <td>$idate</td>
      <td>Rs. $depamt1 </td>
      </tr>
     
     ";
 }
 $refunds=abs($refunds);
 echo " <tr>
 <td colspan='2' id='breakres'>Total Refunds</td>
 <td id='breakres'>Rs. $refunds</td>
 </tr>";
 
  $totalbill=($emer_charge+$regcharge+$trent+$other_amount+$investigation_amount+$ot_amount+$procedure_amount+$equipments_amount+$consultation_amount+$nutrition_amount)-$discounts;
  echo " <tr>
 <td colspan='2' id='breakres'>Total Bill</td>
 <td id='breakres'>Rs. $totalbill</td>
 </tr>";
 
 
 
 $query9=mysqli_query($con,"SELECT * FROM caution_deduction WHERE patient_ip_id='".$patient_ip_id."'");
 $deductions=0;
 echo "<tr>
 <td colspan='3' id='breakhead'>Caution Deduction</td>
 </tr>";
 while($row9=mysqli_fetch_array($query9))
 {
    $idate=$row9['app_date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $dedamt=$row9['amount'];
    $deductions=$deductions+$dedamt;
    echo "<tr>
      <td> $row9[reason]  </td>
      <td>$idate</td>
      <td>Rs. $dedamt </td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Deductions</td>
 <td id='breakres'>Rs. $deductions</td>
 </tr>";
 
 
 $remainingamount=$totalbill-$deposits+$refunds;
 
 $sql=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='CM'");
 if(mysqli_num_rows($sql)>0)
 {
 	$caupay=2500-$deductions;
 }
 else {
     $caupay=0;
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Caution Money to pay back</td>
 <td id='breakres'>Rs. $caupay</td>
 </tr>";
 echo " <tr>
 <td colspan='2' id='breakres'>Remaining Amount to Pay</td>
 <td id='breakres'>Rs. $remainingamount</td>
 </tr>
 </table>";