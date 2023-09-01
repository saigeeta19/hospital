<?php
include('connection.php');
$pro_name=$_POST['pro_name'];

$pro_name1=urlencode($pro_name);
$pro_name1 = str_replace('+','%20',$pro_name1); 
echo "<tr><td>".$pro_name."<input type='hidden' id=".$pro_name1." name='pro[]' value=".$pro_name1." /></td>
<td><input type='text' name='amt[]' size='3' /></td>

</tr>";
?>