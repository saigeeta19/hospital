<?php
  include "connection.php";
 
 $patient_id=$_POST["patient_id"];
 $query=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
 $row=mysqli_fetch_array($query);
 
 ?>
<table id="table1"  name="t1" border="2" width="100%" >
          
            <tr>
            <td colspan="4" id="table_head" >Personal Details</td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type="radio" name="ntitle" id="Miss" value="Miss" <?php if($row['ntitle']=="Miss") { echo checked; }?> /> Miss <input type="radio" name="ntitle" id="Mr" value="Mr" <?php if($row['ntitle']=="Mr") { echo checked; }?> /> Mr <input type="radio" name="ntitle" id="Mrs" value="Mrs"  <?php if($row['ntitle']=="Mrs") { echo checked; }?>/> Mrs </td>
                <td>Name</td>
                <td><input type="text" name="fname" id="fname" value="<?php echo $row['name']; ?>" /></td>
                
            </tr>
            <tr>
                 <td>C/O Name</td>
                <td><input type="text" name="co_name" id="co_name" value="<?php echo $row['co_name']; ?>" /> </td>
                <td>Gender</td>
                <td><input type="radio" name="gender" id="MALE" value="MALE" <?php if($row['gender']=="MALE") { echo checked; }?> />Male<input type="radio" name="gender" id="FEMALE" value="FEMALE" <?php if($row['gender']=="FEMALE") { echo checked; }?> />Female<input type="radio" name="gender" id="OTHERS" value="OTHERS" <?php if($row['gender']=="OTHERS") { echo checked; }?>/>Others</td>
              
            </tr>
            <tr>
                  <td>Phone Number</td>
                <td><input type="text" name="phno" id="phno" value="<?php echo $row['phone_number']; ?>" /> </td>
                <td>Address</td>
                <td><textarea name="address" id="address" ><?php echo $row['address']; ?></textarea> </td>
                
            </tr>
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Update Patient Details" /></p></td>
			</tr>
	
	