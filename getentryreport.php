<?php
include 'connection.php';
$item_name=$_POST['item_name'];
$query=mysqli_query($con,"SELECT * FROM stock_list WHERE name='".$item_name."' && status='entry'");
$inc=1;
echo "<tr>
<th>S.No.</td>
<th>Date</td>
<th>Quantity</td>
<th>Place/Person</td>
</tr>
";
while($row=mysqli_fetch_array($query))
{
	$date=$row['date'];
    $date = date(" d-M-Y h:i a", strtotime($date));
	echo "
	<tr>
	<td>$inc</td>
	<td>$date</td>
	<td>$row[quantity]</td>
	<td>$row[entry_issuer]</td>
	</tr>
	";
	$inc++;
}

?>