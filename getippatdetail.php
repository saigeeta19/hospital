<?php  
include 'connection.php';
$patient_ip_id=$_POST['patient_ip_id'];

$query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
$row=mysqli_fetch_array($query);

echo "<tr><td>Problem Diagnosed</td><td>".$row['problem_diagnosed']."</td>"
        . "<td>Admission Date</td>"
        . "<td>".$row['admission_date']."</td></tr>";

$query12=mysqli_query($con,"SELECT * FROM attenders WHERE patient_ip_id='".$patient_ip_id."'");
$row12=mysqli_fetch_array($query12);

echo "<tr><td>Attendar Name</td><td>".$row12['attender_name']."</td>"
        . "<td>Attendar Address</td>"
        . "<td>".$row12['attender_address']."</td></tr>";

echo "<tr><td>Attendar Contact</td><td>".$row12['attender_contact']."</td>"
        . "<td>Under Doctor</td>"
        . "<td>".$row['admit_under_doctor']."</td></tr>";
?>