<?php session_start(); 
include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
?>
<?php


$bill=$_GET['bill'];
$amt=$_GET['amt'];
$reason=$_GET['reason'];
$date=date("d-m-Y H:i:s");
if($amt=="" || $amt==0)
{
	header("location:cancel_refund_invpro.php?msg='nope'");
exit;
}

else {
$sql2=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."'");
$sql3=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
$sql4=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."'");
if(mysqli_num_rows($sql2)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."'");
	$sql5=mysqil_fetch_array($sql4);
	$id=$sql5['id'];
	$query=mysqli_query($con,"UPDATE investigation_entry SET transaction_amount='".$amt."',transaction_time='".$date."',status='refund' WHERE id='".$id."'");
	$query1=mysqli_query($con,"UPDATE investigation_entry SET status='refund' WHERE bill_number='".$bill."'");
	
  
   
}
else if(mysqli_num_rows($sql3)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
	$sql5=mysqli_fetch_array($sql4);
	$id=$sql5['id'];
	$query=mysqli_query($con,"UPDATE procedure_entry SET transaction_amount='".$amt."',transaction_time='".$date."',status='refund' WHERE id='".$id."'");
	$query1=mysqli_query($con,"UPDATE procedure_entry SET status='refund' WHERE bill_number='".$bill."'");
   
}
else if(mysqli_num_rows($sql4)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."'");
	$sql5=mysqli_fetch_array($sql4);
	$id=$sql5['id'];
	$query=mysqli_query($con,"UPDATE procedure_dental_entry SET transaction_amount='".$amt."',transaction_time='".$date."',status='refund' WHERE id='".$id."'");
	$query1=mysqli_query($con,"UPDATE procedure_dental_entry SET status='refund' WHERE bill_number='".$bill."'");
   
}
header("location:cancel_refund_invpro.php?msg='refund'");
exit;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$sql2=mysql_query("SELECT * FROM opd_entry WHERE id='".$id."'",$con);
$sql3=mysql_fetch_array($sql2);
$amount=$sql3[doctor_fees];
$amount=$amount-$amt;
$bill_number=$sql3[bill_number];
$transaction_amt=$sql3[transaction_amount];
$date=date("d-m-Y H:i:s");
$doctor_fees=$amount;
$amt=$transaction_amt+$amt;
  
$query=mysql_query("UPDATE opd_entry SET doctor_fees='".$amount."',transaction_amount='".$amt."',transaction_time='".$date."',reason='".$reason."',status='refund' WHERE id='".$id."'",$con);
header("location:cancel_refund_registration_opd.php?msg='refund'");
exit;
}
?>
