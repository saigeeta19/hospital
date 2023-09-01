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
                
$query=mysqli_query($con,"SELECT * FROM canteen_entry WHERE date LIKE '$date%' GROUP BY bill_number ORDER BY id DESC");
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
            <td colspan="5"><p id="panel">Today's Nutrition Dashboard</p></td>
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
                <th>Bill Number</th>
                <th>Nutrition</th>
                <th>Amount</th>
                <th>Entry By</th>
                <th>Action</th>
		
            </tr>
            <?php
            $inc=1;
            while($row=mysqli_fetch_array($query))
            {
            	$bill_number=$row['bill_number'];
				$canname="";
				//$sql2=mysqli_query("SELECT sum(investigation_fees) FROM investigation_entry WHERE  ")
				$sql=mysqli_query($con,"SELECT * FROM canteen_entry WHERE bill_number='".$bill_number."'");
				while($sql1=mysqli_fetch_array($sql)){
					$canname=$canname.$sql1['canteen']."<br/>";
				}
				$sql2=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE bill_number='".$bill_number."'");
				$sql3=mysql_fetch_array($sql2);
				$amt=$sql3['sum(amount)'];
               
                
                if($row[status]=="can")
                {
                	$h="";
                }
                else {
                    $h="<br/>".$row[status];
                }
               $query23=mysql_query("SELECT * FROM canteen_discounts WHERE bill_number='".$bill_number."'",$con);
        $row23=  mysqli_fetch_array($query23);
          $to=$amt-$row23['discount_amount'];
               
            echo "
            <tr>
            <td align='center'>$inc</td>
            <td align='center'>$row[bill_number]$h</td>
         
           
            <td align='center'>$canname</td>
            <td align='center'>Rs. $to</td>
            <td align='center'>$row[entry_person]</td>
           <td align='center'><a target='_blank' href='printcan.php?bill=".$row[bill_number]."'><input type='button' name='print' id='print' value='Print'/></a>
             </td>
             
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
     