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
<?php include 'header.php';  ?>
<?php
if($_POST['submit'])
{
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$name=$_REQUEST['name'];
$sql=mysqli_query($con,"SELECT * FROM users WHERE username='".$username."'");
if(mysqli_num_rows($sql)>0)
{
     echo "<script>alert('User already exists'); </script>";
}
else {
	$query=mysqli_query($con,"INSERT INTO users(username,password,name) VALUES ('".$username."','".$password."','".$name."')");
    
    if($query)
    {
      $sql1=mysqli_query($con,"INSERT INTO assign_rights(username) VALUES ('".$username."')");
      echo "<script>alert('User added successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
}

?>
<?php include 'sidebar.php' ?>
<form name="patient_register" method="post" >
 <tr>
            <td colspan="4"><p id="panel">Register New User</p></td>
            </tr>
		<table id="table" name="t1" border="1" width="100%">
			
			<tr>
                <td>Name</td>
                <td><input type="text" name="name" id="name" /></td>
                <td>Username</td>
				<td><input type="text" name="username" id="username" /></td>
		    </tr>
		    <tr>
				<td>Password</td>
				<td><input type="password" name="password" id="password" /></td>
				<td></td>
				<td></td>
			</tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Register User" /></p></td>
			</tr>
			
			</table>
			</form>
<?php include 'footer.php'; ?>