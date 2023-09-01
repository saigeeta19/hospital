<?php
  include "connection.php";
 session_start();
 $patient_id=$_POST["patient_id"];

  echo "<tr>
    <th>S.No.</th>
    <th>Time</th>
    <th>Bill Number</th>
    <th>Amount</th>
    <th>Action</th>
        </tr>";
  $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE patient_id='".$patient_id."' ORDER BY STR_TO_DATE(date,'%d-%m-%Y %H:%i:%s') DESC");
  $count=mysqli_num_rows($query);
   if($count>0)
   {
  $inc=1;
   // echo "<tr><td colspan='6' align='center'><b>Total Transactions Till Now :- ".$count."</b></td></tr>";
 
  while($result=mysqli_fetch_array($query)){
    
    $amount=$result['doctor_fees'];
    $date=$result['date'];
    $date = date(" d-m-Y h:i a", strtotime($date));
   
    $id=$result['id'];
	
    $bill=$result['bill_number'];
	$_SESSION['id']=$id;
	$_SESSION['bill']=$bill;
    echo "<tr><td align='center'>$inc</td>";
    echo "<td align='center'>$date</td>";
    echo "<td align='center'>$bill</td>";
    echo "<td align='center'>Rs. $amount</td>";
  //  echo "<td align='center'><a href='getrefundregopd.php?id=".$id."&bill=".$bill."' onclick='return confirm(\"Are You Sure?\");'><img src='images/add.png' title='Refund' alt='Refund' id='refund' height='20px' width='20px'/></a>&nbsp;<a onclick='return confirm(\"Are You Sure?\");' href='getcancelregopd.php?id=".$id."&bill=".$bill."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a></td></tr>";
  
    echo "<td align='center'><a href='#'><img src='images/add.png' title='Refund' alt='Refund' id='refund' height='20px' width='20px'/></a>&nbsp;<a onclick='return confirm(\"Are You Sure?\");' href='getcancelregopd.php?id=".$id."&bill=".$bill."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a></td></tr>";
  
    $inc=$inc+1;
    
}
   }
   else
    {
        echo "<tr><td colspan='3' align='center'>No transactions till now!!</td></tr>";
    }
?>

<script>
$(function(){
	$( "#refund" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });

 $( "#dialog" ).dialog({
      autoOpen: false,
      
      show: {
        effect: "blind",
        duration: 1000
        
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
    
     $("#chk").click(function(){
       var c=$("#amt").val();
       var reason=$("#reason").val();
       var id=<?php echo $id; ?>;
       
    
       
         location.href = 'getrefundregopd.php?id='+id+'&bill='+'<?php echo $bill; ?>'+'&amt='+c+'&reason='+reason;
       
    });

});
	
</script>

 