<?php
include "connection.php";
$barcode=$_POST['barcode'];
$query=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE id='".$barcode."'");
if(mysqli_num_rows($query)>0)
{
$row=mysqli_fetch_array($query);
$id=$row['id'];
$pname=$row['name'];
$pamt=$row['price'];
$barc=$row['barcode'];
$sql=mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE barcode='".$barc."'");
$sql1=mysqli_fetch_array($sql);

echo "<tr><td>".$pname."<input type='hidden' name='bh[]' value=".$barcode." /></td>
<td>".$sql1['availability']."</td>
<td><input type='text' name='qty[]' size='3' value='1' /></td>
<td><input type='text' name='rate[]' size='3' value='".$pamt."' disabled='disabled' /></td>
    <td><input type='text' name='amte[]' size='3' disabled='disabled' /></td>
<td align='center'><input type='checkbox' name='ch[]' value='".$barcode."' /></td>
</tr>";
}
?>
