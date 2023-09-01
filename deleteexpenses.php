<?php
include 'connection.php';
$id=$_GET['id'];
$query=mysqli_query($con,"DELETE FROM expenses WHERE id='".$id."'");
if($query)
{
    echo "<script>alert('Expense deleted successfully');</script>";
    
    header("refresh:0.5;url=total_expenses.php" );
    exit;
}
?>