<?php session_start();?>

<?php include 'connection.php'; ?>

<?php

if($_POST['submit'])
{
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $query=mysqli_query($con,"SELECT * FROM users WHERE username='".$username."' && password='".$password."'");
    $count=mysqli_num_rows($query);
	if($count>0)
    {
        $_SESSION['logger']=$username;
        header("location:maindashboard.php");
        exit;
    }
    else 
        {
             echo "<script>alert('Login Unsuccessfull');</script>";
            
        }
	
}

?>

<?php include 'header.php'; ?>
<style>#logout
	{
		display: none;
	}
	#table
	{
	    border: none;
	}</style>
<div id="heading" align="center">
			<table id="headpanel" >
				<tr>
					<td><a href="">Login </a></td>
				</tr>
			</table>
</div>
<form name="login"  method="post" >
	
		<table id="table" name="t1" width="50%" align="center" >
			
			 <tr>
				<td>Username</td>
          	    <td><input type="text" name="username" id="username"/></td>
          	</tr>
          	<tr>
          	    <td>Password</td>
          	    <td><input type="password" name="password" id="password" /></td>
			</tr>
			<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Login" /></p></td>
			</tr>
			
		</table>
</form>

<?php include 'footer.php' ?>