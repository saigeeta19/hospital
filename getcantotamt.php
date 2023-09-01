<?php
include('connection.php');
$checked=$_POST['checked'];
$inv=explode(",", $checked);
$total=0;
foreach($inv as $da)
{
	
	$query=mysqli_query($con2,"SELECT price FROM je_products WHERE name='".$da."'");
	$row=mysqli_fetch_array($query);
	$amt=$row['price'];
	$total=$total+$amt;
}
echo $total;
//echo "<tr><td>Total</td><td>Rs. ".$total."</tr>";
?>