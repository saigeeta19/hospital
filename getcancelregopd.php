<?php session_start(); 
include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
?>
<?php

$id=$_GET['id'];
$bill=$_GET['bill'];

$sql2=mysqli_query($con,"SELECT * FROM opd_entry WHERE id='".$id."'");
$sql3=mysqli_fetch_array($sql2);
$amount=$sql3['doctor_fees'];
$bill_number=$sql3['bill_number'];
$date=date("d-m-Y H:i:s");

  
$query=mysqli_query($con,"UPDATE opd_entry SET doctor_fees=0,transaction_amount='".$amount."',transaction_time='".$date."',status='cancel' WHERE id='".$id."'");
header("location:cancel_refund_registration_opd.php?msg='cancel'");
exit;
?>
