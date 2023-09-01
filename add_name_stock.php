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
if($_POST['submit'])
{
	$item_name=$_REQUEST['item_name'];
	$query=mysqli_query($con,"INSERT INTO stock_names (name) VALUES ('".$item_name."')");
    
	if($query)
	{
	   
      	  
	   echo "<script>alert('Stock Item added successfully ');</script>";
	   
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
            <td colspan="2"><p id="panel">Add Item Name to List of Stock</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			<tr>
				<td>Enter Item Name</td>
				<td><input type="text" name="item_name" id="item_name" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Add Items to Stock List" /></td>
			</tr>
	</table>
	</form>
<?php include 'footer.php';?>
