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
$proid=$_GET['proid'];
$sql=mysqli_query($con,"SELECT * FROM procedures_list WHERE id='".$proid."'");
$sql1=mysqli_fetch_array($sql);

?>
<?php
if($_POST['submit'])
{
	$pro_name=$_REQUEST['pro_name'];
	$pro_amt=$_REQUEST['pro_amt'];
	$query=mysqli_query($con,"UPDATE procedures_list SET procedure_name='".$pro_name."',procedure_amount='".$pro_amt."' WHERE id='".$proid."'");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Procedure added successfully ');</script>";
	   header("location:view_procedures.php");
	   
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
            <td colspan="2"><p id="panel">Edit Procedures</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Procedure Name</td>
				<td><input type="text" name="pro_name" id="pro_name" value="<?php echo $sql1['procedure_name']; ?>" /></td>
			</tr>
			<tr>
				<td>Procedure Amount</td>
				<td><input type="text" name="pro_amt" id="pro_amt" value="<?php echo $sql1['procedure_amount']; ?>" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Save" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
