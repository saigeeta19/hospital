<?php
include 'connection.php';
$bar=$_POST['barcode'];
$qt=$_POST['quantity'];
$query=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$bar."'");
$row=mysqli_fetch_array($query);
$price=$row['price'];
echo $finalp=$price*$qt;
        





?>