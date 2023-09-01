<?php
include('connection.php');
$checked=$_POST['checked'];
$checkedamt=$_POST['checkedamt'];
$pro=explode(",", $checked);
$proam=explode(",", $checkedamt);
$total=0; $i=0;
foreach($pro as $da)
{
	$proname=$da;
	$proamt=$proam['$i'];
	
	$total=$total+$proamt;
	$i++;
}

  echo $total;

?>