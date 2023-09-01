<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>
<?php
$msg=$_GET['msg'];
$msg=str_replace("'", "", $msg);
$msg=trim($msg);
if($msg=="refund")
{
    echo "<script>alert('Refund Successful!!!');</script>"; 
}
else if($msg=="cancel")
{
    echo "<script>alert('Cancel Successful!!!');</script>"; 
}
else if($msg=="nope")
{
    echo "<script>alert('Please try Again!!!');</script>"; 
}
$query=mysqli_query($con,"SELECT max(uid) FROM patients");
$row=mysqli_fetch_array($query);
$id=$row['max(uid)'];


?>
<script>
    $(function() {
    	$("#dialog").hide();
$( "#check_name" ).click(function(){
    var patient_id=$("#patient_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getpatientname.php",
                        data:"patient_id="+patient_id,
                        success:function(data){
                              $("#patient_name").html(data);
                        }
                     });
});


$( "#submit" ).click(function(){
    var patient_id=$("#patient_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getpreviousregopd.php",
                        data:"patient_id="+patient_id,
                        success:function(data){
                              $("#transaction").html(data);
                        }
                     });
});



});


</script>

<?php include 'sidebar.php' ?>

<tr>
            <td colspan="5"><p id="panel">Cancel/Refund OPD Bills</p></td>
            </tr>           
<table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Enter UID of patient</td>
                <td><input type="text" name="patient_id" id="patient_id" required='required'/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Name</td>
                <td><select name="patient_name" id="patient_name" required='required'>
                    
                </select></td>
            </tr>
            <table id="transaction" name="t1" border="4" width="100%">
                    
                    
            </table>
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" id="submit" name="submit" value="View Previous Transactions" /></p></td>
            </tr>
        </table>
 <div id="dialog">
  <p>Enter Amount to refund:- &nbsp; <input type="text" name="amt" id="amt" size="3"/></p>
  <p>Reason</p>
  <p><textarea name="reason" id="reason" required="required"></textarea>   </p>
  <p>&nbsp; &nbsp;<input type="button" id="chk" value="Done">
  </p>
</div>
       
       
        
<?php include 'footer.php'; ?>
<style>
#cancel
    {
        background-color: orange;
    }
</style>