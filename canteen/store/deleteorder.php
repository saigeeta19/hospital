<?php
include('connect.php');
if($_GET['id'])
{
$id=$_GET['id'];
 $sql = "DELETE from je_orders WHERE id='$id'";
 header("location: index.php");
 mysql_query( $sql);
}

?>