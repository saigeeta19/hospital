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
<?php include 'header.php'; ?>
<?php
if($_POST['submit'])
{
	$generic=$_REQUEST['generic_name'];
	
	
	$query=mysqli_query($con,"INSERT INTO pharmacy_generic(generic_name) VALUES ('".$generic."')");
	if($query)
	{
	   echo "<script>alert('Generic Name added successfully');</script>";
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
			<td colspan="2"><p id="panel">Add New Generic Name </p></td>
			</tr>
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td>Generic Name</td>
				<td><input type="text" name="generic_name" id="generic_name" required="required" /></td>
				
			</tr>
			
			<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
		<div>
			
		</div>
</form>
<?php include 'footer.php'; ?>