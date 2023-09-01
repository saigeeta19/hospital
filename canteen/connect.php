<?php



/* Database config */

$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'canteen'; 

/* End config */



$link = mysqli_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysqli_select_db($db_database,$link);
mysqli_query("SET names UTF8");

?>