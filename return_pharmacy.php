<?php session_start(); ?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
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
<?php include 'header.php'; ?>
<?php include 'sidebar.php' ?>
<script>
$(function() {
	var checked=[];
	
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

      
$("#chkall").click(function(){
    var batch=document.opd_entry.barcode.value;
     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getmed.php",
           	   	     	data:"batch="+batch,
           	   	     	success:function(data){
                                    $('#medi').html(data);
                                 }
                                }); 
    
    
});	

 
$( "#barcode_chk" ).click(function(){
	//var barcode=$("#barcode").val();
        var barcode=document.opd_entry.medi.value;
      
                              $.ajax({
           	   	     	type:"post",
           	   	     	url:"getmedetails.php",
           	   	     	data:"barcode="+barcode,
           	   	     	success:function(data){
                               
                                    if(data!="")
                                    {
                                         alert(data);
                                    }
                                    else
                                    {
                                       $.ajax({
           	   	     	type:"post",
           	   	     	url:"getmedicinenamebybatch.php",
           	   	     	data:"barcode="+barcode,
           	   	     	success:function(data){
           	   	     		if(data=="")
           	   	     		{
           	   	     		  
           	   	     		}
           	   	     		else
           	   	     		{
           	   	     		  checked.push(barcode);
           	   	     		  $('.medication tr:last').before(data);
                             }
           	   	     	}
           	   	     }); 
                                    }
                              
           	   	     	}
           	   	     });
	
           	   	  
});
$("#reset").click(function(){
	$(".medication tr:not(:first-child):not(:last-child)").remove();
});

        $('#delete').click(function(){
        	
						$("input[name='ch[]']:checked").each(function (){
							var ar=$(this).val();
							var index = checked.indexOf(ar);

						    if (index > -1) {
						       checked.splice(index, 1);
						    }
						   $(this).parent().parent().remove();
						});
						
           
        });
        
         $("#gtot").click(function(){
            var total=0; 
               
            $("input[name='bh[]']").each(function (){
                  
                  var ba=$(this).val();
                  
                  var qt= $(':input:eq(' + ($(':input').index(this) + 1) + ')').val();
                  var that=$(':input:eq(' + ($(':input').index(this) + 3) + ')');
                  $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpharmaratebatchid.php",
           	   	     	data:"barcode="+ba+"&quantity="+qt,
           	   	     	success:function(data){
                                    
                                   
                             
                                //  $(':input:eq(' + ($(':input').index(this) + 2) + ')').val("neha");
                                 // $(':input:eq(' + ($(':input').index(this) + 2) + ')').val(data);
                               //document.getElementById("totamt").value=data;
                               total=parseFloat(total)+parseFloat(data);
                                $(that).val(data);
                            var bi=total;
                            
                            document.getElementById("billtot").value=Math.round(bi);
           	   	     	}
                                 
           	   	   });
                  
            });
        
	
	
		
		/*$.ajax({
           	   	     	type:"post",
           	   	     	url:"getprototamt.php",
           	   	     	data:"checked="+checked+"&checkedamt="+checkedamt,
           	   	     	success:function(data){
                          document.getElementById("totamt").value=data;
                           
           	   	     	}
           	   	   });*/
	}); 
      
      

});
</script>
<script src="js/script.js"></script>

<form name="opd_entry" method="post" >
	<tr>
            <td colspan="4"><p id="panel">Pharmacy Return</p></td>
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
				<td>Enter Your Id</td>
				<td><select name="pid" id="pid" required="required">
               
                <option value="<?php echo $logger; ?>"><?php echo $logger; ?></option>
               
                
               	</select></td>
				<td>Select Type</td>
                                <td><select name="btype" id="btype" required="required" >
                                                <option value="">Select</option>
                                                <option value="OPD">OPD</option>
                                                <option value="IPD">IPD</option>
                                    </select></td>
			</tr>
		</table>
		<table id="table" class="medication" name="t1" border="4" width="100%">
			<tr width="100%">
				<th width="30%">Pharmacy Name</th>
				<th width="10%">Availability</th>
				<th width="10%">Quantity to Add</th>
				<th width="10%">Rate</th>
                                <th width="10%">Amount</th>
				<th>Action</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<table id="table" name="t1" border="4" width="100%">
                    <tr>
                        <td>Total Amount to Return</td>
                        <td>Rs. <input type="text" id="billtot" size="3" /></td>
                    </tr>
			<tr>
			<td colspan="2"><p id="button" align="center"><input type="button" name="gtot" id="gtot" value="Get Prices" /><input type="button" name="delete" id="delete" value="Delete Checked Rows" /><input type="submit" name="submit" id="submit" value="Save" /><input type="reset" name="reset" id="reset" value="Clear" /></p></td>
            </tr>
             
			 
		</table>
		<ul id="tabs">
		    <li><a href="#investigation">Medicines</a></li>
		</ul>
            <script type="text/javascript" language="javascript">
    var pausecontent = new Array();
    </script>
            <?php
             $sql54=  mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE availability>0");
             while($sql55=  mysqli_fetch_array($sql54))
             {
                 $bar=$sql55['barcode'];
                 $sql56=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$bar."'");
                 $sql57=  mysqli_fetch_array($sql56);
              ?>
                 <script>
                     
                 pausecontent.push('<?php echo $sql57["name"]; ?>');
     </script>
          <?php       
             }
            ?>
    
         
  
  
	
		<div id="investigation" class="tab-section">
			<table width="100%" align="center">
                            <tr>
                                <td>Enter Batch Number</td>
                                <td><input type="text" id="combobox"  name="barcode" />
                                           
			
                                       <input type="button" id="chkall" value="Get All Pharmacy" /></td>
                            </tr>
                            <tr>
                                <td>Select Medicines</td>
                                <td>
                                    <select name="medi" id="medi" >
                                        
                                    </select>
                                </td>
                            </tr>
			
			  <tr>
			    <td colspan="2" align="center"><input type="button" name="barcode_chk" id="barcode_chk" value="Add" /></td>
			  </tr>
			</table>
		</div>
		
			
