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
   	$patient_id=$_REQUEST['patient_id'];
	
    $patient_name=$_REQUEST['patient_name'];
    $mode=$_REQUEST['mode'];
	$credit_company_name=$_REQUEST['creditcompany'];
	$age=$_REQUEST['age'];
	$adhaar_num=$_REQUEST['adhaar_num'];
	$covid_report_num=$_REQUEST['covid_report_num'];
	$admit_mode=$_REQUEST['admit_mode'];
	$ward_name=$_REQUEST['ward_name'];
	$available_beds=$_REQUEST['available_beds'];
	$problem=$_REQUEST['problem'];
	$referred_num=$_REQUEST['referred_num'];
	$referred=$_REQUEST['referred'];
	
	 //$doctor=$_REQUEST['doctor'];
	 $doctor="";
	 foreach($_REQUEST['doctor'] as $sdoctor)
	 {
	 	$doctor=$doctor.$sdoctor.",";
	 }
	 $doctor;
	
    //$tiffin=$_REQUEST['tiffin'];
	$attender_name=$_REQUEST['attender_name'];
	$attender_father_name=$_REQUEST['attender_father_name'];
	$relation_patient=$_REQUEST['relation_patient'];
	$attendant_address=$_REQUEST['attendant_address'];
	$attender_contact=$_REQUEST['attender_contact'];
	$attender_email=$_REQUEST['attender_email'];
	$date=$_REQUEST['app_date'];
		
	
	//IP number
	 $cform=date("ym");
	$sql=mysqli_query($con,"SELECT max(id) FROM ipnumbers WHERE ip_form='".$cform."'");
	$sql1=mysqli_fetch_array($sql);
	$ipid=$sql1['max(id)'];
	if($ipid==NULL)
	{
		 $ip_num_new=1;
		$ip_num=$cform.$ip_num_new;
	}
	else {
		
	  $sql2=mysqli_query($con,"SELECT * FROM ipnumbers WHERE id='".$ipid."'");
       $sql3=mysqli_fetch_array($sql2);
       $ip_num_old=$sql3['ip_num'];
	    $ip_num_new=$ip_num_old+1;
        $ip_num=$cform.$ip_num_new;
	}
	
	//IP number Ends Here
   /* echo "INSERT INTO patient_diagnosis(patient_id,patient_ip_id,age,covid_report_num,adhaar_num,mode,credit_company,problem_diagnosed,admit_under_doctor,admission_date,referred_by,referred_num,status,entry_person) VALUES ('".$patient_id."','".$ip_num."','".$age."','".$covid_report_num."','".$adhaar_num."','".$mode."','".$credit_company_name."','".$problem."','".$doctor."','".$date."','".$referred."','".$referred_num."','admitted','".$entry_person."')"; exit; */
	$query=mysqli_query($con,"INSERT INTO patient_admission(patient_id,patient_ip_id,admission_date,category,ward_name,bed_room_name,status,entry_person) VALUES ('".$patient_id."','".$ip_num."','".$date."','".$admit_mode."','".$ward_name."','".$available_beds."','admitted','".$entry_person."')");
    $query1=mysqli_query($con,"INSERT INTO attenders(patient_id,patient_ip_id,attender_name,attender_father,attender_patient_relation,attender_address,attender_email,attender_contact,date_patient_admit) VALUES ('".$patient_id."','".$ip_num."','".$attender_name."','".$attender_father_name."','".$relation_patient."','".$attendant_address."','".$attender_email."','".$attender_contact."','".$date."')");
	$query2=mysqli_query($con,"INSERT INTO patient_diagnosis(patient_id,patient_ip_id,age,covid_report_num,adhaar_num,mode,credit_company,problem_diagnosed,admit_under_doctor,admission_date,referred_by,referred_num,status,entry_person) VALUES ('".$patient_id."','".$ip_num."','".$age."','".$covid_report_num."','".$adhaar_num."','".$mode."','".$credit_company_name."','".$problem."','".$doctor."','".$date."','".$referred."','".$referred_num."','admitted','".$entry_person."')");
	$query3=mysqli_query($con,"UPDATE name_allotment_wards SET status='admitted' WHERE category='".$admit_mode."' && ward_name='".$ward_name."' && bed_room_name='".$available_beds."'");
	//$query4=mysqli_query($con,"SELECT max(patient_ip_id) FROM patient_admission");
    $query5=mysqli_query($con,"INSERT INTO ipnumbers(ip_form,ip_num) VALUES('".$cform."','".$ip_num_new."')");
    //$row4=mysqli_fetch_array($query4);
   // $id=$row4['max(patient_ip_id)']; 



	if($query && $query1 && $query2 && $query3)
	{
		echo '<script>$("<div title=\'Admission Successfull\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Patient admitted successfully. <br/>Patient IP Number is: '.$ip_num.'. <br/>Please note down the UID for further reference.</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>'; 
      }
  else {
           $query5=mysqli_query($con,"DELETE FROM patient_admission WHERE patient_ip_id='".$id."'");
           $query6=mysqli_query($con,"DELETE FROM attenders WHERE patient_ip_id='".$id."'");
           $query7=mysqli_query($con,"DELETE FROM patient_diagnosis WHERE patient_ip_id='".$id."'");
           $query8=mysqli_query($con,"UPDATE name_allotment_wards SET status='vacant' WHERE category='".$admit_mode."' && ward_name='".$ward_name."' && bed_room_name='".$available_beds."'");
	      echo '<script>$("<div title=\'Failure Message\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Something went wrong during admission. <br/>Please try again!!!</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>';   
          
      }
			
	
	
	
   }
