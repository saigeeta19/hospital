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

<?php include 'sidebar.php';?>
<?php
$query=mysqli_query($con,"SELECT * FROM stock_list ORDER BY STR_TO_DATE(date,'%d-%m-%Y %H:%i:%s') DESC");
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

<form name="stock_list" method="post">
	<tr>
			<td colspan="5"><p id="panel">Stock Entry/Dispatch Details</p></td>
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
				<th>Item Name</th>
				<th>Item Quantity</th>
				<th>Place/Person</th>
				<th>Status</th>
			</tr>
			<?php
			while($row=mysqli_fetch_array($query))
			{
				$date=$row['date'];
				$date = date(" d-M-Y h:i a", strtotime($date));
            echo "
            <tr>
            <td align='center'>$date</td>
            <td align='center'>$row[name]</td>
            <td align='center'>$row[quantity]</td>
            <td align='center'>$row[entry_issuer]</td>
            <td align='center'>$row[status]</td>
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