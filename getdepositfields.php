<?php
include 'connection.php';
$mode=$_POST['mode'];
if($mode=="Card")
{
                         echo '<tr>
				<td>Bank Name</td>
				<td><input type="text" name="card_bank_name" id="card_bank_name" required="required"  /></td>
				<td>Card Holder Name</td>
				<td><input type="text" name="card_holder" id="card_holder" required="required" /></td>
				
			</tr>'; 
}
else if($mode=="Cheque")
{
     echo '<tr>
				<td>Bank Name</td> 
				<td><input type="text" name="cheque_bank_name" id="cheque_bank_name"  required="required" /></td>
				<td>Cheque Issuer Name</td>
				<td><input type="text" name="cheque_holder" id="cheque_holder" required="required" /></td>
                                <td>Cheque Number</td>
				<td><input type="text" name="cheque_number" id="cheque_number" required="required" /></td>
				
			</tr>'; 
}
else
{
    
}
    
?>