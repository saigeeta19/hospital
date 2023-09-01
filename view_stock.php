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
<?php
$query=mysqli_query($con,"SELECT * FROM stock_names");
?>
<?php include 'sidebar.php' ?>

<form name="stock_list" method="post">
		<tr>
            <td colspan="4"><p id="panel">Current Stock List</p></td>
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
				<th id="table_head">Item Name</th>
				<th id="table_head">Availability</th>
			</tr>
			<?php
			while($row=mysqli_fetch_array($query))
			{
				$item_name=$row['name'];
				$query1=mysqli_query($con,"SELECT sum(quantity) FROM stock_list WHERE name='".$item_name."' && status='entry'");
 $result1=mysqli_fetch_array($query1);
 $stock=$result1['sum(quantity)'];
 
 $query2=mysqli_query($con,"SELECT sum(quantity) FROM stock_list WHERE name='".$item_name."' && status='dispatch'");
 if($query2)
 {
   $result2=mysqli_fetch_array($query2);
   $dispatch=$result2['sum(quantity)'];   
 }
else {
	$dispatch=0;
}
 
$availability=$stock-$dispatch;

            echo "
            <tr>
            <td align='center'>$item_name</td>
            <td align='center'>$availability</td>
            </tr>
            ";  
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

<?php include 'footer.php';?>