</form>

       
<?php
if($_POST['submit'])
{
	
	$pid=$_REQUEST['pid'];
	$patient_id=$_REQUEST['patient_id'];
	$patient_name=$_REQUEST['patient_name'];
	$btype=$_REQUEST['btype'];
	$date=date("d-m-Y H:i:s");
	
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
        $sql60=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
       
     foreach (array_combine($_REQUEST['bh'], $_REQUEST['qty']) as $bar => $qty) {
        
    $query1=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE id='".$bar."'");
	    $row1=mysqli_fetch_array($query1);
             $barcode=$row1['barcode'];
              $amt=$row1['price'];
	     $amt=$amt*$qty;
	      $pharname=$row1['name'];
	   
	
		$sql78=mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE barcode='".$barcode."'");
		$sql79=mysqli_fetch_array($sql78);
		 $avail=$sql79['availability'];
                 $navail=$avail+$qty;
		
				
				$query=mysqli_query($con,"INSERT INTO `pharmacy_returned`(`batch_number`,bill_number, `barcode`, `date_time`, `quantity`,price, `pid`,patient_id,patient_name,type) VALUES ('".$bar."','".$bill_number."','".$barcode."','".$date."','".$qty."','".$amt."','".$pid."','".$patient_id."','".$patient_name."','".$btype."')");
				$sql80=mysqli_query($con,"UPDATE pharmacy_availability SET availability='".$navail."' WHERE barcode='".$barcode."'");
				
		
		
}
  $t="<html><body style='margin:0;border:solid 1px #000000;margin:4px;'>
         <table width='100%' style='font-size:9px; border-bottom:solid 1px #000000;'>
       <tr>
       <td style='text-align:left; font-size:10px;width:50%;'> <b>MAHADEV PHARMACY</b><br/>Mahima Complex, Main Road, <br/>Vyapar Vihar<br/>Bilaspur-CG 495001</td>
       <td style='text-align:right; font-size:8px;width:50%;'>".$rnum."<br/>TIN: 22424105858</td>
       </tr>
       </table>
        <table width='100%' style='font-size:10px;'>
       <tr>
       <td colspan='4' style='text-align:center; font-size:10px; text-decoration:underline;'> <b>RETURN INVOICE</b> </td>
       </tr>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Date:  </th>
       <td style='padding-top:5px;'>$date</td>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Bill Number:</th>
       <td style='padding-top:5px;'>$bill_number</td>
       </tr>
      
        
       </table>
       <table width='95%' border='1' cellpadding='3px' style='border-collapse:collapse;font-size:8px;text-align:center;margin:5px;line-height:10px;'>
       <tr>
        
        <th width='20%'>Batch</th>
        <th width='45%'>Name</th>
        <th width='20%'>Expiry</th>
        <th width='5%'>Qty</th>
        <th width='5%'>Rate</th>
        <th  width='5%'>Amount</th>
	   </tr>
	    ";
   foreach (array_combine($_REQUEST['bh'], $_REQUEST['qty']) as $bar => $qty) {
       
       $query1=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE id='".$bar."'");
	    $row1=mysqli_fetch_array($query1);
             $barcode=$row1['barcode'];
             $batch_number=$row1['batch_number'];
              $amt=$row1['price'];
	     $amt=$amt*$qty;
	      $pharname=$row1['name'];
              $t=$t."<tr>
			
			<td>$row1[batch_number]</td>
			<td>$pharname</td>
                        <td>$row1[expiry_date]</td>
			<td>$qty</td>
			<td>$row1[price]</td>
			<td>$amt</td>
			</tr>";
              
              $tot=$tot+$amt;
                         $returntot=round($tot);
                        $amtwords=no_to_words($returntot);
              
   }
	   
		
	 
		$t=$t."<tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Sub Total</td>
		<td>Rs. $tot</td>
		</tr>
                <tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Returned Total</td>
		<td>Rs. $returntot</td>
		</tr>
                <tr>
		<td colspan='6' style='text-align:left;padding-right:11px;font-size:10px;'>Rs. $amtwords only.</td>
		
		</tr>";
        $t=$t."</table><br/><table width='75%' style='font-size:11px ;padding-top:6px;line-height:10px;line-width:15px;'><tr><td width='50%' style='padding-left:20px;'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>
            <table width='100%' style='font-size:9px;'>
       <tr>
       <td style='text-align:left; font-size:8px;width:50%;'> TERMS AND CONDITIONS:<br/>*All disputes subject to Bilaspur Jurisdiction.<br/>*Medicines without batch number and expiry date will not be taken back.<br/>*Please consult Doctor before using medicines.</td>
       
       </tr>
       </table><table width='100%' style='font-size:9px;padding-top:1px;'>
       <tr>
       <td style='text-align:center; font-size:8px;'> GET WELL SOON </td>
       </tr>
       </table>";
        $t=$t."</body></html>";
	
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
      
       echo "<script>alert('Pharmacy Return successfull'); printPage();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
 }
?>


<?php include 'footer.php'; ?>
