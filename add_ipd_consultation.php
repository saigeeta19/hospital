<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];
if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>
<?php
  $query=mysqli_query($con,"SELECT * FROM wards");
  
?>
<?php
if($_POST['submit'])
{
    $category=$_REQUEST['admit_mode'];
    $ward_name=$_REQUEST['ward_name'];
    $conamt=$_REQUEST['con_amt'];
    $doctor=$_REQUEST['doctor'];
    $query=mysqli_query($con,"INSERT INTO doctor_ipd_consultation(category_name,ward_name,doctor_name,consultation_amount) VALUES ('".$category."','".$ward_name."','".$doctor."','".$conamt."')");
    if($query)
    {
      
       echo "<script>alert('Consultation Amount added successfully');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    
    
}
?>
<script>
$(function() {
    $( "#admit_mode" ).change(function(){
    var admit_mode=$("#admit_mode").val();
    
                     $.ajax({
                        type:"post",
                        url:"getwardname.php",
                        data:"admit_mode="+admit_mode,
                        success:function(data){
                              $("#ward_name").html(data);
                        }
                     });
});

});
</script>
<?php include 'sidebar.php' ?>
<?php
$sql=mysqli_query($con,"SELECT * FROM doctor_list");
?>
<form name="bed_room_number" method="post">
        <tr>
        <td><p id="panel">Add Consultation for IPD</p></td>
    </tr>   
    
        <table id="table" name="t1" border="4" width="100%">
            <tr>
                <td>Select Category</td>
                <td><select name="admit_mode" id="admit_mode" required="required">
                    <option value="">Select..</option>
                    
                    <option value="IPD">IPD</option>
                </select></td>
            <td>Select Ward</td>
            <td><select name="ward_name" id="ward_name"  required="required">
                    
                </select></td>
               </tr>
            <tr>
                <td>Select Doctor</td>
                <td><select name="doctor" id="doctor"  required="required" >
                    <option value="">Select</option>
                   <?php
                   while($sql1=mysqli_fetch_array($sql))
                   {
                       echo "<option value='".$sql1[doctor_name]."'>$sql1[doctor_name]</option>";
                   }
                   ?> 
                </select></td>
                <td>Enter Consultation Amount</td>
                <td>Rs. <input type="text" name="con_amt" id="con_amt" size="3"  required="required" /></td>
            </tr> 
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
            </tr>
            <table id="bed_names" name="t1" border="4" width="100%">
                    
                    
            </table>
        </table>
    </form>
<?php include 'footer.php'; ?>