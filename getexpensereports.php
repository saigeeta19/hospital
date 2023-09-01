
<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
$entry=$_POST['entry'];
$category=$_POST['category'];

echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>Reason</th>
  <th>Category</th>
  <th>Amount</th>
  <th>Person</th>
  <th>Entry By</th>
  <th>Action</th>

</tr>
";
$inc=1;$total=0;$str="";
if($entry=="all")
{

for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
	   if($category!="all")
	{
		 $query=mysqli_query($con,"SELECT * FROM expenses WHERE date LIKE '$cdate%' AND expense_category='".$category."'");
	}
	else
	{
       $query=mysqi_query($con,"SELECT * FROM expenses WHERE date LIKE '$cdate%'");
	}
       while($row=mysqli_fetch_array($query))
       {
           
           $date=$row['date'];
           $date = date(" d-M-Y h:i a", strtotime($date));
          $total=$total+$row['amount'];
             echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$row[reason]</td>
            <td align='center'>$row[expense_category]</td>
             <td align='center'>Rs. $row[amount]</td>
             <td align='center'>$row[person]</td>
              <td align='center'>$row[entry_person]</td>
              <td align='center'><a href='deleteexpenses.php?id=".$row['id']."' ><img src='images/cancel.png' /></a></td>
           </tr>
           ";
          
           $inc++;
       }
      
}    

}
else {

$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$entry."'");
$entry1=mysqli_fetch_array($entry);
$entry=$entry1['name'];
  
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
	    if($category!="all")
	{
		 $query=mysqli_query($con,"SELECT * FROM expenses WHERE date LIKE '$cdate%' && entry_person='".$entry."' AND expense_category='".$category."'");
	}
	else{
       $query=mysqli_query($con,"SELECT * FROM expenses WHERE date LIKE '$cdate%' && entry_person='".$entry."'");
	}
       while($row=mysqli_fetch_array($query))
       {
          
           $date=$row['date'];
           
           $date = date(" d-M-Y h:i a", strtotime($date));
          $total=$total+$row['amount'];
             echo "
           <tr>
              <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>$row[reason]</td>
            <td align='center'>$row[expense_category]</td>
             <td align='center'>Rs. $row[amount]</td>
             <td align='center'>$row[person]</td>
              <td align='center'>$row[entry_person]</td>
              <td align='center'><a href='deleteexpenses.php?id=".$row['id']."' ><img src='images/cancel.png' /></a></td>
                 
           </tr>
           ";
          
           $inc++;
       }
       
}    

}
echo "<tr><td colspan='5' style='text-align:right;'>Total</td>
<td style='text-align:center;'>Rs. ".$total."</td>
<td colspan='2' style='text-align:right;'></td>
</tr>";
?>
 