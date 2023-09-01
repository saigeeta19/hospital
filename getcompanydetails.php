<?php 
include 'connection.php';

$company=$_POST['company'];
$query=mysqli_query($con,"SELECT * FROM company_list WHERE id='".$company."'");
$row=  mysqli_fetch_array($query);
echo '<tr>
				<td>Company Name</td>
				<td><input type="text" name="company_name" id="company_name" required="required" value="'.$row['company_name'].'" /></td>
				<td>Drug Licence No.</td>
          	    <td><input type="text" name="licence_num" id="licence_num" required="required" value="'.$row['licence_num'].'" /></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><textarea name="address" id="address" required="required">'.$row['address'].'</textarea></td>
				<td>TIN No.</td>
          	    <td><input type="text" name="cts_num" id="cts_num" value="'.$row['cts_num'].'" /></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><input type="text" name="phone" id="phone" required="required" value="'.$row['phone'].'" /></td>
				<td>Email</td>
          	    <td><input type="text" name="email" id="email" value="'.$row['email'].'"/></td>
			</tr>';

  
?>

