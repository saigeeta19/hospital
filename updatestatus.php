<?php
 include 'connection.php';
 
 $id=$_GET['id'];
 $status=$_GET['status'];
 if($status=='booked')
 {
 $query=mysqli_query($con,"UPDATE appointments SET status='completed' WHERE id='".$id."'"); 
 header("location:appointment_book.php?msg='completed'");
exit;
 }
 else if($status=='completed')
 {
  $query=mysqli_query($con,"UPDATE appointments SET status='booked' WHERE id='".$id."'"); 
  header("location:appointment_book.php?msg='booked'");
  exit;
 }



?>