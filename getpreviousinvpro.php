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
  $query=mysqli_query($con,"SELECT DISTINCT bill_number FROM investigation_entry WHERE patient_id='".$patient_id."' UNION SELECT DISTINCT bill_number FROM procedure_entry WHERE patient_id='".$patient_id."' ORDER BY bill_number DESC");
  $count=mysqli_num_rows($query);
   if($count>0)
   {
  $inc=1;
   // echo "<tr><td colspan='6' align='center'><b>Total Transactions Till Now :- ".$count."</b></td></tr>";
  
  while($result=mysqli_fetch_array($query)){
  	 $bill=$result['bill_number'];
	 
	  $tot=0; $toam=0;
	  $sql=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."' UNION SELECT * FROM procedure_entry WHERE bill_number='".$bill."' ");
	  while($sql1=mysqli_fetch_array($sql))
	  {
	  	 $status=$sql1['status'];
	  if($status=="refund" || $status=="cancel")
	  {
	  	$bilm=$bill."<br/>".$status;
	  }
else {
	$bilm=$bill;
}
	  
		
	  	 $amount=$sql1['investigation_fees'];
		 $tranamt=$sql1['transaction_amount'];
		 $toam=$toam+$tranamt;
	     $tot=$tot+$amount;
		 $date=$sql1['date'];
		 $id=$sql1['id'];
         $date = date(" d-m-Y h:i a", strtotime($date));
	  }
    
    $famt=$tot-$toam;
	
   
	$_SESSION['id']=$id;
	$_SESSION['bill']=$bill;
    echo "<tr><td align='center'>$inc</td>";
    echo "<td align='center'>$date</td>";
    echo "<td align='center'>$bilm</td>";
    echo "<td align='center'>Rs. $famt</td>";
    echo "<td align='center'><a href='#'><input type='hidden'  value=".$bill." /><img src='images/add.png' title='Refund' alt='Refund' name='refund_".$id."' height='20px' width='20px' /></a>&nbsp;<a onclick='return confirm(\"Are You Sure?\");' href='getcancelinvpro.php?bill=".$bill."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a></td></tr>";
  
    $inc=$inc+1;
    
}
   }


//Dental Details
 $query1=mysqli_query($con,"SELECT DISTINCT bill_number FROM  procedure_dental_entry WHERE patient_id='".$patient_id."' ORDER BY bill_number DESC");
  $count=mysqli_num_rows($query1);
   if($count>0)
   {
 
   // echo "<tr><td colspan='6' align='center'><b>Total Transactions Till Now :- ".$count."</b></td></tr>";
  
  while($result1=mysqli_fetch_array($query1)){
  	 $bill=$result1['bill_number'];
	 
	  $tot=0; $toam=0;
	  $sql=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."'");
	  while($sql1=mysqli_fetch_array($sql))
	  {
	  	 $status=$sql1['status'];
	  if($status=="refund" || $status=="cancel")
	  {
	  	$bilm=$bill."<br/>".$status;
	  }
else {
	$bilm=$bill;
}
	  
		
	  	 $amount=$sql1['dental_fees'];
		 $tranamt=$sql1['transaction_amount'];
		 $toam=$toam+$tranamt;
	     $tot=$tot+$amount;
		 $date=$sql1['date'];
		 $id=$sql1['id'];
         $date = date(" d-m-Y h:i a", strtotime($date));
	  }
    
    $famt=$tot-$toam;
	
   
	$_SESSION['id']=$id;
	$_SESSION['bill']=$bill;
    echo "<tr><td align='center'>$inc</td>";
    echo "<td align='center'>$date</td>";
    echo "<td align='center'>$bilm</td>";
    echo "<td align='center'>Rs. $famt</td>";
    echo "<td align='center'><a href='#'><input type='hidden'  value=".$bill." /><img src='images/add.png' title='Refund' alt='Refund' name='refund_".$id."' height='20px' width='20px' /></a>&nbsp;<a onclick='return confirm(\"Are You Sure?\");' href='getcancelinvpro.php?bill=".$bill."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a></td></tr>";
  
    $inc=$inc+1;
    
}
   }


   /*else
    {
        echo "<tr><td colspan='3' align='center'>No transactions till now!!</td></tr>";
    }*/
	
?>

<script>
$(function(){
	var bill;
	$("img[name^='refund_']").click(function() {
		bill=$(this).prev('input').val();
		
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
       	
    location.href = 'getrefundinvpro.php?bill='+bill+'&amt='+c+'&reason='+reason;
      
    });

 });
  </script>


 