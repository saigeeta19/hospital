<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>

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
<?php include 'header.php' ?>
<?php

?>
<script>

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
function thours($start,$end)
{
  $t1=strtotime($start);
  $t2=strtotime($end);
  $v = $t2 - $t1;
  $v = $v / ( 60 * 60 ); 
  return  floor($v);
}
if($_POST['discharge'])
{	
    $patient_ip_id=$_REQUEST['patient_ip_id'];
    $patient_id=$_REQUEST['patient_id'];
    $discharge_date=date("d-m-Y H:i:s");
    $thours=$_REQUEST['thou'];
    $query2=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
    $row2=mysqli_fetch_array($query2);
    $id=$row2['id'];
	$oadmission=$row2['admission_date'];
	 $query56=mysqli_query($con,"select * FROM patient_diagnosis where patient_ip_id='".$patient_ip_id."'");
		 $result56=mysqli_fetch_array($query56);
		  $under_doctor=$result56['admit_under_doctor'];
		  $co=explode(",",$under_doctor);
    $category=$row2['category'];
    $ward_name=$row2['ward_name'];
    $bed_room_name=$row2['bed_room_name'];
    $discharge_mode=$_REQUEST['discharge_mode'];
	
    $h=thours($oadmission,$discharge_date);
    $h=floor($h);
	 $query12= mysqli_query($con,"SELECT * FROM wards WHERE category='".$category."' && ward_name='".$ward_name."'");
     $row12=mysqli_fetch_array($query12);
     $rent_per=$row12['rent_per_unit']; 
	   //Hosekeeping Charge
     $housekeeping_charge=$row12['housekeeping_charge'];
     //Nursing Charge
     $nursing_charge=$row12['nursing_charge'];
     $nh=$h;
     $ni=$h/24;
     $nc=ceil($ni);
     $nursing_amount=$nc*$nursing_charge;
     $tnurse=$tnurse+$nursing_amount;
	  $remainder = $h % 12;
	 
      $quotient = ($h - $remainder) / 12;
      
	  $rent=$quotient*$rent_per/2+$rent_per/2;
	 $cons1=0;
	 foreach($co as $co1)
	{
		
    $query90=mysqli_query($con,"SELECT * FROM doctor_ipd_consultation WHERE category_name='".$category."' && ward_name='".$ward_name."' && doctor_name='".$co1."'");
	
	  $query91=mysqli_fetch_array($query90);
	   $conam=$query91['consultation_amount'];
	   $conam=$nc*$conam;
	  
       $cons1=$cons1+$conam;
	}
	
     
   
     $phours=$phours+$h;
      $trent=$trent+$rent;
    //Bill Details
    $sql67=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
        $sql68=mysqi_fetch_array($sql67);
        $patient_name=$sql68['name'];
    $registration="Rs. 200";
    $admission=$_REQUEST['admission'];
    $emergency=$_REQUEST['emergency'];
    $room_rent=$_REQUEST['room_rent'];
    $nursing_charge=$_REQUEST['nursing_charge'];
	 $housekeeping_charge=$_REQUEST['housekeeping_charge'];
	$cons=$_REQUEST['cons'];
    $investigation=$_REQUEST['investigation'];
    $discount=$_REQUEST['discount'];
    $procedure=$_REQUEST['procedure'];
    $equipment=$_REQUEST['equipment'];
    $otamount=$_REQUEST['ot_amount'];
    $otheramt=$_REQUEST['otheramt'];
    $consultation=$_REQUEST['consultation'];
    $total_bill=$_REQUEST['total_bill'];
    $total_deposit=$_REQUEST['total_deposit'];
	$consultation=$cons+$consultation;
    // For Bill number
       $bd=date("Y/m/");
       $sql56=mysqli_query($con,"SELECT * FROM billnumbers WHERE bill_format='".$bd."'");
       if(mysqli_num_rows($sql56)>0)
       {
           $sql57=mysqli_query("SELECT max(bill_number) FROM billnumbers WHERE bill_format='".$bd."'");
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
       <td>Cash (Caution Money Adjusted)</td>
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
		  if($housekeeping_charge!=0)
         {
             $t=$t. "<tr>
         <td>House Keeping Charges</td>
         <td>Rs. $housekeeping_charge</td>
         </tr>";
         }
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
         <td>Rs. $consultation</td>
         </tr>";
         
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
    
      $query=mysqli_query($con,"UPDATE patient_admission SET leaving_date='".$discharge_date."',status='discharged',total_hours='".$thours."',total_rent='".$trent."',total_nursing='".$tnurse."',total_cons='".$cons1."' WHERE id='".$id."'");
    $query1=mysqli_query($con,"UPDATE patient_diagnosis SET discharge_date='".$discharge_date."',status='discharged',discharge_mode='".$discharge_mode."',entry_person='".$entry_person."' WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'");
    $query3=mysqli_query($con,"UPDATE name_allotment_wards SET status='vacant' WHERE category='".$category."' && ward_name='".$ward_name."' && bed_room_name='".$bed_room_name."'");
    if($query && $query1 && $query2 && $query3)
    {

       echo "<script>alert('Discharge successfull'); </script>";
       
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
            <td colspan="4"><p id="panel">Discharge Patient on Promisory Note</p></td>
            </tr>   
        <table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Enter IP number of patient</td>
                <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
                <td>Patient UID / Name</td>
                <td><select name="patient_id" id="patient_id">
                    
                </select></td>
            </tr>
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
                    <option value="Expired">Expired</option>
                    <option value="Abscond">Abscond</option>
                     <option value="Released">Released</option>
                </select></td>
                <td colspan="2"><p id="button" align="center"><input type="submit" id="discharge" name="discharge" value="Discharge" /></p></td>        
            </tr>
            
            
        </table>
</form>
<?php include 'footer.php'; ?>

