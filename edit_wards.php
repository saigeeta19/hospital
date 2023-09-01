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
$wardid=$_GET['wardid'];
$sql=mysqli_query($con,"SELECT * FROM wards WHERE id='".$wardid."'");
$sql1=mysqli_fetch_array($sql);

?>
<?php
if($_POST['submit'])
{
	$ward_name=$_REQUEST['ward_name'];
	$ward_amt=$_REQUEST['ward_amt'];
	$nur_amt=$_REQUEST['nur_amt'];
	$hou_amt=$_REQUEST['hou_amt'];
	$query=mysqli_query($con,"UPDATE wards SET ward_name='".$ward_name."',rent_per_unit='".$ward_amt."',nursing_charge='".$nur_amt."',housekeeping_charge='".$hou_amt."' WHERE id='".$wardid."'");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Ward updated successfully ');</script>";
	   header("location:view_wards.php");
	   
	}
	else 
	{
	    echo "<script>alert('Please try again!!!');</script>";
	}
}
?>
<?php include 'sidebar.php';?>

<form name="add_order" method="post">
		<tr>
            <td colspan="2"><p id="panel">Edit Wards</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Ward Name</td>
				<td><input type="text" name="ward_name" id="ward_name" value="<?php echo $sql1['ward_name']; ?>" /></td>
			</tr>
			<tr>
				<td>Ward Amount</td>
				<td><input type="text" name="ward_amt" id="ward_amt" value="<?php echo $sql1['rent_per_unit']; ?>" /></td>
			</tr>
			<tr>
				<td>Nursing Amount</td>
				<td><input type="text" name="nur_amt" id="nur_amt" value="<?php echo $sql1['nursing_charge']; ?>" /></td>
			</tr>
			<tr>
				<td>House Keeping Amount</td>
				<td><input type="text" name="hou_amt" id="hou_amt" value="<?php echo $sql1['housekeeping_charge']; ?>" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Save" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
