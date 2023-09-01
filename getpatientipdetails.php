<?php
include 'connection.php';
$patient_ip_id=$_POST['patient_ip_id'];
$query=mysqli_query($con,"SELECT * FROM patient_diagnosis WHERE patient_ip_id='".$patient_ip_id."'");
$row=mysqli_fetch_array($query);
$query1=mysqli_query($con,"SELECT * FROM attenders WHERE patient_ip_id='".$patient_ip_id."'");
$row1=mysqli_fetch_array($query1);
$underdoc=$row['admit_under_doctor'];
$underar=explode(",",$underdoc);

 echo '
 <tr>
                <td>Select Date</td>
                <td>'.$row['admission_date'].'</td>
                <td>Patient Age</td>
                <td><input type="text" name="age" id="age" size="3" value="'.$row['age'].'" /> years</td>
            </tr>
			<tr>
                <td> Adhaar Number</td>
                <td><input type="text" name="adhaar_num" id="adhaar_num" value="'.$row['adhaar_num'].'" /></td>
                <td>Covid Report Number</td>
                <td><input type="text" name="covid_report_num" id="covid_report_num" value="'.$row['covid_report_num'].'" /></td>
            </tr>
			 <tr>
                <td>Select Mode</td>
                <td><select name="mode" required="required">
				    <option value="">Select</option>
					<option value="Cash"';
					 if($row['mode']=="Cash")
					 {
						 echo "selected";
					 }
					
					echo '>Cash</option>
					<option value="Credit"';
					 if($row['mode']=="Credit")
					 {
						 echo "selected";
					 }
					echo '>Credit</option>
					</td>
                <td>Credit Company</td>
                <td><select name="credit_company" id="credit_company" >
				    <option value="">Select</option>';
					$sql=mysqli_query($con,"SELECT * FROM credit_company_list");
					 while($sql1=mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$sql1['company_name']."'";
						if($sql1['company_name']==$row['credit_company'])
						{
							  echo "selected";
						}
						echo ">$sql1[company_name]</option>";
					}
					
					echo '</td>
            </tr>
            <tr>
				<td>Problem Diagnosed</td>
				<td><input type="text" name="problem" id="problem" required="required" value="'.$row['problem_diagnosed'].'" /> </td>
				<td>Under Doctor</td>
				<td><select name="doctor[]" multiple="multiple" required="required">
				    <option value="">Select</option>';
					
					$sql=mysqli_query($con,"SELECT * FROM doctor_list");
                    while($sql1=mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$sql1['doctor_name']."'";
                       
                        foreach($underar as $underar1)
						{
							
							if($underar1==$sql1['doctor_name'])
							{
							  echo 'selected="selected"';	
							}
						}
						
                       echo ">$sql1[doctor_name]</option>";
                    }
					
				echo '	
				</select></td>
				<!--<td>Free Tiffin Required</td>
				<td><select name="tiffin" id="tiffin">
				    <option value="">Select</option>
				    <option value="yes">Yes</option>
				    <option value="no">No</option>
				</select></td>-->
			</tr>
			<tr>
				<td>Referred By</td>
				<td><input type="text" name="referred" id="referred" value="'.$row['referred_by'].'" /></td>
				<td>Referred Contact</td>
				<td><input type="text" name="referred_num" id="referred_num" value="'.$row['referred_num'].'" /></td>
			</tr>
			<tr>
            <td colspan="4" id="table_head">Attender Details</td>
            </tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="attender_name" required="required" value="'.$row1['attender_name'].'" /></td>
				<td>Fathers Name</td>
				<td><input type="text" name="attender_father_name" value="'.$row1['attender_father'].'" /></td>
			</tr>
			<tr>
				<td>Relation with Patient</td>
				<td><input type="text" name="relation_patient" required="required" value="'.$row1['attender_patient_relation'].'" /></td>
				<td>Address</td>
				<td><textarea name="attendant_address">'.$row1['attender_address'].'</textarea></td>
			</tr>
			<tr>
				<td>Contact Number</td>
				<td><input type="text" name="attender_contact" value="'.$row1['attender_contact'].'" /></td>
				<td>Email-Id</td>
				<td><input type="text" name="attender_email" value="'.$row1['attender_email'].'" /></td>
			</tr>
			
 ';



?>
            
			
			

		
			