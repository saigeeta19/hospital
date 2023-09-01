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
$right=$check1['billing'];

if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>

<script>

	$(function() {
		
		
	$( "#app_date" ).datetimepicker();  
    $( "#app_date" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
    
		
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
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getipbillamount.php",
           	   	     	data:"patient_ip_id="+patient_ip_id,
           	   	     	success:function(data){
                              $("#patient_check").html(data);
           	   	     	}
           	   	     });
    
         	    
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
if($_POST['submit'])
{
	$date=$_REQUEST['app_date'];
	$patient_ip_id=$_REQUEST['patient_ip_id'];
	$patient_id=$_REQUEST['patient_id'];
	$amount=$_REQUEST['amount'];
        
        
         $mode=$_REQUEST['mode'];
        $card_bank_name=$_REQUEST['card_bank_name'];
        $cheque_bank_name=$_REQUEST['cheque_bank_name'];
        $card_holder=$_REQUEST['card_holder'];
        $cheque_holder=$_REQUEST['cheque_holder'];
        $cheque_number=$_REQUEST['cheque_number'];
	
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
        
         $amtwords=no_to_words($amount);
     $t="<html><table width='100%' style='font-size:14px ;padding-top:130px;line-height:30px;line-width:15px;'>
	<tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> Deposit </th>
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
       <td colspan='3'>Rs. $amount/-</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$amtwords rupees only.</td>
       
       </tr>
       </table>";
       
            
        
        $t=$t."<br/><table width='85%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $t=$t."</html>";
        
        
        $dep=$amount-2500;
        $caut=2500;
        $depwords=no_to_words($dep);
        $cautwords=no_to_words($caut);
        
         $ts="<html><table width='100%' style='font-size:14px ;padding-top:130px;line-height:30px;line-width:15px;'>
    <tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> Deposit </th>
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
       <td colspan='3'>Rs. $dep/-</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$depwords rupees only.</td>
       
       </tr>
       </table>";
       
            
        
        $ts=$ts."<br/><table width='85%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $ts=$ts."</html>";
        
        
        
        $tr="<html><table width='100%' style='font-size:14px ;padding-top:130px;line-height:30px;line-width:15px;'>
    <tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> Caution Deposit </th>
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
       <td colspan='3'>Rs. $caut/-</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$cautwords rupees only.</td>
       
       </tr>
       </table>";
       
            
        
        $tr=$tr."<br/><table width='85%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
        $tr=$tr."</html>";
        
        
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

<script>
       
function printPage1()
{
var html = <?php echo json_encode($ts); ?>;

 var printWin = window.open("","","left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0");
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>
<script>
       
function printPage2()
{
var html = <?php echo json_encode($tr); ?>;

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
   // $sql=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."'");
   // if(mysqli_num_rows($sql)>0)
  //  {
        if($mode=="Card")
        {
            $query=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,date,bill_number,amount,mode,bank_name,holder_name,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$bill_number."','".$amount."','".$mode."','".$card_bank_name."','".$card_holder."','D','".$entry_person."')");
        }
        else if($mode=="Cheque")
        {
             $query=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,date,bill_number,amount,mode,bank_name,holder_name,cheque_number,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$bill_number."','".$amount."','".$mode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','D','".$entry_person."')");
        }
        else if($mode=="Cash")
        {
	$query=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,date,bill_number,amount,mode,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$bill_number."','".$amount."','".$mode."','D','".$entry_person."')");
        }
    if($query)
	{
	  
	   echo "<script>alert('Deposit Entry successfull'); printPage();</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
  /*  $sql=mysqli_query($con,"SELECT * FROM deposits WHERE patient_ip_id='".$patient_ip_id."'");
    if(mysqli_num_rows($sql)>0)
    {
	$query=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,patient_id,date,bill_number,amount,status,entry_person) VALUES ('".$patient_ip_id."','".$patient_id."','".$date."','".$bill_number."','".$amount."','D','".$entry_person."')");
    if($query)
	{
	  
	   echo "<script>alert('Deposit Entry successfull'); printPage();</script>";
	   
	}
	else 
	{
	   echo "<script>alert('Please Try Again!!');</script>";
	}
    }
    else {
        if($amount>=2500)
        {
           $caution=2500;
           $amount=$amount-$caution;
           $sql1=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,bill_number,patient_id,date,amount,status,entry_person) VALUES ('".$patient_ip_id."','".$bill_number."','".$patient_id."','".$date."','".$caution."','CM','".$entry_person."')");
		   if($amount!=0)
		   {
           $query=mysqli_query($con,"INSERT INTO deposits(patient_ip_id,bill_number,patient_id,date,amount,status,entry_person) VALUES ('".$patient_ip_id."','".$bill_number."','".$patient_id."','".$date."','".$amount."','D','".$entry_person."')");
		   }
    if($query || $sql1)
    {
    	
        echo "<script>alert('Deposit Entry successfull');printPage1(); printPage2();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
        }
		else {
			echo "<script>alert('Deposit Amount Should be minimum 2500!!');</script>";
		}
    
    }
    */
    
}
?>
<?php include 'sidebar.php' ?>

<form name="deposit" method="post" onsubmit="return confirm('Are you sure?');">
		<tr>
            <td colspan="4"><p id="panel">Deposit Entry Page for Released Patients</p></td>
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
				<td>Select Date </td>
				<td> <input type="text" name="app_date" id="app_date" required="required" /></td>
				<td>Enter Amount to Deposit</td>
				<td>Rs. <input type="text" name="amount" id="amount" size="5" required="required"/></td>
				
			</tr>
                         <tr>
				<td>Select Payment Mode </td>
                                <td><select name="mode" id="mode" required="required">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Cheque">Cheque</option>
                                    </select></td>
				<td></td>
				<td></td>
				
			</tr>
			</table>
             <table id="table" class="depofie" name="t1" border="4" width="100%">
                
            </table>
			<div class="dis">
				<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" id="submit" name="submit" value="Add Deposit" /></p></td>
			</tr>
		</table>
		</div>
		
	</form>

<?php include 'footer.php'; ?>

        
       

