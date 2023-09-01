<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php include 'header.php' ?>
<?php include 'convert_words.php'; ?>

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

<script>
$(document).ready(function(){
	$("#save").hide();
	$(".mes").hide();
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
                        url:"view_patient_status.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                             
                               if(data=="admitted")
                                {             
                                 $(".dis").show();
                                 $(".mes").hide();
                                }
                                 else if(data=="discharged")
                                 {
                                     $(".dis").hide();
                                     $(".mes").show();
                                 }
                        }
                     });
    
         	    
});
$( "#submit" ).click(function(){
	
	var patient_ip_id=$("#patient_ip_id").val();
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getfinalsettlementamount.php",
           	   	     	data:"patient_ip_id="+patient_ip_id,
           	   	     	success:function(data){
                              $("#patient_check").html(data);
           	   	     	}
           	   	     });
   
    $("#save").show();
         	    
});

$( "#mode" ).click(function(){
	
	var mode=$("#mode").val();
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getdepositfields.php",
           	   	     	data:"mode="+mode,
           	   	     	success:function(data){
                              $(".depofie").html(data);
           	   	     	}
           	   	     });
    
         	    
});

});
</script>
<?php
if($_POST['save'])
{
    $patient_ip_id=$_REQUEST['patient_ip_id'];
	$patient_id=$_REQUEST['patient_id'];
	$remainamount=$_REQUEST['remain'];
    $cauded=$_REQUEST['cauded'];
       $mode=$_REQUEST['mode'];
        $card_bank_name=$_REQUEST['card_bank_name'];
        $cheque_bank_name=$_REQUEST['cheque_bank_name'];
        $card_holder=$_REQUEST['card_holder'];
        $cheque_holder=$_REQUEST['cheque_holder'];
        $cheque_number=$_REQUEST['cheque_number'];
        
	$date=date("d-m-Y H:i:s");
	if($remainamount!="")
	{
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
       $sql67=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$patient_id."'");
        $sql68=mysqli_fetch_array($sql67);
        $patient_name=$sql68['name'];
        $inc=1;
        
       
        
          
$paysta="";
         if($remainamount>=0)
         {
             $paysta="RECEIPT";
             $status="FSREC";
         }
         else if($remainamount<0)
         {
             $paysta="REFUND";
             $status="FSREF";
         }
         $remainamount1=abs($remainamount);
          $amtwords=no_to_words($remainamount1);
          
   /*  $sql3=mysqli_query($con,"SELECT * FROM caution_deduction WHERE patient_ip_id='".$patient_ip_id."'");
     
          $sql4=mysqli_fetch_array($sql3);
 $caudedamt=$sql4['amount'];
 $cauremain=2500-$caudedamt;
 $caudedamtwords=no_to_words($cauremain);
 $reason=$sql4['reason'];
 
 if($cauremain>0)
 {
     $sql45=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,date,bill_number,amount,mode,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$bill_number."','".$cauremain."','".$mode."','CR','".$entry_person."')");
     
 }*/
   

 
               
             
$t="<html><table width='100%' style='font-size:14px;padding-top:130px;line-height:30px;line-width:15px;'>
    <tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> $paysta </th>
       </tr>
    </table>
    <table width='100%' style='font-size:14px ;padding-right:100px;line-height:30px;line-width:15px;'>
       
      
       <th style='text-align:right;padding-right:10px;padding-top:30px;'>Date:  </th>
       <td style='padding-top:30px;'>$date</td>
       <th style='text-align:right;padding-right:10px;padding-top:30px;'>Bill Number:</th>
       <td style='padding-top:30px;'>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;'>IP Number: </th>
       <td>$patient_ip_id</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Patient Name: </th>
       <td colspan='3'>$patient_name</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Amount: </th>
       <td colspan='3'>Rs. $remainamount1/-</td>
      </tr>";
     if($mode=="Card")
     {
         $t=$t."<tr>
       <th style='text-align:right;padding-right:10px;'>Details: </th>
       <td colspan='3'>$mode / $card_bank_name / $card_holder </td>
       </tr>";
     }
     else if($mode=="Cheque")
     {
         $t=$t."<tr>
       <th style='text-align:right;padding-right:10px;'>Details: </th>
       <td colspan='3'>$mode / $cheque_bank_name / $cheque_holder / $cheque_number </td>
       </tr>";
     }
     $t=$t." <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$amtwords rupees only.</td>
       
       </tr>
       </table>";
       
            
        
        $t=$t."<br/><table width='85%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $t=$t."</html>";
        
        $ts="<html><table width='100%' style='font-size:14px;padding-top:130px;line-height:30px;line-width:15px;'>
    <tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> Caution Refund </th>
       </tr>
    </table>
    <table width='100%' style='font-size:14px ;padding-right:100px;line-height:30px;line-width:15px;'>
       
      
       <th style='text-align:right;padding-right:10px;padding-top:30px;'>Date:  </th>
       <td style='padding-top:30px;'>$date</td>
       <th style='text-align:right;padding-right:10px;padding-top:30px;'>Bill Number:</th>
       <td style='padding-top:30px;'>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;'>IP Number: </th>
       <td>$patient_ip_id</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Patient Name: </th>
       <td colspan='3'>$patient_name</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Amount: </th>
       <td colspan='3'>Rs. $cauremain/-</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$caudedamtwords rupees only.</td>
       
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Deduction: </th>
       <td colspan='3' style='text-transform:uppercase;'>$cauded/- rupees ($reason) </td>
       
       </tr>
       </table>";
       
            
        
        $ts=$ts."<br/><table width='85%' style='font-size:14px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $ts=$ts."</html>";
        
        
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
        
        $sql601=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
         if($mode=="Card")
        {
              $sql=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,bill_number,date,amount,mode,bank_name,holder_name,status,entry_person) VALUES('".$patient_ip_id."','".$patient_id."','".$bill_number."','".$date."','".$remainamount."','".$mode."','".$card_bank_name."','".$card_holder."','".$status."','".$entry_person."')"); 
         }
         else if($mode=="Cheque")
         {
             $sql=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,bill_number,date,amount,mode,bank_name,holder_name,cheque_number,status,entry_person) VALUES('".$patient_ip_id."','".$patient_id."','".$bill_number."','".$date."','".$remainamount."','".$mode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','".$status."','".$entry_person."')");
         }
         else if($mode=="Cash")
         {
	    $sql=mysqli_query("I$con,NSERT INTO deposits(patient_ip_id,patient_id,bill_number,date,mode,amount,status,entry_person) VALUES('".$patient_ip_id."','".$patient_id."','".$bill_number."','".$date."','".$mode."','".$remainamount."','".$status."','".$entry_person."')");
         }
	}
     if($sql)
    {

     
       echo "<script>alert('Final Settlement successfull');printPage();printPage1();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
?>
<?php include 'sidebar.php' ?>
<form name="view_ip_bill" method="post" onsubmit="return confirm('Are you sure?');">
		<tr>
            <td colspan="4"><p id="panel">Patient Bill Final Settlement</p></td>
            </tr>
		<table id="table" name="t1" border="4" width="100%">
			
			<tr>
				<td>Enter IP number of patient</td>
          	    <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Patient UID / Name</td>
          	    <td><select name="patient_id" id="patient_id" required="required">
          	    	
          	    </select></td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="patient_check" border="2" width="100%" >
						
					</table>
				</td>
			</tr>
                        <tr>
                            <td colspan="2">Select Payment Mode </td>
                            <td colspan="2"><select name="mode" id="mode" required="required">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Cheque">Cheque</option>
                                    </select></td>
				
				
			</tr>
                </table>
             <table id="table" class="depofie" name="t1" border="4" width="100%">
                
            </table>
            <table id="table" name="t1" border="4" width="100%">
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" id="save" name="save" value="Save" /></p>
			</tr> 
			</table>
			<div class="dis">
			<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="button" id="submit" name="submit" value="View Bill" /></p></td>
			</tr>
		</table>
		</div>
		<div class="mes" style="text-align: center; padding-top:20px; color:#930000;">
			Please enter correct IP number.
		</div>
</form>
<?php include 'footer.php'; ?>


