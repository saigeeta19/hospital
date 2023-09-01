<?php 
include 'connection.php';

$mode=$_POST['mode'];
$query=mysqli_query($con,"SELECT * FROM stock_list WHERE status='".$mode."' ORDER BY id DESC");
echo "<option value=''>Select</option>";
while($result=mysqli_fetch_array($query)){
    $date=$result['date'];
    $date = date(" d-M-Y h:i a", strtotime($date));
   echo "<option value='".$result['date']."'>$date</option>" ;
  }
?>

