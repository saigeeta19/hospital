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
$right=$check1['admin'];
if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
<?php
$msg=$_GET['msg'];
$msg=str_replace("'", "", $msg);
$msg=trim($msg);
if($msg=="cancel")
{
    echo "<script>alert('Deleted Successful!!!');</script>"; 
    header("location:add_credit_company.php");
}
?>
<?php include 'header.php'; ?>
<?php
if($_POST['submit'])
{
	$category_name=$_REQUEST['category_name'];
	
	$query=mysqli_query($con,"INSERT INTO `credit_company_list`(`company_name`,`entry_person`,status) VALUES ('".$category_name."','".$entry_person."',1)");
	if($query)
	{
	  
	   echo "<script>alert('Company added successfully');</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
}
?>
<?php 
$query=mysqli_query($con,"select * FROM credit_company_list ORDER BY id ASC");
?>
<?php include 'sidebar.php' ?>
<form name="add_expense_category" method="post">
		<tr>
            <td colspan="4"><p id="panel">Add New Company for Credit</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Company Name</td>
				<td><input type="text" name="category_name" id="category_name"/></td>
				
			</tr>
			
			<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
		<table id="tablepaging" class="yui" name="t1" border="4" width="100%">
              
              <tr>
                  <th>S.No.</th>
                  <th>Company Name</th>
                  <th>Entry By</th>
                  <th>Action</th>
              </tr>
             <?php
			 $inc=1;
             if(mysqli_num_rows($query)>0)
             {
             while($row=mysqli_fetch_array($query))
             {
                 $id=$row['id'];
                 $amount=$row['amount'];
                 echo "
                 <tr>
                   <td align='center'>$inc</td>
                   <td align='center'>$row[company_name]</td>
                  <td align='center'>$row[entry_person]</td>
                   <td align='center'><a href='del_credit_company.php?id=".$id."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a>
    </td>
                 </tr>
                 ";
                 $inc++;
                
             }
             
            
             }
             else {
                 echo "<tr><td align='center' colspan='7' align='center'>No Companies Category recorded till now</td></tr>";
             }
             ?>
          </table>
</form>
<?php include 'footer.php'; ?>