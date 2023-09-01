
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
<?php include 'header.php'; ?>
<?php include 'upc_code.php'; ?>

<?php

if($_POST['submit'])
{
	$company_name=$_POST['company_name'];
        $challan_num=$_POST['challan_num'];
	$expiry_date=$_POST['app_date'];
	$pharmacy_name = $_POST['pharmacy_name'];
	$generic_name = $_POST['generic_name'];
	$purchase_rate = $_POST['purchase_rate'];
	$sale_rate = $_POST['sale_rate'];
	$batch_number = $_POST['batch_number'];
	$barcode=date("Hisdmy");
    $check=generate_upc_checkdigit($barcode);
    $barcode=$barcode.$check;
	$quantity = $_POST['quantity'];
	$vat=$_POST['vat'];
	$discount=$_POST['discount'];
	$description=$_POST['description'];
	$date_time=$_POST['entrydate'];
	
	
     
     $query = mysqli_query($con,"INSERT INTO `pharmacy_stocklist`(`date_time`,challan_num,company_name, `name`, `generalname`, `barcode`,`batch_number`, `quantity`, `expiry_date`, `purchase_rate`, `vat`, `discount`, `description`, `price`,`entry_person`) VALUES ('".$date_time."','".$challan_num."','".$company_name."','".$pharmacy_name."','".$generic_name."','".$barcode."','".$batch_number."','".$quantity."','".$expiry_date."','".$purchase_rate."','".$vat."','".$discount."','".$description."','".$sale_rate."','".$entry_person."')");
     $query1=mysqli_query($con,"INSERT INTO pharmacy_availability (barcode,availability) VALUES ('".$barcode."','".$quantity."')");
 
	if($query && $query1)
	{
	  
	   echo "<script>alert('Data Entry successfull'); printPage();</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
}
?>
<script>

	$(function() {
	$( "#entrydate" ).datepicker();	
	$( "#entrydate" ).datepicker("option", "dateFormat", "dd-mm-yy");	
		
	$( "#app_date" ).datepicker();	
	$( "#app_date" ).datepicker("option", "dateFormat", "dd-mm-yy");
	
	});
</script>
<?php include 'sidebar.php' ?>
<form name="add_equipment" method="post">
		<tr>
			<td colspan="4"><p id="panel">Add Pharmacy to Stock </p></td>
			</tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
                             <td>Select Date</td>
				<td><input type="text" name="entrydate" id="entrydate" /></td>
				<td>Select Company Name</td>
				<td><select name="company_name" id="company_name" required="required">
					<?php
					$sql=mysqli_query($con,"SELECT * FROM company_list ORDER BY company_name");
					while($sql1=mysqli_fetch_array($sql))
					{
						echo "<option value='".$sql1['id']."'>$sql1[company_name]</option>";
					}
					?>
					</select>
				</td>
				
			</tr>
			<tr>
                                <td>Expiry Date</td>
				<td><input type="text" name="app_date" id="app_date" /></td>
				<td>Pharmacy Name</td>
				<td><input type="text" name="pharmacy_name" /></td>
				
			</tr>
			<tr>
                            <td>Generic Name</td>
				<td><select name="generic_name">
                                        <option value="">Select</option>
                                        <?php
                                        $d=mysqli_query($con,"SELECT * FROM pharmacy_generic ORDER BY generic_name");
                                        while($k=mysqli_fetch_array($d))
                                        {
                                            echo "<option value='".$k['id']."'>$k[generic_name]</option>";
                                        }
                                        ?>
                                    </select></td>
				<td>Purchase Rate</td>
				<td><input type="text" name="purchase_rate" /></td>
				
			</tr>
			<tr>
                            <td>Sale Rate</td>
				<td><input type="text" name="sale_rate" /></td>
				<td>Batch Number</td>
				<td><input type="text" name="batch_number" /></td>
				
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" name="quantity" /></td>
				<td>VAT</td>
				<td><input type="text" name="vat" /></td>
				
			</tr>
                        <tr>
                            <td>Challan Number</td>
				<td><input type="text" name="challan_num" /></td>
                                <td>Discount</td>
				<td><input type="text" name="discount" /></td>
				
                        </tr>
			<tr>
				
				<td>Description</td>
				<td><textarea name="description"></textarea></td>
				<td></td>
				<td></td>
			</tr>
			
		</table>
		
		<table id="table" name="t1" border="4" width="100%">	
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		</table>
		
</form>
<?php include 'footer.php'; ?>
