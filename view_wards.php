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
$right=$check1['admin'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
    <?php include 'header.php'; ?>
     <?php include 'sidebar.php'; ?>
     
     <?php
$query=mysqli_query($con,"SELECT * FROM wards ORDER BY category");
$inc=1;
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
  $(function(){
	$("[id^='delete_']").click(function(){
     	 var i=$(this).attr('id');
   	 	var arr=i.split("_");
   	 	var i=arr[1];
   	 	var r=confirm("Are you sure?");
   	 	if(r==true)
   	 	{
   	 	 $.ajax({
			      	type:"POST",
			      	data:"id="+i,
			      	url:"deletewards.php",
			      	success:function(data)
			      	{
			      		if(data=="done")
			      		{
			      			alert("Ward Deleted Successfully");
			      			location.reload();
			      		}
			      	
			      	}
			      });
			     }
			     else
			     {
			     	return false;
			     }
     });
});    
</script>

<form name="users_list" method="post">
    <tr>
            <td colspan="5"><p id="panel">View All Wards with Tariff & Denomination </p></td>
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
                <th>S.No.</th>
                 <th>Category</th>
                 <th>Ward Name</th>
                 
                 <th>Charge/day</th>
                 <th>Nursing Charge</th>
				  <th>House Keeping Charge</th>
                 <th>Total Beds/Rooms</th>
                 <th>Denomination</th>
                 <th>Action</th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($query))
            {
               $category=$row['category'];
               $ward=$row['ward_name'];
             
               $sql=mysqli_query($con,"SELECT max(id),min(id) FROM name_allotment_wards WHERE category='".$category."' && ward_name='".$ward."'");
               $sql1=mysqli_fetch_array($sql);
               $minid=$sql1['min(id)'];
               $maxid=$sql1['max(id)'];
               $sql4=mysqli_query($con,"SELECT * FROM name_allotment_wards WHERE id='".$minid."'");
               $sql5=mysqli_fetch_array($sql4);
               $min=$sql5['bed_room_name'];
               $sql6=mysqli_query($con,"SELECT * FROM name_allotment_wards WHERE id='".$maxid."'");
               $sql7=mysqli_fetch_array($sql6);
               $max=$sql7['bed_room_name'];
            echo "
            <tr>
            <td align='center'>$inc</td>
            <td align='center'>$category</td>
            <td align='center'>$ward</td>
            <td align='center'>Rs. $row[rent_per_unit]</td>
            <td align='center'>Rs. $row[nursing_charge]</td>
			<td align='center'>Rs. $row[housekeeping_charge]</td>
            <td align='center'>$row[number_beds_rooms]</td>
            <td align='center'>".$min." - ".$max."</td>
            <td align='center'><a href='edit_wards.php?wardid=$row[id]'><img src='images/edit.png' /></a>&nbsp;&nbsp;<a href='#' id='delete_$row[id]'><img src='images/cancel.png' /></a></td>
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
var pager = new Pager('tablepaging', 20);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
     
      <?php include 'footer.php'; ?>
     