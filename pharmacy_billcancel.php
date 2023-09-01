<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
 <?php include 'header.php'; ?>
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
<?php include 'sidebar.php'; ?>
<?php
if($_POST['submit'])
{
     $bill_number=$_REQUEST['bill_number'];
    $query=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
    while($row=mysqli_fetch_array($query))
    {
         $barcode=$row['barcode'];
        $qty=$row['quantity'];
        $query1=  mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE barcode='".$barcode."'");
        $row1=  mysqli_fetch_array($query1);
        $avail=$row1['availability'];
         $navail=$avail+$qty;
        $query2=  mysqli_query($con,"UPDATE pharmacy_availability SET availability='".$navail."'");
        if($query2)
        {
            $query3=  mysqli_query($con,"DELETE FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
            if($query3)
	{
	  
	   echo "<script>alert('Bill Cancel successfull'); printPage();</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
        }
    }
}
?>

<form name="patient_register" method="post" >
     <tr>
            <td colspan="2"><p id="panel">Pharmacy Bill Cancel</p></td>
            </tr>
        <table id="table11"  name="t1" border="2" width="100%" >
            <tr>
               <td id="headus">Bill Number</td>
               <td><input type="text" name="bill_number" id="bill_number" /></td>
                <td colspan="2" align="center"><input type="submit"  id="view" name="submit" value="Cancel Bill"/></td>
            </tr>
        
           
    
    </table>
  
    </form>

<?php include 'footer.php'; ?>
