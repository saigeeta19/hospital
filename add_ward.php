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
	$ward_name=$_REQUEST['ward_name'];
	$num=$_REQUEST['num_beds'];
	$category=$_REQUEST['category'];
	$rent=$_REQUEST['rent'];
    $nursing_charge=$_REQUEST['nursing_charge'];
	$housekeeping_charge=$_REQUEST['housekeeping_charge'];
    $sql=mysqli_query($con,"SELECT * FROM wards WHERE category='".$category."' && ward_name='".$ward_name."'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "<script>alert('Ward already added!!');</script>";
    }
    else {
        $query=mysqli_query($con,"INSERT INTO wards(category,ward_name,rent_per_unit,number_beds_rooms,nursing_charge,housekeeping_charge) VALUES ('".$category."','".$ward_name."','".$rent."','".$num."','".$nursing_charge."','".$housekeeping_charge."')");
    if($query)
    {
      
       echo "<script>alert('Ward added successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    }
	
}
?>
<?php include 'sidebar.php' ?>
<form name="add_ward" method="post">
	<tr>
            <td colspan="4"><p id="panel">Add New Ward in Hospital</p></td>
            </tr>	
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td>Select Category</td>
				<td><select name="category">
				    <option value="">Select</option>
					<option value="Emergency">Emergency</option>
					<option value="IPD">IPD</option>
				</select></td>
				<td>Name of Ward</td>
          	    <td><input type="text" name="ward_name" id="ward_name"/></td>
			</tr>
			<tr>
				<td>Number of Beds/Rooms</td>
          	    <td><input type="text" name="num_beds" id="num_beds" /></td>
          	    <td>Bed/Room Rent per day</td>
          	    <td><input type="text" name="rent" id="rent" /></td>
			</tr>
			<tr>
			    <td>Nursing Charges</td>
			    <td>Rs. <input type="text" name="nursing_charge" id="nursing_charge" size="3" value="0" /></td>
				 <td>House Keeping Charges</td>
			    <td>Rs. <input type="text" name="housekeeping_charge" id="housekeeping_charge" size="3" value="0" /></td>
			</tr>
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
</form>
<?php include 'footer.php'; ?>