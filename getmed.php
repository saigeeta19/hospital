<?php
include 'connection.php'; 
$batch=$_POST['batch'];
$query=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE batch_number='".$batch."'");
while($row=  mysqli_fetch_array($query))
{
    echo "<option value='".$row['id']."'>$row[name]</option>";
}


?>