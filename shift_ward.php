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
$right=$check1['ipd'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>

<script>

    $(function() {
        
    $( "#app_date" ).datetimepicker();  
    $( "#app_date" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
$( "#check_name" ).click(function(){
    var patient_ip_id=$("#patient_ip_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getuid.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#patient_id").html(data);
                        }
                     });
    
                
});

});
</script>
<script>
    $(function() {
$( "#app_date" ).datetimepicker();  
$( "#app_date" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
$( "#admit_mode" ).change(function(){
    var admit_mode=$("#admit_mode").val();
    
                     $.ajax({
                        type:"post",
                        url:"getwardname.php",
                        data:"admit_mode="+admit_mode,
                        success:function(data){
                              $("#ward_name").html(data);
                        }
                     });
});
$( "#ward_name" ).change(function(){
    var admit_mode=$("#admit_mode").val();
    var ward_name=$("#ward_name").val();
    
                     $.ajax({
                        type:"post",
                        url:"getavailablebeds.php",
                        data:"admit_mode="+admit_mode +"&ward_name="+ward_name,
                        success:function(data){
                              $("#available_beds").html(data);
                        }
                     });
});


});
</script>
<?php include 'sidebar.php' ?>
<form name="patient_admission" method="post">
    <tr>
            <td colspan="4"><p id="panel">Shift Ward of IP Patient</p></td>
            </tr>   
        <table id="table" name="t1" border="4" width="100%">
            
             <tr>
                <td>Enter IP number of patient</td>
                <td><input type="text" name="patient_ip_id" id="patient_ip_id" required="required" />&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Patient UID / Name</td>
                <td><select name="patient_id" id="patient_id">
                    
                </select></td>
            </tr>
            <tr>
                <td>Select Shift Date/Time</td>
                <td><input type="text" name="app_date" id="app_date" required="required" /></td>
                <td>Select Admission Mode</td>
                <td><select name="admit_mode" id="admit_mode" required="required">
                    <option value="">Select..</option>
                    
                    <option value="IPD">IPD</option>
                </select></td>
            </tr>
            <tr>
                <td>Select Ward Name</td>
                <td><select name="ward_name" id="ward_name" required="required">
                    
                </select></td>
                <td>Select Bed / Room Number</td>
                <td><select id="available_beds" name="available_beds" required="required">
                    
                </select></td>
            </tr>
           
 <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
            </tr>
        </table>
</form>
<?php include 'footer.php'; ?>
<style>
    #admission
    {
        background-color: orange;
    }
    
</style>
<?php
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
 
if($_POST[submit])
{
   $patient_ip_id=$_REQUEST['patient_ip_id'];
   $patient_id=$_REQUEST['patient_id'];
   $date=$_REQUEST['app_date'];
   $category=$_REQUEST['admit_mode'];
   $ward_name=$_REQUEST['ward_name'];
   $bed_num=$_REQUEST['available_beds']; 
   $ndate = date("d-m-Y H:i:s",strtotime($date." +1 minutes"));
   $query=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
 $result=mysqli_fetch_array($query);
  $under_doctor=$result['admit_under_doctor'];
  $co=explode(",",$under_doctor);
 
   $sql2=mysqli_query($con,"SELECT * FROM patient_admission WHERE status='admitted' && patient_ip_id='".$patient_ip_id."'");
   $sql3=mysqli_fetch_array($sql2);
   $oadmission=$sql3['admission_date'];
   $ocategory=$sql3['category'];
   $oward=$sql3['ward_name'];
   $obed=$sql3['bed_room_name'];
   $h=thours($oadmission,$date);
    $h=floor($h);
	 $query1= mysqli_query($con,"SELECT * FROM wards WHERE category='".$ocategory."' && ward_name='".$oward."'");
     $row1=mysqli_fetch_array($query1);
     $rent_per=$row1['rent_per_unit'];
     //Nursing Charge
     $nursing_charge=$row1['nursing_charge'];
     $nh=$h;
     $ni=$h/24;
     $nc=ceil($ni);
     $nursing_amount=$nc*$nursing_charge;
     $tnurse=$tnurse+$nursing_amount;
	  $remainder = $h % 12;
	 
      $quotient = ($h - $remainder) / 12;
      
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
	 
   $sql4=mysqli_query($con,"UPDATE name_allotment_wards SET status='vacant' WHERE category='".$ocategory."' && ward_name='".$oward."' && bed_room_name='".$obed."'");
   $query=mysqli_query($con,"UPDATE patient_admission SET leaving_date='".$date."',total_rent='".$trent."',total_nursing='".$tnurse."',total_cons='".$cons."',status='shifted' WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
   $sql=mysqli_query($con,"INSERT INTO patient_admission(patient_ip_id,patient_id,admission_date,category,ward_name,bed_room_name,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$ndate."','".$category."','".$ward_name."','".$bed_num."','admitted','".$entry_person."')");
   $sql1=mysqli_query($con,"UPDATE name_allotment_wards SET status='admitted' WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_num."'");
   if($sql && $query && $sql1 && $sql4)
       {
      echo "<script>alert('Ward Shifted Successfully');</script>";
    }
    else 
    {
      echo "<script>alert('Please Try Again!!');</script>";
    }
}
?>