?>
<script>
	$(function() {
	    
	 $("#cc_list").hide(); 
        
    $( "#app_date" ).datetimepicker();  
    $( "#app_date" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
    
	    
$( "#mode" ).change(function(){
	var mode=$("#mode").val();
	if(mode=="Credit")
	{
		 $("#cc_list").show(); 
	}
	else
	{
		 $("#cc_list").hide(); 
	}

});

	
$( "#check_name" ).click(function(){
	var patient_id=$("#patient_id").val();
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpatientname.php",
           	   	     	data:"patient_id="+patient_id,
           	   	     	success:function(data){
                              $("#patient_name").html(data);
           	   	     	}
           	   	     });
});
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
            <td colspan="4"><p id="panel">Admit Patient in Hospital</p></td>
            </tr>	
		<table id="table" name="t1" border="4" width="100%">
			<tr>
            <td colspan="4" id="table_head">Admission Details</td>
            </tr>
			<tr>
				<td>Enter UID of patient</td>
          	    <td><input type="text" name="patient_id" id="patient_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Name</td>
          	    <td><select name="patient_name" id="patient_name">
          	    	
          	    </select></td>
			</tr>
			<tr>
                <td>Select Date</td>
                <td><input type="text" id="app_date" name="app_date" required="required" /></td>
                <td>Patient Age</td>
                <td><input type="text" name="age" id="age" size="3" /> years</td>
            </tr>
			<tr>
                <td>Adhaar Number</td>
                <td><input type="text" id="adhaar_num" name="adhaar_num" required="required" /></td>
                <td>Covid Report Number</td>
                <td><input type="text" name="covid_report_num" id="covid_report_num"  /></td>
            </tr>
			<tr>
				<td>Select Admission Mode</td>
          	    <td><select name="admit_mode" id="admit_mode" required="required">
          	    	<option value="">Select..</option>
          	    	
          	    	<option value="IPD">IPD</option>
          	    </select></td>
          	    <td>Select Ward Name</td>
          	    <td><select name="ward_name" id="ward_name" required="required">
          	    	
          	    </select></td>
			</tr>
			<tr>
				<td>Select Bed / Room Number</td>
				<td><select id="available_beds" name="available_beds" required="required">
					
				</select></td>
				<td>Patient Type</td>
                <td><select name="mode" id="mode" required="required">
                    <option value="">Select</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit">Credit</option>
                </select></td>
			</tr>
			<tr id="cc_list">
				
				<td>Select Company</td>
                <td><select name="creditcompany" id="creditcompany">
                    <option value="">Select</option>
                  <?php
					$sql=mysqli_query($con,"SELECT * FROM credit_company_list");
                    while($sql1=mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$sql1[company_name]."'>$sql1[company_name]</option>";
                    }
					?> 
                </select></td>
				<td></td>
				<td></td>
			</tr>
			
			

		<tr>
            <td colspan="4" id="table_head">Investigation Details</td>
            </tr>
			<tr>
				<td>Problem Diagnosed</td>
				<td><input type="text" name="problem" id="problem" required="required" /> </td>
				<td>Under Doctor</td>
				<td><select name="doctor[]" multiple="multiple" required="required">
				    <option value="">Select</option>
					<?php
					$sql=mysql_query("SELECT * FROM doctor_list",$con);
                    while($sql1=mysql_fetch_array($sql))
                    {
                        echo "<option value='".$sql1[doctor_name]."'>$sql1[doctor_name]</option>";
                    }
					?>
					
				</select></td>
				<!--<td>Free Tiffin Required</td>
				<td><select name="tiffin" id="tiffin">
				    <option value="">Select</option>
				    <option value="yes">Yes</option>
				    <option value="no">No</option>
				</select></td>-->
			</tr>
			<tr>
				<td>Referred By</td>
				<td><input type="text" name="referred" id="referred" /></td>
				<td>Referred Contact</td>
				<td><input type="text" name="referred_num" id="referred_num" /></td>
			</tr>
			<tr>
            <td colspan="4" id="table_head">Attender Details</td>
            </tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="attender_name" required="required" /></td>
				<td>Father's Name</td>
				<td><input type="text" name="attender_father_name" required="required"/></td>
			</tr>
			<tr>
				<td>Relation with Patient</td>
				<td><input type="text" name="relation_patient" required="required" /></td>
				<td>Address</td>
				<td><textarea name="attendant_address"></textarea></td>
			</tr>
			<tr>
				<td>Contact Number</td>
				<td><input type="text" name="attender_contact" /></td>
				<td>Email-Id</td>
				<td><input type="text" name="attender_email" /></td>
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
