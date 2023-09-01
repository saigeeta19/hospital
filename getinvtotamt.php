<?php
include('connection.php');
$checked=$_POST['checked'];
$inv=explode(",", $checked);
$total=0;
foreach($inv as $da)
{
	
	$query=mysqli_query($con,"SELECT investigation_amount FROM investigations_list WHERE investigation_name='".$da."'");
	$row=mysqli_fetch_array($query);
	$amt=$row['investigation_amount'];
	$total=$total+$amt;
}
echo $total;
//echo "<tr><td>Total</td><td>Rs. ".$total."</tr>";
?>