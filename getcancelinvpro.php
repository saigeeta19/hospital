<?php session_start(); 
include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
?>
<?php


$bill=$_GET['bill'];
$date=date("d-m-Y H:i:s");
$sql2=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."'");
$sql3=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
$sql4=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."'");
if(mysqli_num_rows($sql2)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."'",$con);
	while($sql5=mysqli_fetch_array($sql4))
	{
		$id=$sql5['id'];
		$amt=$sql5['investigation_fees'];
		$query=mysqli_query($con,"UPDATE investigation_entry SET investigation_fees=0,transaction_amount='".$amt."',transaction_time='".$date."',status='cancel' WHERE id='".$id."'");
	}
	
  
   
}
else if(mysqli_num_rows($sql3)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."'");
	while($sql5=mysqli_fetch_array($sql4))
	{
	$id=$sql5['id'];
	$amt=$sql5['procedure_fees'];
	$query=mysqli_query($con,"UPDATE procedure_entry SET procedure_fees=0,transaction_amount='".$amt."',transaction_time='".$date."',status='cancel' WHERE id='".$id."'");
   }
}
else if(mysqli_num_rows($sql4)>0)
{
	$sql4=mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."'");
	while($sql5=mysqli_fetch_array($sql4))
	{
	$id=$sql5['id'];
	$amt=$sql5['dental_fees'];
	$query=mysqli_query($con,"UPDATE procedure_dental_entry SET dental_fees=0,transaction_amount='".$amt."',transaction_time='".$date."',status='cancel' WHERE id='".$id."'");
   }
}
header("location:cancel_refund_invpro.php?msg='cancel'");
exit;
?>
