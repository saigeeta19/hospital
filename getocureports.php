<?php
include 'connection.php';

function thours($start,$end)
{
  $t1=strtotime($start);
  $t2=strtotime($end);
  $v = $t2 - $t1;
  $v = $v / ( 60 * 60 ); 
 return  floor($v);
}
 
 
 
$ward1=$_POST['ward_name'];
echo "
			<tr>
                <th>S.No.</th>
                <th>UID</th>
                <th>IP Number</th>
                <th>Patient Name</th>
                <th>Ward</th>
                <th>Amount</th>
            </tr>
";

 $inc=1;
 $sql56=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE status='admitted'");
 while($sql57=mysqli_fetch_array($sql56))
 {
     $phours=0;
 $trent=0;
 $deposit=0;
 $discounts=0;
 $regcharge=200;
 $dischargedate=date("d-m-Y H:i:s");
     $patient_ip_id=$sql57['patient_ip_id'];
     $patient_id=$sql57['patient_id'];
     $admission_date=$sql57['admission_date'];
 $under_doctor=$sql57['admit_under_doctor'];
 $co=explode(",",$under_doctor);
 
 
$sql12378=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && leaving_date='' && ward_name='".$ward1."'");
if(mysqli_num_rows($sql12378)>0)
{
	$ward_verify="yes";
}
else
	{
		if($ward1=="all")
		{
			$ward_verify="yes";
		}
		else {
		$ward_verify="no";	
		}
	  	
	}
 
 
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
     
    

   

   
 
 $query=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' ORDER BY id");
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
 $trent=$trent+$tnurse;
 
 $query2=mysql_query("SELECT sum(amount) FROM investigations_indents WHERE patient_ip_id='".$patient_ip_id."'",$con);
 $row2=mysql_fetch_array($query2);
 if($row2['sum(amount)']==NULL)
 {
    $investigation_amount= 0;
  
      
 }
 else {
 
     $investigation_amount=$row2['sum(amount)'];
 }

$query3=mysqli_query($con,"SELECT sum(amount) FROM discounts WHERE patient_ip_id='".$patient_ip_id."'");
 $row3=mysqli_fetch_array($query3);
 if($row3['sum(amount)']==NULL)
 {
    $discounts= 0;
  
      
 }
 else {
 
     $discounts=$row3['sum(amount)'];
 }
 
 



$query4=mysqli_query($con,"SELECT sum(amount) FROM procedures_indents WHERE patient_ip_id='".$patient_ip_id."'");
 $row4=mysqli_fetch_array($query4);
 if($row4['sum(amount)']==NULL)
 {
    $procedure_amount= 0;
  
      
 }
 else {
 
     $procedure_amount=$row4['sum(amount)'];
 }
 


$query5=mysqli_query($con,"SELECT sum(amount) FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."'");
 $row5=mysqli_fetch_array($query5);
 if($row5['sum(amount)']==NULL)
 {
    $equipments_amount= 0;
  
      
 }
 else {
 
     $equipments_amount=$row5['sum(amount)'];
 }
 
 
 $query6=mysqli_query($con,"SELECT sum(total_amount) FROM ot_entry WHERE patient_ip_id='".$patient_ip_id."'");
 $row6=mysqli_fetch_array($query6);
 if($row6['sum(total_amount)']==NULL)
 {
    $ot_entry= 0;
  
 }
 else {
 
     $ot_entry=$row6['sum(total_amount)'];
 }

 
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
 
 
 $totalbill1=$emer_charge+$regcharge+$trent+$housekeeping_charge+$otheramount+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$cons+$consultation_amount+$nutrition_amount;
 $totalbill=($emer_charge+$regcharge+$otheramount+$housekeeping_charge+$trent+$investigation_amount+$ot_entry+$procedure_amount+$equipments_amount+$cons+$consultation_amount+$nutrition_amount)-$discounts;
 
 
 
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

 
 
 
 $remainingamount=$totalbill-$totaldeposit+$refunds;

 $tdeposit=$totaldeposit+$caution_deposit;

$sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                
$sql87=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
$sql88=mysqli_fetch_array($sql87);
              
                
          if($ward_verify=="yes")  
           {
            echo "
            <tr>
            <td align='center'>$inc</td>
            <td align='center'>$patient_id</td>
            <td align='center'>$patient_ip_id</td>
            <td align='center'>$patient_name </a></td>
            <td align='center'>$sql88[category] / $sql88[ward_name] / $sql88[bed_room_name]</td>
            <td align='center'>Rs. $remainingamount</td>
           
            </tr>
            ";
            
		   }
            
            
            
            $inc++;
            }
            
          ?>  