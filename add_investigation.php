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
	$investigation_name=$_REQUEST['investigation_name'];
	$price=$_REQUEST['price'];
	$sql=mysqli_query($con,"SELECT * FROM add_investigation WHERE investigation_name='".$investigation_name."'");
    if(mysqli_num_rows($sql)>0)
    {
         echo "<script>alert('Investigation already exists!!');</script>";
    }
    else {
        $query=mysqli_query($con,"INSERT INTO investigations_list(investigation_name,investigation_amount) VALUES ('".$investigation_name."','".$price."')");
    if($query)
    {
      
       echo "<script>alert('Investigation added successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    }
	
}
?>
<?php include 'sidebar.php' ?>
<form name="add_investigation" method="post">
		<tr>
            <td colspan="4"><p id="panel">Add New Investigation</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Investigation Name</td>
				<td><input type="text" name="investigation_name" id="investigation_name"/></td>
				<td>Price</td>
          	    <td>Rs. <input type="text" name="price" id="price" size="3"/></td>
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
</form>
<?php include 'footer.php'; ?>