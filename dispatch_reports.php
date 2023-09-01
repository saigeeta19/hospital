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

<?php
$query=mysqli_query($con,"SELECT * FROM stock_names");
?>
<script>
$(function() {
	
$( "#item_name" ).change(function(){
	var item_name=$("#item_name").val();
	           $.ajax({
           	   	     	type:"post",
           	   	     	url:"getdispatchreport.php",
           	   	     	data:"item_name="+item_name,
           	   	     	success:function(data){
                        $("#tablepaging").html(data);          	   	     	
                       }
           	   	     });
             });
           	   	     
});
</script>

<?php include 'sidebar.php' ?>
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
<form name="dispatch_stock" method="post">
		<tr>
            <td colspan="4"><p id="panel">Dispatch Reports</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%" >
			
			
			<tr>
				<td>Select Stock Item</td>
          	    <td><select name="item_name" id="item_name">
          	    	<option value="">Select</option>
          	    <?php
          	    while($row=mysqli_fetch_array($query))
				{
					echo "<option value='".$row['name']."'>$row[name]</option>";
				}
          	    ?>	
          	    </select></td>
          	</tr>
        </table>
        
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
          	
         </table> 	
		
</form>
<style>
	#tablepaging tr td
	{
		text-align:center;
	}
</style>
<?php include 'footer.php';?>