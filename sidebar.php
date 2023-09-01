<div class="container"  style="border: solid 1px #FFFFFF;  ">
    <div class="column" style="width:20%;float:left; background-color:#CCCCCC;color:#000000;" >
    	<?php
    	   if($check1['frontoffice']=="yes") {
                
                include 'frontoffice_sidebar.php';
            }  
            if($check1['opd']=="yes") {
   
                include 'opd_sidebar.php';
            } 
            if($check1['ipd']=="yes") {
   
                include 'ipd_sidebar.php';
            } 
    	   if($check1['billing']=="yes") {
   
                include 'billing_sidebar.php';
            } 
            if($check1['admin']=="yes")
            {
                include 'admin_sidebar.php';
            }
            if($check1['doctor']=="yes")
            {
                include 'doctor_sidebar.php';
            }
			 if($check1['pharmacy']=="yes") {
   		
                include 'pharmacy_sidebar.php';
            }  
           
           
           
    	
    	?>


    	
    </div>
    <div class="column" style="width:80%;float:left;" >