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
$amt=$_GET['amt'];
$reason=$_GET['reason'];
if($amt=="" || $amt==0)
{
	header("location:cancel_refund_registration_opd.php?msg='nope'");
exit;
}
else {
	


$sql2=mysqli_query($con,"SELECT * FROM opd_entry WHERE id='".$id."'");
$sql3=mysqli_fetch_array($sql2);
$amount=$sql3['doctor_fees'];
$amount=$amount-$amt;
$bill_number=$sql3['bill_number'];
$transaction_amt=$sql3['transaction_amount'];
$date=date("d-m-Y H:i:s");
$doctor_fees=$amount;
$amt=$transaction_amt+$amt;
  
$query=mysqli_query($con,"UPDATE opd_entry SET doctor_fees='".$amount."',transaction_amount='".$amt."',transaction_time='".$date."',reason='".$reason."',status='refund' WHERE id='".$id."'");
header("location:cancel_refund_registration_opd.php?msg='refund'");
exit;
}
?>
