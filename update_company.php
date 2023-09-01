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

<?php include 'header.php';?>

<?php
$query=mysqli_query($con,"SELECT * FROM stock_list");
?>
<?php
if($_POST['submit'])
{
    $company=$_REQUEST['company'];
    $company_name=$_REQUEST['company_name'];
    $licence_num=$_REQUEST['licence_num'];
    $cts_num=$_REQUEST['cts_num'];
    $address=$_REQUEST['address'];
    $email=$_REQUEST['email'];
    $phone=$_REQUEST['phone'];
    $query=mysqli_query($con,"UPDATE company_list SET company_name='".$company_name."',licence_num='".$licence_num."',address='".$address."',cts_num='".$cts_num."',email='".$email."',phone='".$address."' WHERE id='".$company."'");
    if($query)
    {
      
       echo "<script>alert('Company updated successfully');</script>";
      
    }
    else 
    {
        echo "<script>alert('Please try again!!!');</script>";
    }
}
?>
<script>
    $(function() {
    

$( "#company" ).change(function(){
    var company=$("#company").val();
    
                     $.ajax({
                        type:"post",
                        url:"getcompanydetails.php",
                        data:"company="+company,
                        success:function(data){
                         $("#update_entry").html(data);                   
                       }
                     });
                     
                    
                     
});
});
</script>
<?php include 'sidebar.php' ?>
<form name="update_stock" method="post">
        <tr>
            <td colspan="4"><p id="panel">Update Existing Company</p></td>
            </tr>
        <table id="table" name="t1" border="4" width="100%" >
            
            
            <tr>
                <td>Select Company</td>
                <td><select name="company" id="company">
                    <option value="">Select</option>
                    <?php 
                     $sql=  mysqli_query($con,"SELECT * FROM company_list ORDER BY company_name");
                     while($sql1=  mysqli_fetch_array($sql))
                     {
                         echo "<option value='".$sql1['id']."'>$sql1[company_name]</option>";
                     }
                    ?>
                </select></td>
                
            </tr>
            <table id="update_entry" border="4" width="50%" align="center" >
                
            </table>
            
            <tr>
                <td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Update" /></p></td>
            </tr>
        </table>
</form>

<?php include 'footer.php';?>