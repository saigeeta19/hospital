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
    $barcode=$_REQUEST['barcode'];
   $company_name=$_POST['company_name'];
   $challan_num=$_POST['challan_num'];
	$expiry_date=$_POST['app_date'];
	$pharmacy_name = $_POST['pharmacy_name'];
	$generic_name = $_POST['generic_name'];
	$purchase_rate = $_POST['purchase_rate'];
	$sale_rate = $_POST['sale_rate'];
	$batch_number = $_POST['batch_number'];
        $quantity = $_POST['quantity'];
        $query4=  mysqli_query($con,"UPDATE pharmacy_availability SET availability='".$quantity."' WHERE barcode='".$barcode."'");
	$vat=$_POST['vat'];
	$discount=$_POST['discount'];
	$description=$_POST['description'];
    $query=mysqli_query($con,"UPDATE `pharmacy_stocklist` SET `company_name`='".$company_name."',challan_num='".$challan_num."',`name`='".$pharmacy_name."',`generalname`='".$generic_name."',`batch_number`='".$batch_number."',`quantity`='".$quantity."',`expiry_date`='".$expiry_date."',`purchase_rate`='".$purchase_rate."',`vat`='".$vat."',`discount`='".$discount."',`description`='".$description."',`price`='".$sale_rate."' WHERE barcode='".$barcode."'");
    if($query)
    {
      
       echo "<script>alert('Stock Entry updated successfully');</script>";
      
    }
    else 
    {
        echo "<script>alert('Please try again!!!');</script>";
    }
}
?>
<script>
    $(function() {
    

$( "#barcode" ).change(function(){
    var barcode=$("#barcode").val();
    
                     $.ajax({
                        type:"post",
                        url:"getpharmacystockdetails.php",
                        data:"barcode="+barcode,
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
            <td colspan="4"><p id="panel">Update Stock Entry</p></td>
            </tr>
        <table id="table" name="t1" border="4" width="100%" >
            
            
            <tr>
                <td>Enter Barcode</td>
                <td><input type="text" name="barcode" id="barcode" />&nbsp;&nbsp;<input type="button" name="chk" id="chk" value="View Entry" /></td>
                
            </tr>
            <table id="update_entry" border="4" width="50%" align="center" >
                
            </table>
            
            <tr>
                <td colspan="2"><p id="button" align="center"><input type="submit" name="submit" value="Update" /></p></td>
            </tr>
        </table>
</form>

<?php include 'footer.php';?>