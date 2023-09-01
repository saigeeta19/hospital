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
	include('../store/connect.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM je_products where id='$id'");
		while($row = mysql_fetch_array($result))
			{
				$type=$row['name'];
				$rate=$row['price'];
				$mode=$row['mode'];
				$description=$row['description'];
				//$image=$row['img'];
			}
?>
<form action="execeditproduct.php" method="post" enctype="multipart/form-data">
	<table class="tg" style="undefined;table-layout: fixed; width: 450px; height:400px">
<tr>
	<th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
	<th class="tg-yw4l">Edit Product</th>
</tr>
<colgroup>
<col style="width: 92px">
<col style="width: 25px">
<col style="width: 171px">
</colgroup>
<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
  <tr>
    <th class="tg-yw4l">Name</th>
    <th class="tg-yw4l">:</th>
    <th class="tg-yw4l"><input type="text" name="type" value="<?php echo $type ?>" class="ed"></th>
  </tr>
  <tr>
    <td class="tg-yw4l">Rate</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><input type="text" name="rate" value="<?php echo $rate ?>" class="ed"></td>
  </tr>
  <tr>
    <td class="tg-yw4l">Description</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><textarea name="description" class="ed"><?php echo $description ?></textarea></textarea>
  </tr>  
  <tr>
    <td class="tg-yw4l">For</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><select name="for_p" class="ed">
    	<option value="<?php echo $mode; ?>"><?php echo $mode; ?></option>
    	<option value="admitpat">Admitted Patients</option>
    	<option value="canteen">Canteen</option>
    </select>
    </tr>
 <!-- <tr>
    <td class="tg-yw4l">Image</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"> <img src="../store/img/products/<?php echo $image ?>" width="100px" height="100px"><br><br>
	<div><input type="file" name="image" class="ed"></div>
	</td>	
  </tr>-->
  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"><input type="submit" value="Update" id="button1"></td>
  </tr>
</table>	
</form>