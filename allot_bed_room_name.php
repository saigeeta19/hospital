<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];
if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
<?php include 'header.php'; ?>
<?php
  $query=mysqli_query($con,"SELECT * FROM wards");
  
?>
<?php
if($_POST['submit'])
{
	$category=$_REQUEST['admit_mode'];
	$ward_name=$_REQUEST['ward_name'];
	$bed_name=$_REQUEST['bed_name'];
    $sql=mysqli_query($con,"SELECT * FROM name_allotment_wards WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_name."'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "<script>alert('Bed/Room Name already exists. Please Try Again!!!');</script>";
    }
    else {
        $query=mysqli_query($con,"INSERT INTO name_allotment_wards(category,ward_name,bed_room_name,status) VALUES ('".$category."','".$ward_name."','".$bed_name."','vacant')");
    if($query)
    {
      
       echo "<script>alert('Bed/Room Name added successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    }
	
}
?>
<script>
$(function() {
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
           	   	     	url:"getunnamedbeds.php",
           	   	     	data:"admit_mode="+admit_mode + "&ward_name="+ward_name,
           	   	     	success:function(data){
                              $("#availability").html(data);
           	   	     	}
           	   	     });
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getbednames.php",
           	   	     	data:"admit_mode="+admit_mode + "&ward_name="+ward_name,
           	   	     	success:function(data){
                              $("#bed_names").html(data);
           	   	     	}
           	   	     });
});
});
</script>
<?php include 'sidebar.php' ?>
<form name="bed_room_number" method="post">
		<tr>
        <td><p id="panel">Allot Bed Numbers/Names</p></td>
    </tr>   
    
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td>Select Category</td>
				<td><select name="admit_mode" id="admit_mode">
          	    	<option value="">Select..</option>
          	    	<option value="Emergency">Emergency</option>
          	    	<option value="IPD">IPD</option>
          	    </select></td>
			<td>Select Ward</td>
			<td><select name="ward_name" id="ward_name">
          	    	
          	    </select></td>
          	   </tr>
          	   <tr>
			<td>Available Beds/Rooms Unnamed</td>
			<td><select name="availability" id="availability"></select></td>
			
				<td>Enter Name for Bed/Room</td>
				<td><input type="text" name="bed_name" id="bed_name" /></td>
				
			</tr>
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
			<table id="bed_names" name="t1" border="4" width="100%">
					
					
			</table>
		</table>
	</form>
<?php include 'footer.php'; ?>