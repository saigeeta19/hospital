<?php
include('../store/connect.php');
$id=$_GET['id'];
$result = mysql_query("SELECT * FROM je_orders WHERE id='$id'");
while($row = mysql_fetch_array($result))
	{
		echo '<img src="../store/'.$row['design'].'"><br>';
		echo '<a href="../store/'.$row['design'].'">download</a>';
	}

?>