<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>

<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php' ?>

<?php include 'sidebar.php' ?>
<form name="view_ip_bill" method="post" action="indent_delete.php">
    <tr>
            <td colspan="4"><p id="panel">View Patient Bill Breakup</p></td>
    </tr>   
        <table id="table" name="t1" border="4" width="100%">
         <?php include("connection.php"); 

function thours($start,$end)
{
  $t1=strtotime($start);
  $t2=strtotime($end);
  $v = $t2 - $t1;
  $v = $v / ( 60 * 60 ); 
  return  ceil($v);
}
 if($_GET['ip']!="")
 {
   echo "<script>alert('Indent Deleted Successfully'); </script>";		
 	$patient_ip_id=$_GET['ip'];
	
	
 }
 else if($_REQUEST['patient_ip_id']!="")
 {
 $patient_ip_id=$_REQUEST['patient_ip_id'];
 }
  $phours=0;
 $trent=0;
 $regcharge=200;
 $dischargedate=date("d-m-Y H:i:s");
 //$patient_ip_id=$_POST["patient_ip_id"];
 $query=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
 $admission_date=$result['admission_date'];
  $under_doctor=$result['admit_under_doctor'];
 
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
     
    
 echo " <tr>
 <td colspan='2' id='breakres'>Registration Charge</td>
 <td  id='breakres'>Rs. $regcharge</td>
 <td  id='breakres'></td>
 </tr>";
 echo " <tr>
 <td colspan='2' id='breakres'>Emergency Charges</td>
 <td  id='breakres'>Rs. $emer_charge</td>
 <td  id='breakres'></td>
 </tr>";
 
 $query=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' ORDER BY id");
 echo "
 <tr>
   <th>Description</th>
   <th>Date</th>
   <th>Amount</th>
   <th>Action</th>
 </tr>";
 if(mysqli_num_rows($query)>0)
 {
 echo "
 <tr>
 <td colspan='4' id='breakhead'>Room Rent</td>
 </tr>";
  $tnurse=0;$cons=0;
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
     $h=ceil($h);
	
	  $query90=mysqli_query($con,"SELECT * FROM doctor_ipd_consultation WHERE category_name='".$category."' && ward_name='".$ward_name."' && doctor_name='".$under_doctor."'");
	$query91=mysqli_fetch_array($query90);
	$conam=$query91['consultation_amount'];
	
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
	 
	  $conam=$nc*$conam;
     $cons=$cons+$conam;
	 
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
      <td></td>
      </tr>
      <tr>
      <td>Nursing Charges  </td>
      <td>$ad_date - $le_date</td>
      <td>Rs. $nursing_amount</td>
      <td></td>
      </tr>
     ";
 }
$trent= $trent+$tnurse+$cons;
echo "  <tr>
      <td>Consultation Charges </td>
      <td>Under Doctor - $under_doctor</td>
      <td>Rs. $cons</td>
      </tr>";
