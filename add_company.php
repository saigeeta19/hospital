<?php session_start(); ?>
<?php include 'session.php';?> 
<?php include 'connection.php';

 ?>
<?php
 	$logger=$_SESSION['logger'];
	$entry=mysqli_query($con,"SELECT * FROM users WHERE username='' ");
	$entry1=mysqli_fetch_array($entry);
	$entry_person=$entry1['name'];
	$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username=''");
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
		$company_name=$_REQUEST['company_name'];
		$licence_num=$_REQUEST['licence_num'];
		$address=$_REQUEST['address'];
		$cts_num=$_REQUEST['cts_num'];
		$phone=$_REQUEST['phone'];
		$email=$_REQUEST['email'];
		
		$query=mysqli_query($con,"INSERT INTO company_list(company_name,licence_num,address,cts_num,phone,email,entry_person) VALUES ('".$company_name."','".$licence_num."','".$address."','".$cts_num."','".$phone."','".$email."','".$entry_person."')");
		if($query)
		{
		echo "<script>alert('Company added successfully');</script>";
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
				<td colspan="4"><p id="panel">Add New Company </p></td>
				</tr>
			<table id="table" name="t1" border="4" width="100%">
				<tr>
					<td>Company Name</td>
					<td><input type="text" name="company_name" id="company_name" required="required" /></td>
					<td>Drug Licence No.</td>
					<td><input type="text" name="licence_num" id="licence_num" required="required" /></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><textarea name="address" id="address" required="required"></textarea></td>
					<td>TIN No.</td>
					<td><input type="text" name="cts_num" id="cts_num" /></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td><input type="text" name="phone" id="phone" required="required"/></td>
					<td>Email</td>
					<td><input type="text" name="email" id="email"/></td>
				</tr>
				<tr>
					<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
				</tr>
			</table>
			<div>
				
			</div>
	</form>
<?php include 'footer.php'; ?>