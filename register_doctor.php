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
<?php include 'sidebar.php' ?>
<?php
if($_POST['submit'])
{
	$doc_name=$_REQUEST['doctor_name'];
	$designation=$_REQUEST['designation'];
	$fees=$_REQUEST['fees'];
    $sql=mysqli_query($con,"SELECT * FROM doctor_list WHERE doctor_name='".$doc_name."'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "<script>alert('Doctor already added');</script>";
        header("Refresh:0");
    }
    else {
        $query=mysqli_query($con,"INSERT INTO doctor_list(doctor_name,designation,doctor_fees) VALUES ('".$doc_name."','".$designation."','".$fees."')");
    if($query)
    {
      echo "<script>alert('Doctor added successfully');</script>";
      
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
            }
	
	
}
?>


<form name="patient_register" method="post">
		
<tr>
            <td colspan="4"><p id="panel">Register Doctor</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Enter Name of Doctor</td>
				<td><input type="text" name="doctor_name" /></td>
			</tr>
			<tr>
					<td>Doctor Designation</td>
					<td><input type="text" name="designation" id="designation" /></td>
	    	</tr>
			<tr>
					<td>Consultation Fees</td>
					<td>Rs. <input type="text" name="fees" id="fees" value="200" size="3"/></td>
	    	</tr>
				
		
				<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
    	</table>
</form>

<?php include 'footer.php'; ?>
