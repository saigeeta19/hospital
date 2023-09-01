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
$query=mysqli_query($con,"SELECT * FROM users");
?>
<?php
if($_POST['submit'])
{
	$name=$_REQUEST['user'];
	$frontoffice=$_REQUEST['frontoffice'];
    $ipd=$_REQUEST['ipd'];
	
	$billing=$_REQUEST['ipbilling'];
	$admin=$_REQUEST['admin'];
	$pharmacy=$_REQUEST['pharmacy'];
   
	if($frontoffice=="")
	{
		$frontoffice="no";
	}
	
	 if($ipd=="")
	{
		$ipd="no";
	}
	 if($billing=="")
	{
		$billing="no";
	}
	 if($admin=="")
	{
		$admin="no";
	}
	if($pharmacy=="")
	{
		$pharmacy="no";
	}
   
	$query1=mysqli_query($con,"INSERT INTO assign_rights(username) VALUES ('".$name."')");
    $query2=mysqli_query($con,"UPDATE assign_rights SET frontoffice='".$frontoffice."',ipd='".$ipd."',billing='".$billing."',admin='".$admin."',pharmacy='".$pharmacy."' WHERE username='".$name."'");
    if($query2)
	{
	  
	   echo "<script>alert('Rights added successfully');</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
}
?>
<?php include 'sidebar.php' ?>
<form name="patient_rights" method="post" >
	 <tr>
            <td colspan="7"><p id="panel">Assign Rights to Users</p></td>
            </tr>
<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Select User</td>
				<td><select name="user">
					<?php
					while($result=mysqli_fetch_array($query))
					{
						echo "<option value=$result[username]>$result[name]</option>";
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td>Select Modules Access</td>
				<td><input type="checkbox" name="frontoffice" id="frontoffice" value="yes"/>Front Office
					<input type="checkbox" name="ipd" id="ipd" value="yes"/>IPD
					
					<input type="checkbox" name="ipbilling" id="ipbilling" value="yes"/>IP Billing
					<input type="checkbox" name="admin" id="admin" value="yes"/>Admin
					<input type="checkbox" name="pharmacy" id="pharmacy" value="yes"/>Pharmacy
			    </td>
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Register User" /></p></td>
			</tr>
            
</table>
</form>
<?php include 'footer.php'; ?>