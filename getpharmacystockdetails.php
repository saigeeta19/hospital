<?php
include 'connection.php';
$barcode=  $_POST['barcode'];
$query=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
$row=  mysqli_fetch_array($query);
echo '<tr>
     <td>Select Date</td>
				<td><input type="text" name="entrydate" id="entrydate" value="'.$row['date_time'].'" /></td>
				<td>Select Company Name</td>
				<td><select name="company_name" id="company_name" required="required">
					';
					$sql=mysqli_query($con,"SELECT * FROM company_list ORDER BY company_name");
					while($sql1=mysqli_fetch_array($sql))
					{
						echo '<option value="'.$sql1['id'].'"';
                                                    if($sql1['id']==$row['id'])
                                                    {
                                                        echo "selected";
                                                    }


echo '>'.$sql1['company_name'].'</option>';
					}
					
					echo '</select>
				</td>
				
			</tr>
			<tr>
                        <td>Expiry Date</td>
				<td><input type="text" name="app_date" id="app_date" value="'.$row['expiry_date'].'" /></td>
				<td>Pharmacy Name</td>
				<td><input type="text" name="pharmacy_name" value="'.$row['name'].'" /></td>
				
			</tr>
			<tr>
                        <td>Generic Name</td>
				
                                    <td><select name="generic_name" id="generic_name" required="required">
                                   
					';
					$sql=mysqli_query($con,"SELECT * FROM pharmacy_generic ORDER BY generic_name");
					while($sql1=mysqli_fetch_array($sql))
					{
						echo '<option value="'.$sql1['id'].'"';
                                                    if($sql1['id']==$row['generalname'])
                                                    {
                                                        echo "selected";
                                                    }


echo '>'.$sql1['generic_name'].'</option>';
					}
					
					echo '</select>
				</td>
				<td>Purchase Rate</td>
				<td><input type="text" name="purchase_rate" value="'.$row['purchase_rate'].'" /></td>
				
			</tr>
			<tr>
                        <td>Sale Rate</td>
				<td><input type="text" name="sale_rate" value="'.$row['price'].'" /></td>
				<td>Batch Number</td>
				<td><input type="text" name="batch_number" value="'.$row['batch_number'].'" /></td>
				
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" name="quantity" value="'.$row['quantity'].'" /></td>
				<td>VAT</td>
				<td><input type="text" name="vat" value="'.$row['vat'].'" /></td>
				
			</tr>
                        <tr>
				<td>Challan Number</td>
				<td><input type="text" name="challan_num" value="'.$row['challan_num'].'" /></td>
				<td>Discount</td>
				<td><input type="text" name="discount" value="'.$row['discount'].'" /></td>
				
			</tr>
			<tr>
				
				<td>Description</td>
				<td><textarea name="description">'.$row['description'].'</textarea></td>
				<td></td>
                                <td></td>
			</tr>';
?>



