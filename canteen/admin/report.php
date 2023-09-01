<style type="text/css">
<!--
.ed{
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
margin-bottom: 4px;
}
#button1{
text-align:center;
font-family:Arial, Helvetica, sans-serif;
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
background-color:#00CCFF;
height: 34px;
}
-->
</style>
<?php
	error_reporting(0);
	require_once('../auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard | Modern Admin</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />  
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<script src="argiepolicarpio.js" type="text/javascript" charset="utf-8"></script>
<script src="js/application.js" type="text/javascript" charset="utf-8"></script>	
<!--sa poip up-->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox({
	loadingImage : 'src/loading.gif',
	closeImage   : 'src/closelabel.png'
  })
})
</script>
<script type="text/javascript">
function validateForm()
{
var a=document.forms["report"]["fdate"].value;
if (a==null || a=="")
  {
  alert("Pls. Enter the From date");
  return false;
  }
var b=document.forms["report"]["tdate"].value;
if (b==null || b=="")
  {
  alert("Pls. Enter the To date");
  return false;
  }
}
</script>
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->      
      <div style="position:relative;">
  	<!--LOGO-->
	<div class="grid_8" id="logo">Admin Panel</div>
    <div class="grid_8">
<!-- USER TOOLS START -->
      <div id="user_tools"><span><a href="logout.php">Logout</a></span></div>
    </div>
<!-- USER TOOLS END -->    
<div class="grid_16" id="header">
<!-- MENU START -->
<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first" id="one"><a href="index.php" class="main"><span class="outer"><span class="inner dashboard">Orders</span></span></a></li>
		<!--<li class="item middle" id="four"><a href="emp.php" class="main"><span class="outer"><span class="inner media_library">Employees</span></span></a></li>  -->
		<li class="item middle" id="four"><a href="products.php" class="main"><span class="outer"><span class="inner settings">Products</span></span></a></li>   
		<li class="item last" id="eight"><a href="report.php" class="main current"><span class="outer"><span class="inner reports">Report</span></span></a></li>	
    </ul>
</div>
<!-- MENU END -->
</div>


<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Report</h1>
    </div>
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">
    
	<!--  SECOND SORTABLE COLUMN END -->
    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
		<div class="portlet">
			<div class="portlet-header fixed"><img src="images/icons/user.gif" width="16" height="16" alt="Latest Registered Users" /> 
			<form name="report" id="report" method="post" onsubmit="return validateForm()">
			<table>
			<tr>
				<td width="200px"><label>From date</label> <input type="text" class="ed" name="fdate" value="" id="fdate" /></td>						
				<td width="200px"><label>To date</label> <input type="text" class="ed" name="tdate" value="" id="tdate" /></td>				
				<td width="200px"><label>&nbsp;</label><input type="submit" name="Submit" value="Run Report"  id="button1" /></td>
			</tr>
			</table>			
			</form>
			</div>
			<!--<div align="right"><a href="javascript:Clickheretoprint()">Print</a></div>-->
			<div class="portlet-content nopadding">
			<?php

			if (!isset($_POST['submit'])) {
				
				$from =  $_POST['fdate'];
				$to =  date("Y-m-d", strtotime($_POST['tdate']));
				
			?>
			<form action="" method="post">	
			<div id="print_content">		
			<table cellpadding="1" cellspacing="1" id="resultTable">
				<thead>
					<tr>
						<th  style="border-left: 1px solid #C1DAD7"> Order Number </th>
						<th> Date </th>
						<th> Product </th>
						<th> Quantity </th>						
						<th> Total </th>
						<th> Note </th>
						<!--<th> Action </th>-->
					</tr>
				</thead>
				<tbody>
				<?php
					include('../store/connect.php');
					//echo "SELECT * FROM je_orders  WHERE date BETWEEN '".$from."' AND '".$to." 23:59:59'";die;
					$result = mysql_query("SELECT * FROM je_orders  WHERE date BETWEEN '".$from."' AND '".$to." 23:59:59'");
					while($row = mysql_fetch_array($result))
						{
							echo '<tr class="record" id="'.$row['confirmation'].'">';
							echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['confirmation'].'</td>';
							echo '<td><div align="left">'.$row['date'].'</div></td>';
							echo '<td><div align="left">'.$row['product'].'</div></td>';
							echo '<td><div align="left">'.$row['qty'].'</div></td>';
							echo '<td><div align="left">'.$row['total'].'</div></td>';
							echo '<td><div align="left">'.$row['note'].'</div></td>';
							//echo '<td><div align="center"><a rel="facebox" href="vieworders.php?id='.$row['confirmation'].'" title="Click To View Orders">View Orders</a> | <a rel="facebox" href="viewreport.php?id='.$row['confirmation'].'" title="Click To View Orders">Print</a> | <a rel="facebox" href="editstatus.php?id='.$row['reservation_id'].'">edit</a> | <a href="#" id="'.$row['reservation_id'].'" class="delbutton" title="Click To Delete">delete</a></div></td>';
							echo '</tr>';
						}
					?> 
				</tbody>
			</table>
			</div>
			</form>
			<?php
					}
			?>
			</div>
		</div>
<!--  END #PORTLETS -->  
   </div>
    <div class="clear"> </div>
<!-- END CONTENT-->    
  </div>
<div class="clear"> </div>

</div>
</div>
<!-- WRAPPER END -->

<script src="js/jquery.js"></script>
  <script type="text/javascript">
$(function() {


$(".delbutton").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
 if(confirm("Sure you want to delete this update? There is NO undo!"))
		  {

 $.ajax({
   type: "GET",
   url: "deleteres.php",
   data: info,
   success: function(){
   
   }
 });
         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>Order Report</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="width: 900px; font-size:12px; font-family:arial;">'); 
   docprint.document.write('<div>'); 
   docprint.document.write(content_vlue); 
	docprint.document.write('</div>');    
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
  $( function() {
    $( "#fdate" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '1950:2016',
	  dateFormat: 'yy-mm-dd',
    });
  } );
  </script>
  <script>
  $( function() {
    $( "#tdate" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '1950:2016',
	  dateFormat: 'yy-mm-dd',
    });
  } );
  </script>
</body>
</html>