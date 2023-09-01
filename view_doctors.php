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
			      	url:"deletedoctor.php",
			      	success:function(data)
			      	{
			      		if(data=="done")
			      		{
			      			alert("Procedure Deleted Successfully");
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
 <?php
$query=mysqli_query($con,"SELECT * FROM doctor_list ORDER BY doctor_name");

?>
<form name="users_list" method="post">
    <tr>
            <td colspan="5"><p id="panel">View All  Registered Doctors</p></td>
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
               
                <th>Doctor Name</th>
				 <th>Doctor Designation</th>
               <th>Consultation Fees</th>
			   <th>Action</th>
            </tr>
            <?php
            $inc=1;
            while($row=mysqli_fetch_array($query))
            {
               
            echo "
            <tr>
            <td align='center'>$inc</td>
            <td align='center'>".$row[doctor_name]."</td>
            <td align='center'>".$row[designation]."</td>
            <td align='center'>Rs. ".$row[doctor_fees]."</td>
			  <td align='center'><a href='edit_doctor.php?proid=$row[id]'><img src='images/edit.png' /></a>&nbsp;&nbsp;<a href='#' id='delete_$row[id]'><img src='images/cancel.png' /></a></td>
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
     