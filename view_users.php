<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
$logger=$_SESSION['logger'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<?php include 'sidebar.php' ?>
<?php
$query=mysqli_query($con,"SELECT * FROM users");
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
			      	url:"deleteuser.php",
			      	success:function(data)
			      	{
			      		if(data=="done")
			      		{
			      			alert("User Deleted Successfully");
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
 <form name="user_register" method="post" >
      <tr>
            <td colspan="7"><p id="panel">View All Users</p></td>
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
           
        <table id="tablepaging" class="yui" name="t1" border="4" width="100%">
           
                
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Front Office</th>
                <th>IPD</th>
                <th>Billing</th>
                <th>Admin</th>
                 <th>Action</th>
            </tr>
            <?php
            $inc=1;
              while($row=mysqli_fetch_array($query))
              {
                  $username=$row['username'];
                  $query1=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$username."'");
                  $row1=mysqli_fetch_array($query1);
                  
                  echo "
                  <tr>
                  <td align='center'>$inc</td>
                  <td align='center'>$row[name]</td>
                  <td align='center'>$row1[frontoffice]</td>
                  <td align='center'>$row1[ipd]</td>
                  <td align='center'>$row1[billing]</td>
                  <td align='center'>$row1[admin]</td>
				  <td align='center'><a href='#' id='delete_$row[username]'><img src='images/cancel.png' /></a></td>
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