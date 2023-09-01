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
<?php include 'header.php'; ?>
<script>
$(function() {
$( "#check_name" ).click(function(){
	var patient_id=$("#patient_id").val();
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpatientname.php",
           	   	     	data:"patient_id="+patient_id,
           	   	     	success:function(data){
                              $("#patient_name").html(data);
           	   	     	}
           	   	     });
});
$("input[name^='pro_list']").change(function(){
    
   
            
	if (this.checked) {
		var pro_name=$(this).closest("input[name^='pro_list']").val();
     	
     	
             $.ajax({
           	   	     	type:"post",
           	   	     	url:"getproamt.php",
           	   	     	data:"pro_name="+pro_name,
           	   	     	success:function(data){
           	   	     		
                            $('.medication tr:last').prev().prev().before(data);
           	   	     	}
           	   	     });
           	  
           	       
           	  
           	   
                  }
     else
     {
     	
     	var k=$(this).closest("input[name^='pro_list']").val();
     	
     	k=encodeURIComponent(k);
     	
     	
     	m="input[id='"+k+"']";
     	
     	$(m).parent().parent().remove();
     	//$(m).closest("tr").remove();
     	
     }
    

});
$("#geto").click(function(){
    
      var total=0; var disc=0;
            var dmode=$("#pdmode").val();
            var dv=$("#pdval").val();
	
	var checked = [];
	$("input[name='pro[]']").each(function ()
		{
		    checked.push($(this).val());
		    
		});
		
	var checkedamt = [];
	$("input[name='amt[]']").each(function ()
		{
		    checkedamt.push($(this).val());
		    
		});
		
		
		
		$.ajax({
           	   	     	type:"post",
           	   	     	url:"getprototamt.php",
           	   	     	data:"checked="+checked+"&checkedamt="+checkedamt,
           	   	     	success:function(data){
                          document.getElementById("totamt").value=data;
                           var bi=data;
                          
                          if(dmode=="Percentage")
                            {
                                disc=(bi*dv)/100;
                            }
                            else if(dmode=="Amount")
                            {
                                disc=dv;
                            }
                            var discamt=bi-disc;
                              document.getElementById("discount_val").value=disc;
                            document.getElementById("billtot").value=Math.round(discamt);
                           
           	   	     	}
           	   	   });
		
		
}); 
$("#reset").click(function(){
	$(".medication tr:not(:first-child):not(:last-child)").remove();
});



$( "#pmode" ).change(function(){
	
	var pmode=$("#pmode").val();
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getdepositfields.php",
           	   	     	data:"mode="+pmode,
           	   	     	success:function(data){
                              $(".depofie").html(data);
           	   	     	}
           	   	     });
    
         	    
});


});


