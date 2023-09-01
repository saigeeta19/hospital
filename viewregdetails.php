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

if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
<?php include 'header.php';?>
<?php
if($_POST['submit'])
{
	$patient_id=$_REQUEST['patient_id'];
	$pname=$_REQUEST['fname'];
    $co_name=$_REQUEST['co_name'];
    $gender=$_REQUEST['gender'];
	$address=$_REQUEST['address'];
	$phno=$_REQUEST['phno'];
	
	
	$query=mysqli_query($con,"UPDATE patients SET name='".$pname."',co_name='".$co_name."',gender='".$gender."',address='".$address."',phone_number='".$phno."' WHERE uid='".$patient_id."'");
	if($query)
	{
		echo "<script>alert('Patient Updated Successfully!!!');</script>"; 
	}
	else 
		{
			echo "<script>alert('Please Try Again!!!');</script>"; 
		}
	
}
?>


	<script>
	$(function() {
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
$( "#submit" ).click(function(){
	var patient_id=$("#patient_id").val();
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getregdetails.php",
           	   	     	data:"patient_id="+patient_id,
           	   	     	success:function(data){
                              $("#details").html(data);
           	   	     	}
           	   	     });
        $("#submit").hide();
});
});
</script>
<?php include 'sidebar.php' ?>
			
			<tr>
            <td colspan="5"><p id="panel">Update Patient Details</p></td>
            </tr>
			<form name="patient_register" method="post" >
	<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Enter UID of patient</td>
          	    <td><input type="text" name="patient_id" id="patient_id" required="required"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Name</td>
          	    <td><select name="patient_name" id="patient_name" required="required">
          	    	
          	    </select></td>
			</tr>
			<table id="details" name="t1" border="4" width="100%">
					
					
			</table>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="button" id="submit" name="submit1" value="View Registration Details" /></p></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php'; ?>
<style>
#viewpa
	{
		background-color: orange;
	}

#reports
	{
		background-color: orange;
	}
</style>