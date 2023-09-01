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
	$dental_name=$_REQUEST['dental_name'];
	
	
	$query=mysqli_query($con,"INSERT INTO dental_list(dental_name) VALUES ('".$dental_name."')");
	if($query)
	{
	  
	   echo "<script>alert('Dental Procedure added successfully');</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
}
?>
<?php include 'sidebar.php' ?>
<form name="add_procedure" method="post">
		<tr>
            <td colspan="4"><p id="panel">Add New Dental Procedure</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
                            <td>Procedure Name</td>
                            <td colspan="3"><input type="text" name="dental_name" id="dental_name"/></td>
				
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
</form>
<?php include 'footer.php'; ?>