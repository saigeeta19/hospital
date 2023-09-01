<?php
include('connection.php');
$inv_name=$_POST['inv_name'];
$query=mysqli_query($con,"SELECT * FROM investigations_list WHERE investigation_name='".$inv_name."'");
$row=mysqli_fetch_array($query);
$inv_amt=$row['investigation_amount'];
$inv_name1=urlencode($inv_name);
$inv_name1 = str_replace('+','%20',$inv_name1); 
echo "<tr><td>".$inv_name."<input type='hidden' name=".$inv_name1." /></td>
<td>Rs. ".$inv_amt."</td>

</tr>";
?>