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

<?php
   if($_POST['submit'])
   {
   	$patient_ip_id=$_REQUEST['patient_ip_id'];
	$age=$_REQUEST['age'];
	$adhaar_num=$_REQUEST['adhaar_num'];
	$covid_report_num=$_REQUEST['covid_report_num'];
	$mode=$_REQUEST['mode'];
	$credit_company=$_REQUEST['credit_company'];
	
	$problem=$_REQUEST['problem'];
	$referred_num=$_REQUEST['referred_num'];
	$referred=$_REQUEST['referred'];
	
	 //$doctor=$_REQUEST['doctor'];
	 $doctor="";
	 foreach($_REQUEST['doctor'] as $sdoctor)
	 {
	 	$doctor=$doctor.$sdoctor.",";
	 }
	
	
    //$tiffin=$_REQUEST['tiffin'];
	$attender_name=$_REQUEST['attender_name'];
	$attender_father_name=$_REQUEST['attender_father_name'];
	$relation_patient=$_REQUEST['relation_patient'];
	$attendant_address=$_REQUEST['attendant_address'];
	$attender_contact=$_REQUEST['attender_contact'];
	$attender_email=$_REQUEST['attender_email'];
    $query=mysqli_query($con,"UPDATE patient_diagnosis SET age='".$age."',covid_report_num='".$covid_report_num."',adhaar_num='".$adhaar_num."',problem_diagnosed='".$problem."',referred_num='".$referred_num."',mode='".$mode."',credit_company='".$credit_company."',referred_by='".$referred."',admit_under_doctor='".$doctor."' WHERE patient_ip_id='".$patient_ip_id."'");
	$query1=mysqli_query($con,"UPDATE attenders SET attender_name='".$attender_name."',attender_father='".$attender_father_name."',attender_patient_relation='".$relation_patient."',attender_address='".$attendant_address."',attender_email='".$attender_email."',attender_contact='".$attender_contact."' WHERE patient_ip_id='".$patient_ip_id."'");
	
	
	if($query && $query1)
    {
      
       echo "<script>alert('Entry successfull');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
	
	
   }
?>
<script>
	$(function() {
	    
	    
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
           	   	     
           	   	      $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpatientipdetails.php",
           	   	     	data:"patient_ip_id="+patient_ip_id,
           	   	     	success:function(data){
                              $(".tablepaging").html(data);
           	   	     	}
           	   	     });
           	   	     
});


});
</script>
<?php include 'sidebar.php' ?>
<form name="patient_admission" method="post">
	<tr>
            <td colspan="4"><p id="panel">Edit Patient Details</p></td>
            </tr>	
		<table id="table" name="t1" border="4" width="100%">
			<tr>
            <td colspan="4" id="table_head">Admission Details</td>
            </tr>
			 <tr>
				<td>Enter IP number of patient</td>
          	    <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Patient UID / Name</td>
          	    <td><select name="patient_id" id="patient_id" required="required">
          	    	
          	    </select></td>
			</tr>
		</table>
		<table id="table" class="tablepaging" name="t1" border="4" width="100%">
			
			</table>
		
	<table id="table" name="t1" border="4" width="100%">
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
