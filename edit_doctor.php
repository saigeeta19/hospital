<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];
$doid=$_GET['proid'];
if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php' ?>
<?php
if($_POST['submit'])
{
	$sdoc_name=$_REQUEST['doctor_name'];
	$doc_name=$_REQUEST['doctor'];
	$designation=$_REQUEST['designation'];
	$fees=$_REQUEST['doctor_fees'];
   
        $query=mysqli_query($con,"UPDATE doctor_list SET doctor_fees='".$fees."',designation='".$designation."' WHERE doctor_name='".$sdoc_name."'");
    if($query)
    {
      echo "<script>alert('Doctor updated successfully');</script>";
      
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
           
	
	
}
?>

<script>
    $(function() {
		
		 var doctor_name=$("#doctor_name").val();
   
   
                     $.ajax({
                        type:"post",
                        url:"getdoctor.php",
                        data:"doctor_name="+doctor_name,
                        success:function(data){
                           $(".getval").html(data);
                         
              }
              });
        
$("#doctor_name").change(function(){
    var doctor_name=$("#doctor_name").val();
   
   
                     $.ajax({
                        type:"post",
                        url:"getdoctor.php",
                        data:"doctor_name="+doctor_name,
                        success:function(data){
                           $(".getval").html(data);
                         
              }
              });
});
});
</script>
<form name="patient_register" method="post">
		
<tr>
            <td colspan="4"><p id="panel">Update Doctor Fees</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Select Doctor</td>
				<td><select name="doctor_name" id="doctor_name">
					<option value="">Select</option>
					<?php
					$sql=mysqli_query($con,"SELECT * FROM doctor_list");
					while($sql1=mysqli_fetch_array($sql))
					{
						echo "<option value='".$sql1['doctor_name']."'";
						if($doid==$sql1['id'])
						{
							  echo " selected";
						}
						echo ">$sql1[doctor_name]</option>";
					}
					?>
					</select>
				</td>
			</tr>
	</table>
	<table id="table" class="getval" name="t1" border="4" width="100%">
		
	</table>
	<table id="table" name="t1" border="4" width="100%">
				<tr>
				<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
    	</table>
</form>

<?php include 'footer.php'; ?>