</script>
<script src="js/script.js"></script>
<?php include 'sidebar.php' ?>
<form name="opd_entry" method="post" >
	<tr>
            <td colspan="4"><p id="panel">Dental Procedure Billing</p></td>
            </tr>	
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td>Enter UID of patient</td>
          	    <td><input type="text" name="patient_id" id="patient_id" required="required"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Name</td>
          	    <td><select name="patient_name" id="patient_name" required="required">
          	    	
          	    </select></td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="text" name="age" id="age" size="3" required="required"/>years</td>
				<td>Gender</td>
				<td><input type="radio" name="gender" id="male" value="Male" />Male<input type="radio" name="gender" id="female" value="Female" />Female</td>
			</tr>
                        <tr>
                                <td>Technician Name</td>
				<td><input type="text" name="technician" id="technician" required="required"/></td>
                                <td>Technician Amount</td>
                                <td><input type="text" name="technician_amount" id="technician_amount" size="3" required="required" value="0"/></td>
                        </tr>
                         <tr>
                            <td>Select Type </td>
                                <td><select name="pmode" id="pmode" required="required">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Cheque">Cheque</option>
                                    </select></td>
                                    <td>Payment</td>
                                   <td><select name="due_status" id="due_status" required="required">
                                        <option value="">Select</option>
                                        <option value="1">Paid</option>
                                        <option value="0">Due</option>
                                    </select>&nbsp;<input type="text" name="due_reason" placeholder="Reason" /></td>
                        </tr>
                         <tr>
                            <td>Select Discount </td>

                             <td><select name="pdmode" id="pdmode" required="required">
                                        <option value="">Select</option>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Amount">Amount</option>
                                        
                                    </select></td>
                                         <td>Enter Discount Value </td>
                            <td><input type="text" name="pdval" id="pdval" size="3" value="0" />(Enter only Value)</td>

                        </tr>
                        <tr>
                        	<td>Enter Discount Reason </td>
                            <td><input type="text" name="dis_reason" id="dis_reason"  placeholder="Reason" /></td>
                            <td></td>
                            <td></td>
                        </tr>
		</table>
             <table id="table" class="depofie" name="t1" border="4" width="100%">
                
            </table>
		<table id="table" class="medication" name="t1" border="4" width="100%">
			<tr width="100%">
				<td width="40%">Dental Procedure Name</th>
				<td width="20%">Amount</th>
				
			</tr>
			<tr>
				<td>Total <input type="button" name="geto" id="geto" value="Get Total" style="float: right; margin-right:50px;" /> </td>
				<td><input type="text" id="totamt" size="3" value="0" readonly="readonly"/></td>
			</tr>
                         <tr>
                        <td>Discount</td>
                        <td><input type="text" id="discount_val" name="discount_val" size="3" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Total Bill Amount</td>
                        <td> <input type="text" name="billtot" id="billtot" size="3" readonly="readonly" /></td>
                    </tr>
		</table>
		<table id="table" name="t1" border="4" width="100%">
			<tr>
			<td colspan="2"><p id="button" align="center"><input type="submit" name="submit" id="submit" value="Save" /><input type="reset" name="reset" id="reset" value="Clear" /></p></td>
            </tr>
             
			 
		</table>
		<ul id="tabs">
		    <li><a href="#procedure">Dental Procedures</a></li>
		</ul>
		<div id="procedure" class="tab-section">
			<?php
			$pro=mysqli_query($con,"SELECT * FROM dental_list ORDER BY dental_name");
			 echo "<table width='100%'><tr>"; 
			   $x = 0; 
			   while($pro1 = mysqli_fetch_assoc($pro)) 
			   { 
			       echo "<td><input type='checkbox' name='pro_list[]' id='pro_list[]' value='".$pro1[dental_name]."' />".$pro1['dental_name']."</td>"; 
			       $x++; 
			       if ($x % 3 == 0) { echo "<tr>"; } 
			   } 
		     echo "</tr></table>";  
			?>
			
		</div>
		
			
