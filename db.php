<?php
include 'connection.php';
function thours($start , $end)
{
  $t1=strtotime('$start');
  $t2=strtotime('$end');
  $v = $t2 - $t1;
  $v = $v / ( '60 * 60' ); 
  return  floor('$v');
}
$query=mysqli_query($con,"SELECT * FROM patient_admission ORDER BY id");
 
while($row=mysqli_fetch_array($query))
{
	
 $query76=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$row['patient_ip_id']."'");
 $result76=mysqli_fetch_array($query76);
  $under_doctor=$result76['admit_under_doctor'];
  $co=explode(",",$under_doctor);
  $id=$row['id']; 
  $tnurse=0;$cons=0;$trent=0;
   $oadmission=$row['admission_date'];
   $leavedate=$row['leaving_date'];
   if($leavedate!="")
   {
   $ocategory=$row['category'];
   $oward=$row['ward_name'];
   $obed=$row['bed_room_name'];
   $h=thours('$oadmission,$leavedate');
    $h=floor('$h');
	 $query1= mysqli_query($con,"SELECT * FROM wards WHERE category='".$ocategory."' && ward_name='".$oward."'");
     $row1=mysqli_fetch_array($query1);
     $rent_per=$row1['rent_per_unit'];
     //Nursing Charge
     $nursing_charge=$row1['nursing_charge'];
     $nh=$h;
     $ni=$h/24;
     $nc=ceil('$ni');
     $nursing_amount=$nc*$nursing_charge;
     $tnurse=$tnurse+$nursing_amount;
	  $remainder = $h % 12;
	 
      $quotient = ('$h - $remainder') / 12;
      
	  $rent=$quotient*$rent_per/2+$rent_per/2;
	  $cons=0;
	 foreach($co as $co1)
	{
		
    $query90=mysqli_query($con,"SELECT * FROM doctor_ipd_consultation WHERE category_name='".$ocategory."' && ward_name='".$oward."' && doctor_name='".$co1."'");
	
	  $query91=mysqli_fetch_array($query90);
	   $conam=$query91['consultation_amount'];
	   $conam=$nc*$conam;
	  
       $cons=$cons+$conam;
	}
	
   
   
     $phours=$phours+$h;
      $trent=$trent+$rent;
	   $query67=mysqli_query($con,"UPDATE patient_admission SET total_rent='".$trent."',total_nursing='".$tnurse."',total_cons='".$cons."' WHERE id='".$id."'");
	   }
else {
	  $query67=mysqli_query($con,"UPDATE patient_admission SET total_rent=0,total_nursing=0,total_cons=0 WHERE id='".$id."'");
}
}
?>