<?php
  include 'connection.php';
  $query=mysqli_query($con,"SELECT * FROM pharmacy_availability");
  while($row=mysqli_fetch_array($query))
  {
	
  	  $barcode=$row['barcode'];
	  
	  $query1=mysqli_query($con,"DELETE FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
	  if($query1)
	  {
	  	echo "success";
		
	  }
	  else {
		  echo "failure";
	  }
  }

?>