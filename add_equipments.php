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
if($_POST['submit'])
{
	$equipment_name=$_REQUEST['equipment_name'];
	$price=$_REQUEST['price'];
	
	$query=mysqli_query($con,"INSERT INTO equipments_list(equipment_name,equipment_price) VALUES ('".$equipment_name."','".$price."')");
	if($query)
	{
	  
	   echo "<script>alert('Equipment added successfully');</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
}
?>
<?php include 'sidebar.php' ?>
<form name="add_equipment" method="post">
		<tr>
			<td colspan="4"><p id="panel">Add New Equipment </p></td>
			</tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Enter Equipment Name</td>
				<td><input type="text" name="equipment_name" id="equipment_name"/></td>
				<td>Price per Day</td>
          	    <td><input type="text" name="price" id="price"/></td>
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
</form>
<?php include 'footer.php'; ?>