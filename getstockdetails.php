<?php 
include 'connection.php';

$date_time=$_POST['date_time'];
$query=mysqli_query($con,"SELECT * FROM stock_list WHERE date='".$date_time."' ORDER BY id DESC");
$result=mysqli_fetch_array($query);
$date=$result['date'];
$date = date(" d-M-Y h:i a", strtotime($date));
echo "
<tr>
   <td>Date</td>
   <td>$date</td>
</tr>
<tr>
   <td>Name</td>
   <td><input type='text' name='item_name' id='item_name' value='".$result['name']."'/></td>
</tr>
<tr>
   <td>Quantity</td>
   <td><input type='text' name='item_quantity' id='item_quantity' value='".$result['quantity']."'/></td>
</tr>
<tr>
   <td>By Person</td>
   <td><input type='text' name='entry_issuer' id='entry_issuer' value='".$result['entry_issuer']."'/></td>
</tr>
";
?>
