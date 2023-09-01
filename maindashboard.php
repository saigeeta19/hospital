<?php session_start(); ?>

<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>

<?php include 'header.php'; ?>
<div id="heading" align="center">
			<table id="headpanel" >
				<tr>
					<td><a href="">Dashboard </a></td>
				</tr>
			</table>
</div>
<table id="dashboard" name="t1" width="auto" align="center" >
				

<?php
$logger=$_SESSION['logger'];
$query=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$result=mysqli_fetch_array($query);
$frontoffice=$result['frontoffice'];
$opd=$result['opd'];
$ipd=$result['ipd'];
$billing=$result['billing'];
$admin=$result['admin'];
$doctor=$result['doctor'];
$pharmacy=$result['pharmacy'];
if($admin=="yes")
{
    echo "<tr><td><a href='register_users.php' class='tsc_3d_button blue'>Admin Panel </a></td></tr>";
}
if($frontoffice=="yes")
{
	echo "<tr><td><a href='register_patient.php' class='tsc_3d_button blue'> Front Office Panel </a></td></tr>";
}
if($opd=="yes")
{
	echo "<tr><td><a href='opd_entry.php' class='tsc_3d_button blue'> Out Patient Panel </a></td></tr>";
}
if($ipd=="yes")
{
	echo "<tr><td><a href='patient_admission.php' class='tsc_3d_button blue'> In Patient Panel </a></td></tr>";
}
if($billing=="yes")
{
	echo "<tr><td><a href='ip_bill.php' class='tsc_3d_button blue'>Billing Panel </a></td></tr>";
}
if($pharmacy=="yes")
{
	echo "<tr><td><a href='pharmacy_entry.php' class='tsc_3d_button blue'>Pharmacy Panel </a></td></tr>";
}

if($doctor=="yes")
{
    echo "<tr><td><a href='add_prescription.php' class='tsc_3d_button blue'> Doctor Panel </a></td></tr>";
}

?>
</tr>
</table>

<?php include 'footer.php'; ?>