</form>

       
<?php
if($_POST['submit'])
{
	 $patient_id=$_REQUEST['patient_id'];
	$age=$_REQUEST['age'];
        $technician=$_REQUEST['technician'];
        $technician_amount=$_REQUEST['technician_amount'];
	$gender=$_REQUEST['gender'];
         $due_status=$_REQUEST['due_status'];
		 $due_reason=$_REQUEST['due_reason'];
	 $date=date("d-m-Y H:i:s");
         
         //payment type
        $pmode=$_REQUEST['pmode'];
        $card_bank_name=$_REQUEST['card_bank_name'];
        $cheque_bank_name=$_REQUEST['cheque_bank_name'];
        $card_holder=$_REQUEST['card_holder'];
        $cheque_holder=$_REQUEST['cheque_holder'];
        $cheque_number=$_REQUEST['cheque_number'];
        
         //discount
         $pdmode=$_REQUEST['pdmode'];
         $pdval=$_REQUEST['pdval'];
          $dis_reason=$_REQUEST['dis_reason'];
         $damt=$_REQUEST['discount_val'];
         $totamt=$_REQUEST['billtot'];
         
         
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
       
       $k=0;
	foreach($_REQUEST['pro'] as $proce)
	{
		 $p=str_replace('%20',' ',$proce);
		 $p=str_replace('%2F','/',$p); 
		 $amt=$_REQUEST['amt']['$k'];
                 
                 
                   if($pmode=="Card")
        {
                
          $query=mysqli_query($con,"INSERT INTO `procedure_dental_entry`(`bill_number`, `date`, `patient_id`,`age`,`gender`, `dental_name`, `dental_fees`,`mode`, `bank_name`, `holder_name`, `cheque_number`, `status`,due_status,due_reason,technician,technician_amount, `entry_person`) VALUES ('".$bill_number."','".$date."','".$patient_id."','".$age."','".$gender."','".$p."','".$amt."','".$pmode."','".$card_bank_name."','".$card_holder."','".$cheque_number."','pro','".$due_status."','".$due_reason."','".$technician."','".$technician_amount."','".$entry_person."')");
        }
        else if($pmode=="Cheque")
        {
            $query=mysqli_query($con,"INSERT INTO `procedure_dental_entry`(`bill_number`, `date`, `patient_id`,`age`,`gender`, `dental_name`, `dental_fees`,`mode`, `bank_name`, `holder_name`, `cheque_number`, `status`,due_status,due_reason,technician,technician_amount, `entry_person`) VALUES ('".$bill_number."','".$date."','".$patient_id."','".$age."','".$gender."','".$p."','".$amt."','".$pmode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','pro','".$due_status."','".$due_reason."','".$technician."','".$technician_amount."','".$entry_person."')");
           
            
        }
        else if($pmode=="Cash")
        {
            $query=mysqli_query($con,"INSERT INTO `procedure_dental_entry`(`bill_number`, `date`, `patient_id`,`age`,`gender`, `dental_name`, `dental_fees`, mode,`status`,due_status,due_reason,technician,technician_amount, `entry_person`) VALUES ('".$bill_number."','".$date."','".$patient_id."','".$age."','".$gender."','".$p."','".$amt."','".$pmode."','pro','".$due_status."','".$due_reason."','".$technician."','".$technician_amount."','".$entry_person."')");
            
	   
        }
		//$query=mysqli_query($con,"INSERT INTO `procedure_entry`(`bill_number`, `date`, `patient_id`,`age`,`gender`, `procedure`, `procedure_fees`, `status`, `entry_person`) VALUES ('".$bill_number."','".$date."','".$patient_id."','".$age."','".$gender."','".$p."','".$amt."','pro','".$entry_person."')");
		$k++;
	}
   $sql60=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
   $uid=$patient_id;
                $sql45=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql15=mysqli_fetch_array($sql45);
                $patient_name=$sql15['name'];
                
                  $query777=  mysqli_query($con,"INSERT INTO `procedures_dental_discounts`(`bill_number`, `discount_mode`, `discount_value`, `discount_amount`,discount_reason,date) VALUES ('".$bill_number."','".$pdmode."','".$pdval."','".$damt."','".$dis_reason."','".$date."')");

	
	 $date = date("d-M-Y", strtotime($date));
   $t="<html><table width='75%' style='font-size:14px ;padding-top:100px;padding-left:90px;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:center; font-size:18px;padding-left:100px; text-decoration:underline;' colspan='4'> OPD BILL </th>
       </tr>
       <tr>
       <th style='text-align:center; font-size:16px;padding-left:100px; text-decoration:underline;' colspan='4'> INVOICE </th>
       </tr>
       <th style='text-align:right;padding-right:10px;'>Date:  </th>
       <td>$date</td>
       <th style='text-align:right;padding-right:10px;'>Bill Number:</th>
       <td>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;'>Patient Name: </th>
       <td>$patient_name</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Age: </th>
       <td>$age</td>
       <th style='text-align:right;padding-right:10px;'>Gender: </th>
       <td>$gender</td>
       </tr>
       </table>
       <table width='70%' border='1' style='border-collapse:collapse;font-size:14px;margin-left:100px;padding-left:120px;text-align:center;line-height:20px;line-width:15px;'>
       <tr>
        <th width='5%'>S.No.</th>
        <th width='70%'>Description</th>
        <th  width='20%'>Amount</th>
	   </tr>
	    ";
	    
	      $k=0;$inc=1;$total=0;
	foreach($_REQUEST['pro'] as $proce)
	{
		 $p=str_replace('%20',' ',$proce);
		 $p=str_replace('%2F','/',$p); 
		 $amt=$_REQUEST['amt']['$k'];
		 $t=$t."<tr>
			<td>$inc</td>
			<td>$p</td>
			<td>Rs. $amt</td>
			</tr>";
		$total=$total+$amt;
		$k++;$inc++;
		
	}
	    
		$t=$t."<tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Total</td>
		<td>Rs. $total</td>
		</tr><tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Discount</td>
		<td>Rs. $damt</td>
		</tr><tr>
		<td colspan='2' style='text-align:right;padding-right:10px;'>Total</td>
		<td>Rs. $totamt</td>
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
   
    if($query)
    {
      
       echo "<script>alert('Procedure Entry successfull');printPage();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
 }
?>



<?php include 'footer.php'; ?>
