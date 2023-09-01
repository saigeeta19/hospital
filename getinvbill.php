<?php include 'session.php'; ?>
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);

if($right=="no" )
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>
<style>
    #logout
    {
        display: none;
    }
</style>
<script>
function close_window() {
 
    close();
  
}
</script>

<a href="#" onclick="close_window();return false;">Close </a>
<form name="view_bill" method="post" >
     <p id="panel">Bill Details</p>

     <table id="table" name="t1" border="2" width="100%">
         <tr>
             <th>S.No.</th>
             <th>Investigation</th>
             <th>Amount</th>
         </tr>
         <?php
$num=$_POST['h'];
$amount=0;
$inc=1;
for($k=0;$k<$num;$k++)

    {
       $investigation=$_POST['investigation_'.$k];
       echo "<tr>
       <td align='center'>$inc</td>
       <td align='center'>$investigation</td>";
             $doctor_fees="";
             $query2=mysqli_query($con,"SELECT * FROM investigation_list WHERE investigation_name='".$investigation."'");
             $row2=mysqli_fetch_array($query2);
            $investigation_fees=$row2['price'];
             $amount+=$investigation_fees;
         echo "<td align='center'>Rs. $investigation_fees</td></tr>";
         $inc++;
         }


     
       
     
        
   
    

        
   echo " <tr><td colspan='2' align='center'><b>Total Amount</b></td> <td align='center'><b>Rs. $amount </b></td></tr> </table>
 </form>
";
 
 
?>
