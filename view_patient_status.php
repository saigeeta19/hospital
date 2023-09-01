<?php
include 'connection.php';
$patient_ip=$_POST['patient_ip_id'];
$query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip."'");
$row=mysqli_fetch_array($query);
$status=$row['status'];
echo $status;

?>