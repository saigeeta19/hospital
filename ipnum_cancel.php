<?php session_start(); ?><?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>

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
<?php include 'header.php' ?>
<?php

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
                              alert(data);
                        }
                     });
});

});
</script>
  <?php
    if($_POST['save'])
	{
		$reason="ipcancel /".$_REQUEST['reason'];
		$patient_ip_id=$_REQUEST['patient_ip_id'];
		$query=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
		$row=mysqli_fetch_array($query);
		$category=$_REQUEST['category'];
		$ward_name=$_REQUEST['ward_name'];
		$bed_room_name=$_REQUEST['bed_room_name'];
		$query1=mysqli_query($con,"UPDATE name_allotment_wards SET status='vacant' WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_room_name."'");
		$query2=mysqli_query($con,"DELETE FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
		$query3=mysqli_query($con,"DELETE FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."'");
     	$query4=mysqli_query($con,"DELETE FROM consultation_indents WHERE patient_ip_id='".$patient_ip_id."'");
		$query5=mysqli_query($con,"DELETE FROM investigations_indents WHERE patient_ip_id='".$patient_ip_id."'");
		$query6=mysqli_query($con,"DELETE FROM procedures_indents WHERE patient_ip_id='".$patient_ip_id."'");
		$query7=mysqli_query($con,"DELETE FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."'");
		$query8=mysqli_query($con,"DELETE FROM deposits WHERE patient_ip_id='".$patient_ip_id."'");	
		$query9=mysqli_query($con,"DELETE FROM discounts WHERE patient_ip_id='".$patient_ip_id."'");	
		$query10=mysqli_query($con,"INSERT INTO cancel_ip(patient_ip_id,reason) VALUES ('".$patient_ip_id."','".$reason."')");
	 
	 
	  if($query10 && $query && $query1 && $query2 & $query3 || $query4 || $query5 || $query6 || $query7 || $query8 || $query9)
    {
    	
        echo "<script>alert('Ip Cancelled successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
  
  ?>

<?php include 'sidebar.php' ?>
<script src="js/script.js"></script>
<form name="view_ip_bill" method="post" onsubmit="return confirm('Are you sure?');">
    <tr>
            <td colspan="4"><p id="panel">Cancel IP Number</p></td>
            </tr>   
        <table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Enter IP number of patient</td>
                <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Patient UID / Name</td>
                <td><select name="patient_id" id="patient_id" required="required">
                    
                </select></td>
            </tr>
            <tr>
            	<td>Enter Reason to Cancel</td>
            	<td><textarea name="reason" id="reason" required="required"></textarea></td>
            </tr>
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" id="save" name="save" value="Cancel IP Number" /></p></td>
                
            </tr>
        </table>
           
      
</form>
<?php include 'footer.php'; ?>

