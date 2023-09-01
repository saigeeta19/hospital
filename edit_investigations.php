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
$invid=$_GET['invid'];
$sql=mysqli_query($con,"SELECT * FROM investigations_list WHERE id='".$invid."'");
$sql1=mysqli_fetch_array($sql);

?>
<?php
if($_POST['submit'])
{
	$inv_name=$_REQUEST['inv_name'];
	$inv_amt=$_REQUEST['inv_amt'];
	$query=mysqli_query($con,"UPDATE investigations_list SET investigation_name='".$inv_name."',investigation_amount='".$inv_amt."' WHERE id='".$invid."'");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Investigation added successfully ');</script>";
	   header("location:view_investigations.php");
	   
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
            <td colspan="2"><p id="panel">Edit Investigations</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Investigation Name</td>
				<td><input type="text" name="inv_name" id="inv_name" value="<?php echo $sql1['investigation_name']; ?>" /></td>
			</tr>
			<tr>
				<td>Investigation Amount</td>
				<td><input type="text" name="inv_amt" id="inv_amt" value="<?php echo $sql1['investigation_amount']; ?>" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Save" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
