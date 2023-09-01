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
$tranid=$_GET['id'];
$sql=mysqli_query($con,"SELECT * FROM banktransactions WHERE id='".$tranid."'");
$sql1=mysqli_fetch_array($sql);

?>
<?php
if($_POST['submit'])
{
	$status=$_REQUEST['status'];
	
	$query=mysqli_query($con,"UPDATE banktransactions SET status='".$status."' WHERE id='".$tranid."'");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Status updated successfully ');</script>";
	   header("location:add_transaction.php");
	   
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
            <td colspan="2"><p id="panel">Edit Transaction</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Date</td>
				<td><?php echo $sql1['date']; ?></td>
				<td>Reason</td>
				<td><?php echo $sql1['reason']; ?></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><?php echo $sql1['stype']; ?></td>
				<td>By</td>
				<td><?php echo $sql1['person']; ?></td>
			</tr>
			<tr>
				<td>Status</td>
				 <td><select name="status" id="status" required="required">
				<option value="">Select</option>
				<option value="Paid" <?php
				if($sql1['status']=="Paid")
				{
					echo "selected";
				}
				?>>Paid</option>
				<option value="Not Paid" <?php
				if($sql1['status']=="Not Paid")
				{
					echo "selected";
				}
				?> >Not Paid</option>
				</select></td>
				<td>Entry By</td>
				<td><?php echo $sql1['entry_person']; ?></td>
			</tr>
			<tr>
				<td colspan="4" align="center"><input type="submit" name="submit" value="Save" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
