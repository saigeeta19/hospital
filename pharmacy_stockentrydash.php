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
     $date=date("d-m-Y");
                
$query=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE quantity>0 ORDER BY id DESC");
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
            <td colspan="5"><p id="panel">Pharmacy Stocks Entry Dashboard</p></td>
            </tr>
    <tr>
                <td colspan="5">
            <p align="right">
        <label for="search">
            <strong>Search</strong>
        </label>
        <input type="text" id="search" align="right"/>&nbsp;
</p></td>
</tr>       
        <table id="tablepaging" class="yui" name="t1" border="1" width="100%" >
            
            
            <tr>
                <th>S.No.</th>
                 <th>Entry on</th>
                <th>Company</th>
                <th>Challan</th>
                <th>Barcode</th>
                <th>Batch Number</th>
                <th>Pharmacy</th>
                <th>Quantity</th>
                <th>Purchase Rate</th>
                <th>Sale Rate</th>
                <th>Expiry </th>
		
            </tr>
            <?php
            $inc=1;
            while($row=mysqli_fetch_array($query))
            {
                $com=$row['company_name'];
			    $sql67=mysqli_query($con,"SELECT * FROM company_list WHERE id='".$com."'");
			   $sql68=mysqli_fetch_array($sql67);
                
              
			   
            echo "
            <tr>
            <td align='center'>$inc</td>
                <td align='center'>$row[date_time]</td>
                <td align='center'>$sql68[company_name]</td>
                    <td align='center'>$row[challan_num]</td>
            <td align='center'>$row[barcode]$h</td>
            <td align='center'>$row[batch_number]</td>
            <td align='center'>$row[name]</a></td>
            <td align='center'>$row[quantity]</td>
            <td align='center'>$row[purchase_rate]</td>
            <td align='center'>$row[price]</td>
            <td align='center'>$row[expiry_date]</td>
            </tr>
            ";
            $inc++;
            
			}
            ?>
            
        </table>
</form>

     <div id="pageNavPosition" style="padding-top: 20px" align="center">
</div>
<script type="text/javascript"><!--
var pager = new Pager('tablepaging', 100);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
     
      <?php include 'footer.php'; ?>
     