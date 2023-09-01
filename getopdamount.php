<?php
include('connection.php');
        
         $investigation=$_POST['investigation'];
         $query2=mysqli_query($con,"SELECT * FROM investigation_list WHERE investigation_name='".$investigation."'");
         $row2=mysqli_fetch_array($query2);
         echo $investigation_fees=$row2['price'];
            
       
         


?>