echo " <tr>
 <td colspan='2' id='breakres'>Total Room Rent + Nursing Charges</td>
 <td  id='breakres'>Rs. $trent</td>
 <td  id='breakres'></td>
 </tr>";
 
  
 }
 
  echo " <tr>
 <td colspan='2' id='breakres'>House Keeping Charges</td>
 <td  id='breakres'>Rs. $housekeeping_charge</td>
 <td  id='breakres'></td>
 </tr>";
 
 $query2=mysqli_query($con,"SELECT * FROM investigations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query2)>0)
 {
 $investigation_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Investigation</td>
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
      <td><a href='getindentdel.php?val=inv&id=$row2[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Investigations</td>
 <td  id='breakres'>Rs. $investigation_amount</td>
 <td  id='breakres'></td>
 </tr>";
 }
$query3=mysqli_query($con,"SELECT * FROM procedures_indents WHERE patient_ip_id='".$patient_ip_id."'");
if(mysqli_num_rows($query3)>0)
 {
 $procedure_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Procedures</td>
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
       <td><a href='getindentdel.php?val=pro&id=$row3[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Procedures</td>
 <td id='breakres'>Rs. $procedure_amount</td>
 <td id='breakres'></td>
 </tr>";
 }
 
 
 $query4=mysqli_query($con,"SELECT * FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query4)>0)
 {
 $equipments_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Equipments</td>
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
      <td><a href='getindentdel.php?val=equ&id=$row4[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Equipments</td>
 <td id='breakres'>Rs. $equipments_amount</td>
 <td id='breakres'></td>
 </tr>";
 }
//nutrition
$query41=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query41)>0)
 {
 $nutrition_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Nutritions</td>
 </tr>";
 while($row41=mysqli_fetch_array($query41))
 {
 	$sdate=$row41['start_time'];
 	$edate=$row41['end_time'];
 	$sdate=date(" d-M-Y h:i a", strtotime($sdate));
 	$edate=date(" d-M-Y h:i a", strtotime($edate));
 	$nutamt=$row41['amount'];
	$nutrition_amount=$nutrition_amount+$nutamt;
 	echo "<tr>
      <td>$row41[nutri_name]  </td>
      <td>$sdate - $edate</td>
      <td>Rs. $nutamt </td>
      <td><a href='getindentdel.php?val=nut&id=$row41[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Nutritions</td>
 <td id='breakres'>Rs. $nutrition_amount</td>
 <td id='breakres'></td>
 </tr>";
 }




 
$query5=mysqli_query($con,"SELECT * FROM ot_entry WHERE patient_ip_id='".$patient_ip_id."'");
if(mysqli_num_rows($query5)>0)
 {
 $ot_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>OT</td>
 </tr>";
 while($row5=mysqli_fetch_array($query5))
 {
 	$idate=$row5['app_date'];
 	$idate=date(" d-M-Y", strtotime($idate));
 	$otamt=$row5['total_amount'];
	$ot_amount=$ot_amount+$otamt;
 	echo "<tr>
      <td>$row5[surgery_name]  </td>
      <td>$idate</td>
      <td>Rs. $row5[surgery_amount] </td>
       <td><a href='getindentdel.php?val=ot&id=$row5[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
      <tr>
      <td>OT Charges  </td>
      <td></td>
      <td>Rs. $row5[ot_amount] </td>
      <td></td>
      </tr>
      <tr>
      <td>Anesthetist Charges  </td>
      <td></td>
      <td>Rs. $row5[anesthetist_amount] </td>
      <td ></td>
      </tr>
      <tr>
      <td>Assistant Surgeon Charges  </td>
      <td></td>
      <td>Rs. $row5[assistant_amount] </td>
      <td></td>
      </tr>
      <tr>
      <td>Scrub Nurse Charges  </td>
      <td></td>
      <td>Rs. $row5[scrubnurse_amount] </td>
      <td></td>
      </tr>
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total OT</td>
 <td id='breakres'>Rs. $ot_amount</td>
 <td id='breakres'></td>
 </tr>";
 }

 $query6=mysqli_query($con,"SELECT * FROM consultations_indents WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query6)>0)
 {
 $consultation_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Consultations</td>
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
      <td><a href='getindentdel.php?val=con&id=$row6[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Consultations</td>
 <td id='breakres'>Rs. $consultation_amount</td>
 <td id='breakres'></td>
 </tr>";
 }
 
 $query61=mysqli_query($con,"SELECT * FROM other_entry WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query61)>0)
 {
 $other_amount=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Other Entries</td>
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
       <td><a href='getindentdel.php?val=oth&id=$row61[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Others</td>
 <td id='breakres'>Rs. $other_amount</td>
 <td id='breakres'></td>
 </tr>";
 }
 
 
 
 
 $query7=mysqli_query($con,"SELECT * FROM discounts WHERE patient_ip_id='".$patient_ip_id."'");
 if(mysqli_num_rows($query7)>0)
 {
 $discounts=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Discounts</td>
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
       <td><a href='getindentdel.php?val=dis&id=$row7[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Discounts</td>
 <td id='breakres'>Rs. $discounts</td>
 <td id='breakres'></td>
 </tr>";
 
 }
 
 $query8=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status!='FSREF'");
 
 $deposits=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Deposits</td>
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
       <td><a href='getindentdel.php?val=dep&id=$row8[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Deposits+ Caution Money</td>
 <td id='breakres'>Rs. $deposits</td>
 <td id='breakres'></td>
 </tr>";
 
 
 
 $query81=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREF'");
 
 $refunds=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Refunds</td>
 </tr>";
 while($row82=mysqli_fetch_array($query81))
 {
    $idate=$row82['date'];
    $idate=date(" d-M-Y h:i a", strtotime($idate));
    $depamt=$row82['amount'];
    $depamt1=abs($depamt);
    $refunds=$refunds+$depamt;
    echo "<tr>
      <td> $row82[status]  </td>
      <td>$idate</td>
      <td>Rs. $depamt1 </td>
      <td><a href='getindentdel.php?val=dep&id=$row82[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 $refunds=abs($refunds);
 echo " <tr>
 <td colspan='2' id='breakres'>Total Refunds</td>
 <td id='breakres'>Rs. $refunds</td>
  <td id='breakres'></td>
 </tr>";
 
  $totalbill=($emer_charge+$regcharge+$housekeeping_charge+$trent+$other_amount+$investigation_amount+$ot_amount+$procedure_amount+$equipments_amount+$consultation_amount)-$discounts;
  echo " <tr>
 <td colspan='2' id='breakres'>Total Bill</td>
 <td id='breakres'>Rs. $totalbill</td>
  <td id='breakres'></td>
 </tr>";
 
 
 
 $query9=mysqli_query($con,"SELECT * FROM caution_deduction WHERE patient_ip_id='".$patient_ip_id."'");
 $deductions=0;
 echo "<tr>
 <td colspan='4' id='breakhead'>Caution Deduction</td>
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
      <td><a href='getindentdel.php?val=cauded&id=$row9[id]' onclick='return confirm(\"Are you sure?\");'><img src='images/cancel.png' /></a></td>
      </tr>
     
     ";
 }
 echo " <tr>
 <td colspan='2' id='breakres'>Total Deductions</td>
 <td id='breakres'>Rs. $deductions</td>
 <td id='breakres'></td>
 </tr>";
 
 
 
 
?>
   
           
        </table>
           
</form>
<?php include 'footer.php'; ?>
