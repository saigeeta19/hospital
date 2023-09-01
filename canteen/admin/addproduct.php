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
<script type="text/javascript">
function validateForm()
{
var a=document.forms["addroom"]["type"].value;
if (a==null || a=="")
  {
  alert("Pls. Enter the Product Name");
  return false;
  }
var b=document.forms["addroom"]["rate"].value;
if (b==null || b=="")
  {
  alert("Pls. Enter the Product rate");
  return false;
  }
var d=document.forms["addroom"]["desc"].value;
if (d==null || d=="")
  {
  alert("Pls Enter the description");
  return false;
  }
/* var e=document.forms["addroom"]["image"].value;
if (e==null || e=="")
  {
  alert("Pls. browse an image");
  return false;
  }*/

}
</script>

<!--sa input that accept number only-->
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

<form action="addexec.php" method="post" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
<table class="tg" style="undefined;table-layout: fixed; width: 450px; height:400px">
<tr>
	<th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
	<th class="tg-yw4l">Add Product</th>
</tr>
<colgroup>
<col style="width: 92px">
<col style="width: 25px">
<col style="width: 171px">
</colgroup>
  <tr>
    <th class="tg-yw4l">Name</th>
    <th class="tg-yw4l">:</th>
    <th class="tg-yw4l"><input name="type" type="text" class="ed" /></th>
  </tr>
  <tr>
    <td class="tg-yw4l">Rate</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><input name="rate" type="text" id="rate" class="ed" onkeypress="return isNumberKey(event)" /></td>
  </tr>
  <tr>
    <td class="tg-yw4l">Description</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><textarea name="desc" type="text" class="ed" /></textarea>
  </tr>
  <tr>
    <td class="tg-yw4l">For</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><select name="for_p" class="ed">
    	<option value="admitpat">Admitted Patients</option>
    	<option value="canteen">Canteen</option>
    </select>
    </tr>
 <!-- <tr>
    <td class="tg-yw4l">Image</td>
    <td class="tg-yw4l">:</td>
    <td class="tg-yw4l"><input type="file" name="image" class="ed"></td>
  </tr> -->
  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"><input type="submit" name="Submit" value="save" id="button1" /></td>
  </tr>
</table>
 
</form>
