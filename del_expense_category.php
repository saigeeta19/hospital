<?php session_start(); 
include 'connection.php';
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
?>
<?php

$id=$_GET['id'];



  
$query=mysqli_query($con,"DELETE FROM expense_categories WHERE id='".$id."'");
header("location:add_expense_category.php?msg='cancel'");
exit;
?>
