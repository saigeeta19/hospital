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
<form action="execeditstatus.php" method="post">
	<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
	Status:<br>
	<select name="status" class="ed">
	<option value="0">Pending</option>
	<option value="1">Delivered</option>
	</select>
	<br>
	<input type="submit" value="Update" id="button1">
</form>