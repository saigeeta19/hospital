<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
 <?php include 'header.php'; ?>
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
<?php include 'sidebar.php'; ?>
<script>
    $(function() {
        
$("#view").click(function(){
    var fromdate=$("#from_date").val();
    var todate=$("#to_date").val();
    var entry=$("#entry").val();
    var ptype=$("#ptype").val();
   
                     $.ajax({
                        type:"post",
                        url:"getphartranreports1.php",
                        data:"fromdate="+fromdate +"&todate="+todate+"&entry="+entry+"&ptype="+ptype,
                        success:function(data){
                           $("#tablepaging").html(data);
                           $("#tableprint").html(data);
              }
              });
});
});
</script>
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
<script>
    $(function(){
    $("#from_date").datepicker({ gotoCurrent: true}).datepicker('setDate',"0");
    $("#from_date").datepicker("option", "dateFormat", "dd-mm-yy");
    
    $("#to_date").datepicker({ gotoCurrent: true}).datepicker('setDate',"0");
    $( "#to_date" ).datepicker("option", "dateFormat", "dd-mm-yy");
});


</script>
<form name="patient_register" method="post" >
     <tr>
            <td colspan="5"><p id="panel">Total Pharmacy Transactions</p></td>
            </tr>
        <table id="table11"  name="t1" border="2" width="100%" >
            <tr>
               <td id="headus">From</td>
               <td><input type="text" name="from_date" id="from_date" /></td>
               <td id="headus">To</td>
               <td><input type="text" name="to_date" id="to_date" /></td>
               <td id="headus">Type</td>
               <td><select name="ptype" id="ptype">
               	<option value="OPD">OPD</option>
                <option value="IPD">IPD</option>
                
               	</select>
               </td>
               <td id="headus">Entry By</td>
               <td><select name="entry" id="entry">
               	<option value="all">All</option>
                <option value="101">101</option>
                <option value="102">102</option>
                <option value="103">103</option>
                <option value="104">104</option>
                <option value="105">105</option>
                <option value="106">106</option>
                <option value="107">107</option>
                <option value="108">108</option>
                <option value="109">109</option>
                <option value="110">110</option>
                <option value="111">111</option>
				<option value="112">112</option>
               	</select>
               </td>
            </tr>
        
            <tr>
                <td colspan="8" align="center"><input type="button"  id="view" name="view" value="Get Details"/></td>
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
                <table id="tablepaging" class="yui" name="t1" border="4" width="100%">
        
        
    </table>
    </form>
   
    
    
 <?php include 'footer.php'; ?>
