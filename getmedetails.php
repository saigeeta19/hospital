<?php
include('connection.php');
        
         $barcode=$_POST['barcode'];
         $query=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE id='".$barcode."'");
         $row=  mysqli_fetch_array($query);
         $expiry=$row['expiry_date'];
          //$dateString = "+1 day";
  
 // if(strtotime($expiry) > time()) {
  //   echo "<strong>date is in the future</strong>";
  // }
  
   if(strtotime($expiry) < time()) {
     echo "Medicine is expired. It cannot be added";
   }
   
  
  // if(strtotime($expiry) == time()) {
     //  echo "<strong>date is right now</strong>";
  // }
            
       
         


?>