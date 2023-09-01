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
$equid=$_GET['equid'];
$sql=mysqli_query($con,"SELECT * FROM equipments_list WHERE id='".$equid."'");
$sql1=mysqli_fetch_array($sql);

?>
<?php
if($_POST['submit'])
{
	$equ_name=$_REQUEST['equ_name'];
	$equ_amt=$_REQUEST['equ_amt'];
	
	$query=mysqli_query($con,"UPDATE equipments_list SET equipment_name='".$equ_name."',equipment_price='".$equ_amt."' WHERE id='".$equid."'");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Equipment updated successfully ');</script>";
	   header("location:view_equipments.php");
	   
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
            <td colspan="2"><p id="panel">Edit Equipments</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Equipment Name</td>
				<td><input type="text" name="equ_name" id="equ_name" value="<?php echo $sql1['equipment_name']; ?>" /></td>
			</tr>
			<tr>
				<td>Equipment Amount</td>
				<td><input type="text" name="equ_amt" id="equ_amt" value="<?php echo $sql1['equipment_price']; ?>" /></td>
			</tr>
			
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Save" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
