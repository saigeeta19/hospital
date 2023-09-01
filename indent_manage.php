<?php session_start(); ?><?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>

<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['admin'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php' ?>

<?php include 'sidebar.php' ?>
<script>
$(document).ready(function(){
    $("#dis").hide();
    
    
});
    $(function() {  
        
$( "#check_name" ).click(function(){
    var patient_ip_id=$("#patient_ip_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getuid.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#patient_id").html(data);
                        }
                     });
});

});
</script>
<form name="view_ip_bill" method="post" action="indent_delete.php">
    <tr>
            <td colspan="4"><p id="panel">View Patient Bill</p></td>
            </tr>   
        <table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Enter IP number of patient</td>
                <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Patient UID / Name</td>
                <td><select name="patient_id" id="patient_id">
                    
                </select></td>
            </tr>
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" id="submit" name="submit" value="Open Bill Breakup" /></p></td>
                
            </tr>
        </table>
           
</form>
<?php include 'footer.php'; ?>
