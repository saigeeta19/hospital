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
    $item_name=$_REQUEST['item_name'];
    $item_quantity=$_REQUEST['item_quantity'];
    $entry_issuer=$_REQUEST['entry_issuer'];
    $date_time=$_REQUEST['date_time'];
    $query=mysqli_query($con,"UPDATE stock_list SET name='".$item_name."',quantity='".$item_quantity."',entry_issuer='".$entry_issuer."' WHERE date='".$date_time."'");
    if($query)
    {
      
       echo "<script>alert('Stock updated successfully');</script>";
      
    }
    else 
    {
        echo "<script>alert('Please try again!!!');</script>";
    }
}
?>
<script>
    $(function() {
    
$( "#mode" ).change(function(){
    var mode=$("#mode").val();
    
                     $.ajax({
                        type:"post",
                        url:"getdates.php",
                        data:"mode="+mode,
                        success:function(data){
                         $("#date_time").html(data);                   
                       }
                     });
                     
                    
                     
});
$( "#date_time" ).change(function(){
    var date_time=$("#date_time").val();
    
                     $.ajax({
                        type:"post",
                        url:"getstockdetails.php",
                        data:"date_time="+date_time,
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
            <td colspan="4"><p id="panel">Update Existing Stock Entry</p></td>
            </tr>
        <table id="table" name="t1" border="4" width="100%" >
            
            
            <tr>
                <td>Select Mode</td>
                <td><select name="mode" id="mode">
                    <option value="">Select</option>
                    <option value="entry">Entry</option>
                    <option value="dispatch">Dispatch</option>
                </select></td>
                <td>Select Date/Time</td>
                <td><select name="date_time" id="date_time">
                    
                
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