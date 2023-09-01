<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php include 'header.php' ?>

<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['billing'];

if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>

<script>

	$(function() {
	 $(".mes").hide();	
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
                        url:"view_patient_status.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                             
                               if(data=="admitted")
                                {             
                                 $(".dis").show();
                                 $(".mes").hide();
                                }
                                 else if(data=="discharged")
                                 {
                                     $(".dis").hide();
                                     $(".mes").show();
                                 }
                        }
                     });
    
         	    
});
$( "#submit" ).click(function(){
	
	var patient_ip_id=$("#patient_ip_id").val();
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getipbillamount.php",
           	   	     	data:"patient_ip_id="+patient_ip_id,
           	   	     	success:function(data){
                              $("#patient_check").html(data);
           	   	     	}
           	   	     });
    
         	    
});


});
</script>

<?php
if($_POST['submit'])
{
	$date=date("d-m-Y H:i:s");
	$patient_ip_id=$_REQUEST['patient_ip_id'];
	$patient_id=$_REQUEST['patient_id'];
	$amount=$_REQUEST['amount'];
	$reason=$_REQUEST['reason'];
   
    
	$query=mysqli_query($con,"INSERT INTO discounts(patient_ip_id,patient_id,date,amount,reason,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$amount."','".$reason."','".$entry_person."')");
    if($query)
	{
	  
	   echo "<script>alert('Discount Entry successfull');</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
    
   
}
?>
<?php include 'sidebar.php' ?>
<form name="deposit" method="post" onsubmit="return confirm('Are you sure?');">
		<tr>
            <td colspan="4"><p id="panel">Discount Entry</p></td>
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
				<td>Enter Amount to Discount</td>
				<td>Rs. <input type="text" name="amount" id="amount" size="5" value="0"/></td>
				<td>Enter Reason </td>
				<td> <textarea name="reason" id="reason" required="required"></textarea></td>
			</tr>
		</table>
		<div class="dis">
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" id="submit" name="submit" value="Add Discount" /></p></td>
			</tr>
		</table>
		
		 </div>
        <div class="mes" style="text-align: center; padding-top:20px; color:#930000;">
			Please enter correct IP number.
		</div>
	</form>

<?php include 'footer.php'; ?>

