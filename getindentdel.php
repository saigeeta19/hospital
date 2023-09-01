<?php session_start(); ?>
<?php include 'session.php'; 
include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];



 $val=$_GET['val'];
 $id=$_GET['id'];
 $date_time=date("d-m-Y H:i:s");
 if($val=="inv")
 {
 	
 	$sql=mysqli_query($con,"SELECT * FROM investigations_indents WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="investigation name: ".$sql1['investigation_name']."<br/>Amount: ".$sql1['amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM investigations_indents WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
 else if($val=="pro")
 {
 	$sql=mysqli_query($con,"SELECT * FROM procedures_indents WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="procedure name: ".$sql1['procedure_name']."<br/>Amount: ".$sql1['amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM procedures_indents WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
  else if($val=="equ")
 {
 	$sql=mysqli_query($con,"SELECT * FROM medical_equipments WHERE id='".$id."'");
	$sql1=mysqlifetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="equiments name: ".$sql1['equipments_name']."<br/>Amount: ".$sql1['amount']."<br/>Total Hours: ".$sql1['total_hours'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM medical_equipments WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
  else if($val=="nut")
 {
 	$sql=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="nutrition name: ".$sql1['nutri_name']."<br/>Amount: ".$sql1['amount']."<br/>Total Duration: ".$sql1['start_time']." - ".$sql1['end_time'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM nutrition_indents WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
  else if($val=="ot")
 {
 	$sql=mysqli_query($con,"SELECT * FROM ot_entry WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="ot name: ".$sql1['surgery_name']."<br/>Amount: ".$sql1['total_amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM ot_entry WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
  else if($val=="oth")
 {
 	$sql=mysqli_query($con,"SELECT * FROM other_entry WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="other name: ".$sql1['other_name']."<br/>Amount: ".$sql1['amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM other_entry WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
  else if($val=="con")
 {
 	$sql=mysqli_query($con,"SELECT * FROM consultations_indents WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="consulation: ".$sql1['doctor_name']."<br/>Amount: ".$sql1['amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM consultations_indents WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
 else if($val=="dis")
 {
 	$sql=mysqli_query($con,"SELECT * FROM discounts WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="Discount: ".$sql1['reason']."<br/>Amount: ".$sql1['amount'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM discounts WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
 else if($val=="dep")
 {
 	$sql=mysqli_query($con,"SELECT * FROM deposits WHERE id='".$id."'");
	$sql1=mysqli_fetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="deposits: ".$sql1['status']."<br/>Amount: ".$sql1['amount']."<br/>Mode: ".$sql1['mode'];
    $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
    $query=mysqli_query($con,"DELETE FROM deposits WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
 else if($val=="cauded")
 {
 	$sql=mysqli_query($con,"SELECT * FROM caution_deduction WHERE id='".$id."'");
	$sql1=mysqlifetch_array($sql);
	$patient_ip_id=$sql1['patient_ip_id'];
    $data="caution deduction: ".$sql1['reason']."<br/>Amount: ".$sql1['amount'];
   $query2=mysqli_query($con,"INSERT INTO `userlogs`(`date_time`, `patient_ip_id`, `mode`, `prev_val`, `new_val`, `logger`) VALUES ('".$date_time."','".$patient_ip_id."','".$val."','".$data."','".$data."','".$entry_person."')");
 	$query=mysqli_query($con,"DELETE FROM caution_deduction WHERE id='".$id."'");
	header("location:indent_delete.php?ip=$patient_ip_id");
	exit;
 }
 
?>

