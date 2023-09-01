<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$entry=$_POST['entry'];
$ptype=$_POST['ptype'];

echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>Bill Number</th>
  <th>PID</th>
  <th>UID</th>
  

  <th>Amount</th>
 
</tr>
";

if($entry=="all")
{
$inc=1;$cashtotal=0;$ref=0;$cashreturn=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       
          $query=mysqli_query($con,"SELECT sum(amount) FROM pharmacy_entry WHERE date LIKE '$cdate%' && type='".$ptype."'");
          $query4=mysqli_fetch_array($query);
          $totalcash=$query4['sum(amount)'];
          
            $sql33=mysqli_query($con,"SELECT sum(discount_amount) FROM pharmacy_discounts WHERE date LIKE '$cdate%' && type='".$ptype."'");
            $sql34=  mysqli_fetch_array($sql33);
            $totaldiscounts=$query34['sum(discount_amount)'];
            
            
            $cashtotal=$totalcash-$totaldiscounts;
       
       
       
     
 $swe=mysqli_query($con,"SELECT sum(price) FROM pharmacy_returned WHERE date_time LIKE '$cdate%' && type='".$ptype."'");
          $swe1=mysqli_fetch_array($swe);
           $caret=$swe1['sum(price)'];
          $cashreturn=$cashreturn+$caret;
	$cashreturn=round($cashreturn);
  }    

$cashbal=round($cashtotal-$cashreturn);
echo "<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. ".round($cashtotal)." </td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Returned</td>
<td style='text-align:center;'>Rs. $cashreturn</td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Balance</td>
<td style='text-align:center;'>Rs. $cashbal</td>

</tr>
";

}
else {


	$inc=1;$cashtotal=0;$cashreturn=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       
         $query=mysqli_query($con,"SELECT sum(amount) FROM pharmacy_entry WHERE date LIKE '$cdate%' && pid='".$entry."' && type='".$ptype."'");
          $query4=mysqli_fetch_array($query);
          $totalcash=$query4['sum(amount)'];
          
            $sql33=mysqli_query($con,"SELECT sum(discount_amount) FROM pharmacy_discounts WHERE date LIKE '$cdate%' && type='".$ptype."' ");
            $sql34=  mysqli_fetch_array($sql33);
            $totaldiscounts=$query34['sum(discount_amount)'];
            
            
            $cashtotal=$totalcash-$totaldiscounts;
       
      $swe=  mysqli_query($con,"SELECT sum(price) FROM pharmacy_returned WHERE date_time LIKE '$cdate%' && pid='".$entry."' && type='".$ptype."'");
          $swe1=  mysqli_fetch_array($swe);
          $caret=$swe1['sum(price)'];
          $cashreturn=$cashreturn+$caret;  
$cashreturn=round($cashreturn);
       
}    

 
  $cashbal=round($cashtotal-$cashreturn); 




echo "<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Collected</td>
<td style='text-align:center;'>Rs. ".round($cashtotal)."</td>

</tr>
</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Returned</td>
<td style='text-align:center;'>Rs. $cashreturn</td>

</tr>
<tr>
<td colspan='5' style='text-align:right; padding-right:10px;'>Total Cash Balance</td>
<td style='text-align:center;'>Rs. $cashbal</td>

</tr>
";
}

?>