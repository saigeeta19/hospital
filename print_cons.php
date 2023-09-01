 <?php include 'connection.php';
 $bill=$_GET['bill'];
 
 $query=mysqli_query($con,"SELECT * FROM opd_entry WHERE bill_number='".$bill."'");
     $row=mysqli_fetch_array($query);
    
     $patient_id=$row['patient_id'];
      $visit_num=$row['visit_num'];
      $doctor_fees=$row['doctor_fees'];
      $age=$row['age'];
	   $doctor=$row['doctor'];
      $date1=date("d-m-Y");
     $sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
    $sql1=mysqli_fetch_array($sql);
    $gender=$sql1['gender'];
    $patient_name=$sql1['name'];
	if($gender=="MALE")
    {
        $g="M";
    }
else if($gender=="FEMALE")
{
    $g="F";
}
    
	 $t="<html><table width='100%' style='font-size:14px;padding-top:130px;padding-left:120px;text-align:left;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Name: </th>
       <td>$patient_name</td>
       <th style='text-align:right;padding-right:10px;'>Age/Sex: </th>
       <td>$age/$g</td>
       <th style='text-align:right;padding-right:10px;'>S.No.:  </th>
       <td>$visit_num</td>
       </tr>
       <tr>
      
       <th style='text-align:right;padding-right:10px;'>Date:  </th>
       <td>$date1</td>
       <th style='text-align:right;padding-right:10px;'>UID:  </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;'>Amount:</th>
       <td>Rs. $doctor_fees</td>
       </tr>
       <tr>
        <th style='text-align:right;padding-right:10px;'>Under:</th>
        <td colspan='5'>$doctor</td>
       
       </tr>
       ";
        $t=$t."</table><br/>";
        $t=$t."</html>";
    
    
    
   
     ?>
<script>
       
function printPage()
{
var html = <?php echo json_encode($t); ?>;

 var printWin = window.open("","","left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0");
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>
      

     <?php
     echo "<script>printPage(); window.close();</script>";
     ?>
     