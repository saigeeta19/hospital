<?php
include('connect.php');
$id=$_GET['id'];
$result2 = mysql_query("SELECT * FROM je_products WHERE id='$id'");
while($row2 = mysql_fetch_array($result2))
	{
	$price=$row2['price'];
	$name=$row2['name'];
	//echo '<img src="img/products/'.$row2['img'].'" alt="Wall-E" title="Wall-E" /><br>';
	echo '<span style="color:#B80000; font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">'.$row2['name'].'</span><br>';
	//echo '<span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; text-align:left; line-height:17px;color:#000000;">'.$row2['description'].'</span>';
	}
?>
<script type="text/javascript" language="Javascript">
	var sum=0;
	price = document.frmOne.select1.value;
	document.frmOne.txtDisplay.value = price;
    function OnChange(value){
		
		price = document.frmOne.select1.value;
		quantity = document.frmOne.select2.value;
        sum = price * quantity;
		
		document.frmOne.txtDisplay.value = sum;
    }
</script>
<SCRIPT language=Javascript>
	<!--
	function isNumberKey(evt)
	{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
	}
	//-->
</SCRIPT>
<script type="text/javascript">
function validateForm()
{
var x=document.forms["frmOne"]["select2"].value;
if (x==0 || x=="")
  {
  alert("Order Quantity should be atleast 1");
  return false;
  }
/*var con = confirm("Are You Sure? you want to order this product?");
if (con ==false)
{
return false;
}*/
}
</script>
<form NAME = "frmOne" action="initiateorder.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
	<input type="hidden" name="transnum" value="<?php echo $_GET['trnasnum'] ?>" />
	<INPUT TYPE = "Text" name = "select1" size = "35" value ="<?php echo $price ?>" style="display:none;">
	<INPUT TYPE = "Text" name = "pname" size = "35" value ="<?php echo $name ?>" style="display:none;">
    <br>
    <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; text-align:left; line-height:17px;color:#000000;">Quantity : </span>
	<input type="text" name="select2" value="1" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" style="width:60px;" /> 
	
	 <span style="color:#B80000; font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">=</span> 
    <INPUT TYPE = "Text" name = "txtDisplay" size = "35" value ="" style="border:#999999 solid 1px; background-color:#FFF; width:100px; height:20px;" readonly>
	<br><br>	
	<input type="submit" value="Submit" style="padding:10px; border-radius:15px; background-color:green; border:none; color:#ffffff; font-weight:bold; border: 1px solid #000000"/>
</form>

