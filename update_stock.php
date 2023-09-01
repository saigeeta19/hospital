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
$query=mysqli_query($con,"SELECT * FROM stock_names");
?>
<?php
if($_POST['submit'])
{
	$item_name=$_REQUEST['item_name'];
	$item_quantity=$_REQUEST['item_quantity'];
	$date=date("d-m-Y H:i:s");
	$query=mysqli_query($con,"INSERT INTO stock_list(name,quantity,date,entry_issuer,status) VALUES ('".$item_name."','".$item_quantity."','".$date."','".$logger."','entry')");
	if($query)
	{
	  
	   echo "<script>alert('Stock updated successfully');</script>";
	  
	}
	else 
	{
	    echo "<script>alert('Please try again!!!');</script>";
	}
}
?>
<?php include 'sidebar.php' ?>
<form name="update_stock" method="post">
		<tr>
            <td colspan="4"><p id="panel">Update Stock</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			
			<tr>
				<td>Select Stock Item</td>
          	    <td><select name="item_name" id="item_name">
          	    	<option value="">Select</option>
          	    <?php
          	    while($row=mysqli_fetch_array($query))
				{
					echo "<option value='".$row['name']."'>$row[name]</option>";
				}
          	    ?>	
          	    </select></td>
          	</tr>
          	<tr>
          		<td>Enter Quantity</td>
          		<td><input type="text" name="item_quantity" id="item_quantity"/></td>
          	</tr>
			
			<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
</form>

<?php include 'footer.php';?>