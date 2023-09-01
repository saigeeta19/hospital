<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php';?>

<?php
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$right=$check1['billing'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>
<?php

?>
<script>
$(document).ready(function(){
    $("#dis").hide();
    
    
});
    $(function() {  
        
$( "#check_name" ).click(function(){
    var patient_ip_id=$("#patient_ip_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getuid.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#patient_id").html(data);
                        }
                     });
                  
                     $.ajax({
                        type:"post",
                        url:"getippatdetail.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $(".tabipd").html(data);
                        }
                     });
});
$( "#submit" ).click(function(){
    var patient_ip_id=$("#patient_ip_id").val();
    var status="";
    
                    $.ajax({
                        type:"post",
                        url:"view_patient_status.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                               status=data;
                        }
                     });
    
                     $.ajax({
                        type:"post",
                        url:"getiptotalbill.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#patient_check").html(data);
                              var remain=$("#remain").val();
                               if(remain==0 && status=="admitted")
                                {             
                                 $("#dis").show();
                                }
                                 else if(remain==0 && status=="discharged")
                                 {
                                     $("#dis").hide();
                                 }
                        }
                     });
                     
                     $.ajax({
                        type:"post",
                        url:"view_breakup.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#bill_breakup").html(data);
                             
                        }
                     });
});
});
</script>
<?php
if($_POST['discharge'])
{
    $patient_ip_id=$_REQUEST['patient_ip_id'];
    $patient_id=$_REQUEST['patient_id'];
    $discharge_date=date("d-m-Y H:i:s");
    $thours=$_REQUEST['thou'];
    $query2=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
    $row2=mysqli_fetch_array($query2);
    $id=$row2['id'];
    $category=$row2['category'];
    $ward_name=$row2['ward_name'];
    $bed_room_name=$row2['bed_room_name'];
    $discharge_mode=$_REQUEST['discharge_mode'];
	
    
    //Bill Details
    $sql67=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
        $sql68=mysqli_fetch_array($sql67);
        $patient_name=$sql68['name'];
    $registration="Rs. 200";
    $admission=$_REQUEST['admission'];
    $emergency=$_REQUEST['emergency'];
    $room_rent=$_REQUEST['room_rent'];
    $nursing_charge=$_REQUEST['nursing_charge'];
	$housekeeping_charge=$_REQUEST['housekeeping_charge'];
    $investigation=$_REQUEST['investigation'];
    $discount=$_REQUEST['discount'];
    $procedure=$_REQUEST['procedure'];
    $equipment=$_REQUEST['equipment'];
    $otamount=$_REQUEST['ot_amount'];
    $otheramt=$_REQUEST['otheramt'];
    $consultation=$_REQUEST['consultation'];
    $cons=$_REQUEST['cons'];
     $nutrition=$_REQUEST['nutrition'];
    $total_bill=$_REQUEST['total_bill'];
    $total_deposit=$_REQUEST['total_deposit'];
	$const=$cons+$consultation;
    // For Bill number
       $bd=date("Y/m/");
       $sql56=mysqli_query($con,"SELECT * FROM billnumbers WHERE bill_format='".$bd."'");
       if(mysqli_num_rows($sql56)>0)
       {
           $sql57=mysqli_query($con,"SELECT max(bill_number) FROM billnumbers WHERE bill_format='".$bd."'");
           $sql58=mysqli_fetch_array($sql57);
           $mbill=$sql58['max(bill_number)'];
           $bn=$mbill+1;
           $bill_number=$bd.$bn;
       }
       else {
           $bn=1;
           $bill_number=$bd.$bn;
       }
       //Bill number ends here
    $t="<html><table width='100%' style='font-size:14px ;padding-top:170px;padding-left:20px;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:center; font-size:18px; text-decoration:underline;padding-right:20px;' colspan='4'> IN-PATIENT BILL </th>
       </tr>
        <tr>
       <th style='text-align:left;padding-left:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:left;padding-left:10px;'>Patient Name: </th>
       <td><b>$patient_name</b></td>
       </tr>
       <th style='text-align:left;padding-left:10px;'>IP Number:  </th>
       <td>$patient_ip_id</td>
       <th style='text-align:left;padding-left:10px;'>Bill Number:</th>
       <td>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:left;padding-left:10px;'>Date of Admission: </th>
       <td>$admission</td>
       <th style='text-align:left;padding-left:10px;'>Date of Discharge: </th>
       <td>$discharge_date</td>
       </tr>
       <tr>
       <th style='text-align:left;padding-left:10px;'>Mode of Discharge: </th>
       <td>$discharge_mode</td>
       <th style='text-align:left;padding-left:10px;'>Payment Type: </th>
       <td>Cash</td>
       </tr>
       </table>
       <table width='100%' border='1' style='border-collapse:collapse;font-size:14px;margin-top:50px;padding-left:30px;text-align:center;line-height:20px;line-width:15px;'>
       <tr>
        <th width='80%'>Description</th>
        <th  width='20%'>Amount</th>
       </tr>
       <tr>
         <td>Registration Charges</td>
         <td>$registration</td>
         </tr>
		 
         ";
         if($emergency!=0)
         {
             $t=$t."<tr>
         <td>Emergency Charges</td>
         <td>Rs. $emergency</td>
         </tr>";
         }
		  $t=$t. "<tr>
         <td>House Keeping Charges</td>
         <td>Rs. $housekeeping_charge</td>
         </tr>";
         $t=$t. "<tr>
         <td>Room Rent</td>
         <td>Rs. $room_rent</td>
         </tr>";
         $t=$t. "<tr>
         <td>Nursing Charges</td>
         <td>Rs. $nursing_charge</td>
         </tr>";
         if($investigation!=0)
         {
             $t=$t. "<tr>
         <td>Investigation Charges</td>
         <td>Rs. $investigation</td>
         </tr>";
         }
         if($procedure!=0)
         {
             $t=$t. "<tr>
         <td>Procedure Charges</td>
         <td>Rs. $procedure</td>
         </tr>";
         }
         if($equipment!=0)
         {
             $t=$t. "<tr>
         <td>Medical Equipment Charges</td>
         <td>Rs. $equipment</td>
         </tr>";
         }       
         
             $t=$t. "<tr>
         <td>Consultation Charges</td>
         <td>Rs. $const</td>
         </tr>";
         
          if($nutrition!=0)
         {
             $t=$t. "<tr>
         <td>Nutrition Charges</td>
         <td>Rs. $nutrition</td>
         </tr>";
         }     
         if($otheramt!=0)
         {
             $t=$t. "<tr>
         <td>Other Charges</td>
         <td>Rs. $otheramt</td>
         </tr>";
         }     
         if($otamount!=0)
         {
             $t=$t. "<tr>
         <td>OT Charges</td>
         <td>Rs. $otamount</td>
         </tr>";
         }     
             $t=$t. "<tr>
         <td>Total Bill</td>
         <td><b>Rs. $total_bill</b></td>
         </tr>";
         
          $sql66=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='D'");
         
         $sql67=mysqli_fetch_array($sql66);
         if($sql67['sum(amount)']==NULL)
         {
            $dep=0;
         }
         else 
         {
             $dep=$sql67['sum(amount)'];
         }
         
             $t=$t. "<tr>
         <td>Total Deposits</td>
         <td>Rs. $dep</td>
         </tr>";
         
         $sql56=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE patient_ip_id='".$patient_ip_id."' && status='FSREC'");
         
         $sql57=mysqli_fetch_array($sql56);
         if($sql57['sum(amount)']==NULL)
         {
            $totalrec=0;
         }
         else 
         {
             $totalrec=$sql57['sum(amount)'];
         }
          $refunds=$_REQUEST['refunds'];
           $refunds=abs($refunds);      
         
         
         if($discount!=0)
         {
             $t=$t. "<tr>
         <td>Total Discounts</td>
         <td>Rs. $discount</td>
         </tr>";
         }
         if($refunds!=0)
         {
            $t=$t. "<tr>
         <td>Final Settlement (Refund)</td>
         <td>Rs. $refunds</td>
         </tr>"; 
         $netb=$total_bill-($total_deposit+$discount)+$refunds;
         }
         else if($totalrec!=0) {
             $t=$t. "<tr>
         <td>Final Settlement (Receipt)</td>
         <td>Rs. $totalrec</td>
         </tr>"; 
         $netb=$total_bill-($total_deposit+$discount);
         }
         
          $t=$t. "<tr>
         <td>Net Balance</td>
         <td>Rs. $netb</td>
         </tr>";
        
        $t=$t."</table><br/><table width='75%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
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
    //Bill Details End Here
 /* echo "UPDATE patient_admission SET leaving_date='".$discharge_date."',status='discharged',total_hours='".$thours."' WHERE id='".$id."'";
  echo "UPDATE patient_diagnosis SET discharge_date='".$discharge_date."',status='discharged',discharge_mode='".$discharge_mode."', bill_number='".$bill_number."', entry_person='".$entry_person."' WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'";
echo "UPDATE name_allotment_wards SET status='vacant' WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_room_name."'";
  exit;*/
    $query=mysqli_query($con,"UPDATE patient_admission SET leaving_date='".$discharge_date."',status='discharged',total_hours='".$thours."' WHERE id='".$id."'");
    $query1=mysqli_query($con,"UPDATE patient_diagnosis SET discharge_date='".$discharge_date."',status='discharged',discharge_mode='".$discharge_mode."', bill_number='".$bill_number."', entry_person='".$entry_person."' WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
    $query3=mysqli_query($con,"UPDATE name_allotment_wards SET status='vacant' WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_room_name."'");
    if($query && $query1 && $query2 && $query3)
    {
      
       echo "<script>alert('Discharge successfull'); printPage();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
?>
<?php include 'sidebar.php' ?>
<script src="js/script.js"></script>
<form name="view_ip_bill" method="post" onsubmit="return confirm('Are you sure?');">
    <tr>
            <td colspan="4"><p id="panel">View Patient Bill</p></td>
            </tr>   
        <table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Enter IP number of patient</td>
                <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Patient UID / Name</td>
                <td><select name="patient_id" id="patient_id">
                    
                </select></td>
            </tr>
        </table>
            <table id="table" name="t1" class="tabipd" border="4" width="100%">
                
            </table>
             <table id="table" name="t1" border="4" width="100%">
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="button" id="submit" name="submit" value="View Bill" /></p></td>
                
            </tr>
        </table>
            <ul id="tabs">
            <li><a href="#overview">Bill Overview</a></li>
            <li><a href="#breakup">Bill Breakup</a></li>
        </ul>
        <div id="overview" class="tab-section">
                    <table id="patient_check" border="1" width="100%" >
                        
                    </table>
        </div>
        <div id="breakup" class="tab-section">
                    <table id="bill_breakup" border="2" width="100%" >
                        
                    </table>
        </div>
        <table id="table" name="t1" border="4" width="100%">        
            <tr id="dis">
                <td>Discharge Mode</td>
                <td><select name="discharge_mode" id="discharge_mode">
                    <option value="">Select</option>
                    <option value="Normal">Normal</option>
                    <option value="LAMA">LAMA</option>
                    <option value="DAMA">DAMA</option>
                    <option value="DOR">DOR</option>
                    <option value="Referred">Referred</option>
                    <option value="Expired">Expired</option>

	 <option value="Abscond">Abscond</option>                </select></td>
                <td colspan="2"><p id="button" align="center"><input type="submit" id="discharge" name="discharge" value="Discharge" /></p></td>        
            </tr>
            
            
        </table>
</form>
<?php include 'footer.php'; ?>

