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
<?php include 'sidebar.php' ?>

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

<?php
if($_POST['submit'])
{
	$date=$_REQUEST['app_date'];
	$patient_ip_id=$_REQUEST['patient_ip_id'];
	$patient_id=$_REQUEST['patient_id'];
	$surgery_name=$_REQUEST['surgery_name'];
	$surgery_amount=$_REQUEST['surgery_amount'];
        $surgeon_name=$_REQUEST['surgeon_name'];
	$ot_amount=50/100*$surgery_amount;
	$anesthetist_amount=20/100*$surgery_amount;
	$assistant_amount=20/100*$surgery_amount;
	$scrubnurse_amount=10/100*$surgery_amount;
	$total_amount=$surgery_amount+$ot_amount+$anesthetist_amount+$assistant_amount+$scrubnurse_amount;
	$query=mysqli_query($con,"INSERT INTO ot_entry(app_date,patient_ip_id,patient_id,surgery_name,surgeon_name,surgery_amount,ot_amount,anesthetist_amount,assistant_amount,scrubnurse_amount,total_amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$patient_id."','".$surgery_name."','".$surgeon_name."','".$surgery_amount."','".$ot_amount."','".$anesthetist_amount."','".$assistant_amount."','".$scrubnurse_amount."','".$total_amount."','".$entry_person."')");
	 if($query)
    {
      
       echo "<script>alert('OT Entry successfull');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
?>
<form name="add_ward" method="post">
		<tr>
		    <td colspan="4"><p id="panel">OT Entry</p></td>
		</tr>
		<table id="table" name="t1" border="4" width="100%">
			
			 <tr>
				<td>Enter IP number of patient</td>
          	    <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Patient UID / Name</td>
          	    <td><select name="patient_id" id="patient_id">
          	    	
          	    </select></td>
			</tr>
			<tr>
				<td>Select Date of Surgery</td>
          	    <td><input type="text" name="app_date" id="app_date"/></td>
          	   	<td>Enter Surgery Name</td>
          	    <td><input type="text" name="surgery_name" id="surgery_name"/></td>
          </tr>
			<tr>
				<td>Enter Surgery Charges</td>
          	    <td>Rs. <input type="text" name="surgery_amount" id="surgery_amount" size="3" /></td>
          	    <td>Enter Surgeon Name</td>
                    <td><input type="text" name="surgeon_name" id="surgeon_name" /></td>
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		
		</table>
		
		
</form>
<?php include 'footer.php'; ?>
