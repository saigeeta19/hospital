<?php
  include "connection.php";
 $item_name=$_REQUEST['item_name'];

 $query=mysqli_query($con,"SELECT sum(quantity) FROM stock_list WHERE name='".$item_name."' && status='entry'");
 $result=mysqli_fetch_array($query);
 $stock=$result['sum(quantity)'];
 
 $query1=mysqli_query($con,"SELECT sum(quantity) FROM stock_list WHERE name='".$item_name."' && status='dispatch'");
 if($query1)
 {
   $result2=mysqli_fetch_array($query1);
   $dispatch=$result2['sum(quantity)'];   
 }
else {
    $dispatch=0;
}
 
$availability=$stock-$dispatch;
 
 
 echo "<td>Availability of Item</td><td colspan='2'>$availability</td>";
 ?>
 