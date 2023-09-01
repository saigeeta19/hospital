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
     <?php include 'sidebar.php'; ?>
     
     <?php
$query=mysqli_query($con,"SELECT * FROM pharmacy_entry GROUP BY bill_number ORDER BY STR_TO_DATE(`date`,'%d-%m-%Y %H:%i:%s') DESC");
?>
<script>
    $(document).ready(function()
{
    $('#search').keyup(function()
    {
        searchTable($(this).val());
    });
});

function searchTable(inputVal)
{
    var table = $('#tablepaging');
    table.find('tr').each(function(index, row)
    {
        var allCells = $(row).find('td');
        if(allCells.length > 0)
        {
            var found = false;
            allCells.each(function(index, td)
            {
                var regExp = new RegExp(inputVal, 'i');
                if(regExp.test($(td).text()))
                {
                    found = true;
                    return false;
                }
            });
            if(found == true)$(row).show();else $(row).hide();
        }
    });
}
    
</script>

<form name="opd_list" method="post">
    <tr>
            <td colspan="5"><p id="panel">Pharmacy Billing Dashboard</p></td>
            </tr>
    <tr >
                <td colspan="5">
            <p align="right">
        <label for="search">
            <strong>Search</strong>
        </label>
        <input type="text" id="search" align="right"/>&nbsp;
</p></td>
</tr>       
        <table id="tablepaging" class="yui" name="t1" border="4" width="100%" >
            
            
            <tr>
                <th>Date</th>
                <th>UID/PID</th>
                 <th>Patient Name</th>
                <th>Bill Number</th>
                
                <th>Total </th>
                <th>Action</th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($query))
            {
                $pmaxid=$row['id'];
                $uid=$row['patient_id'];
                $bill_number=$row['bill_number'];
                $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                $date=$row['date'];
                $date = date(" d-M-Y h:i a", strtotime($date));
                $barcode=$row['barcode'];
				$sql67=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
				$sql68=mysqli_fetch_array($sql67);
				$rate=$sql68['price'];
                $status=$row['status'];
                if($status=='cancel' || $status=='refund')
                {
                    $bill_num=$row['bill_number']." (Bill".$status.")";
                }
                else {
                     $bill_num=$row['bill_number'];
                }
                $sql33=  mysqli_query($con,"SELECT * FROM pharmacy_discounts WHERE bill_number='".$bill_number."'");
                if(mysqli_num_rows($sql33)>0)
                {
                $sql34=  mysqli_fetch_array($sql33);
                $discountamt=$sql34['discount_amount'];
                }
                else
                {
                    $discountamt=0;
                }
                
                //get totalamount paid
                $sql6756=mysqli_query($con,"SELECT sum(amount) FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
				$sql6856=mysqli_fetch_array($sql6756);
				$amount=$sql6856['sum(amount)'];
                
                
                
               
                $paidamt=$amount-$discountamt;
               
            echo "
            <tr>
            <td align='center'>$date</td>
            
            <td align='center'>$row[patient_id]/$row[pid]</td>
            
            <td align='center'>$patient_name</td>
            <td align='center'>$bill_num</td>
            
           
               <td align='center'>Rs. ".round($paidamt)."</td>
           
             <td align='center'><a target='_blank' href='printphar.php?bill=".$row['bill_number']."'><input type='button' name='print' id='print' value='Print'/></a>
             </td>
            </tr>
            ";
            
            }
            ?>
            
        </table>
</form>

     <div id="pageNavPosition" style="padding-top: 20px" align="center">
</div>
<script type="text/javascript"><!--
var pager = new Pager('tablepaging', 1000);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
     
      <?php include 'footer.php'; ?>
     