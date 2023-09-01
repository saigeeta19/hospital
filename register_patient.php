<?php session_start();?>
<?php include 'session.php'; ?> 
<?php include 'connection.php'; ?>
<?php
 
$logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
$check=mysqli_query($con,"SELECT * FROM assign_rights WHERE username='".$logger."'");
$check1=mysqli_fetch_array($check);
$billpre="OPD";


if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
	<?php include 'header.php'; ?>
	<?php
	if($_POST['submit'])
	{
	  $uid=$_REQUEST['uid'];
	   $ntitle=$_REQUEST['ntitle'];
       $name=$_REQUEST['fname'];
       $coname=$_REQUEST['co_name'];
       $gender=$_REQUEST['gender'];
	   $address=$_REQUEST['address'];
	   $phno=$_REQUEST['phno'];
       $date=date("d-m-Y H:i:s");
       $doctor=$_REQUEST['doctor'];
       $age=$_REQUEST['age'];
       $referred=$_REQUEST['referred'];
       $referred_num=$_REQUEST['referred_num'];
	   $pro_name=$_REQUEST['pro_name'];
       $mode=$_REQUEST['mode'];
       
    //payment type
        $pmode=$_REQUEST['pmode'];
        $card_bank_name=$_REQUEST['card_bank_name'];
        $cheque_bank_name=$_REQUEST['cheque_bank_name'];
        $card_holder=$_REQUEST['card_holder'];
        $cheque_holder=$_REQUEST['cheque_holder'];
        $cheque_number=$_REQUEST['cheque_number'];
        
        
        
       $date1=date("d-m-Y");
 $sql63=mysqli_query($con,"SELECT * FROM doctor_list WHERE doctor_name='".$doctor."'");
	   $sql64=mysqli_fetch_array($sql63);
       $doctor_fees=$sql64['doctor_fees'];
	   $partdoctorfees=($doctor_fees*50)/100;
       $s="no";
       // For Bill number
       $bd=date("Y/m/");
       $sql56=mysqli_query($con,"SELECT * FROM billnumbers WHERE bill_format='".$bd."'");
       if(mysqli_num_rows($sql56)>0)
       {
           $sql57=mysqli_query($con,"SELECT max(bill_number) FROM billnumbers WHERE bill_format='".$bd."'",$con);
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
       if($mode=="paid")
      {
          
        $day_today=strtotime($date1);
        $days_ago = date('d-m-Y', strtotime('-5 days', strtotime($date1)));
        $date_from = strtotime($days_ago); // Convert date to a UNIX timestamp
        $date_ten= date('d-m-Y', strtotime('-10 days', strtotime($date1)));
        $date_ten = strtotime($date_ten); // Convert date to a UNIX timestamp
           
        for ($i=$date_from; $i<=$day_today; $i+=86400) {
             $cdate=date("d-m-Y", $i);
             $query5=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$cdate%' && doctor='".$doctor."' && patient_id='".$uid."' && doctor_fees='".$doctor_fees."'");
             if(mysqli_num_rows($query5)>0)
             {
                 $doctor_fees=0;
                 $sta="(np)";
                 $s="yes";
                 
             }
             }
      
        
         if($s=="no")
             {
             for ($j=$date_ten; $j<$date_from; $j+=86400) {
                  $adate=date("d-m-Y", $j);
                 $query6=mysqli_query($con,"SELECT * FROM opd_entry WHERE date LIKE '$adate%'  && doctor='".$doctor."' && patient_id='".$uid."' && doctor_fees='".$doctor_fees."'");
             if(mysqli_num_rows($query6)>0)
             {
                 $doctor_fees=$partdoctorfees;
                 $sta="(p)";
                 $s="yes";
             }
             
             }
        }
          if($s=="no")
        {
            
            $doctor_fees=$doctor_fees;
                 $sta="(p)";
        }
           
                
    }
    else if($mode=="unpaid")
   {
       $doctor_fees=0;
        $sta="(np)";
        
    }
       
       
      
       
       
	  if($uid=="")
      {
          $sql=mysqli_query($con,"SELECT max(uid) FROM patients");
          $sql2=mysqli_fetch_array($sql);
          $uid=$sql2['max(uid)'];
          if($uid=="NULL")
          {
               $uid=1;
          }
          $uid=$uid+1;
          $sql3=mysqli_query($con,"INSERT INTO patients(uid,date,ntitle,name,co_name,gender,address,phone_number,entry_person) 
      VALUES ('".$uid."','".$date."','".$ntitle."','".$name."','".$coname."','".$gender."','".$address."','".$phno."','".$entry_person."')");
     if($sql3)
      {
         $date1=date("d-m-Y");
    $sql2=mysqli_query($con,"SELECT max(visit_num) FROM opd_entry WHERE date LIKE '$date1%'");
    if(mysqli_num_rows($sql2)>0)
    {
            $sql3=mysqli_fetch_array($sql2);
    $mid=$sql3['max(visit_num)'];
    //$sql4=mysqli_query($con,"SELECT * FROM opd_entry WHERE id='".$mid."'");
    //$sql5=mysqli_fetch_array($sql4);
    //$gnum=$sql5[visit_num];
    $visit_num=$mid+1;
      
    }
else {
      $visit_num=1;
}
           if($pmode=="Card")
        {
            $sql4=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','".$card_bank_name."','".$card_holder."','".$cheque_number."','opd','".$entry_person."')");
        }
        else if($pmode=="Cheque")
        {
             $sql4=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','opd','".$entry_person."')");
        }
        else if($pmode=="Cash")
        {
	    $sql4=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,mode,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','opd','".$entry_person."')");
        }
         
         $sql60=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
         $id=$uid;
         
     if($gender=="MALE")
    {
        $g="M";
    }
else if($gender=="FEMALE")
{
    $g="F";
}
   $t="<html><table width='100%' style='font-size:14px;padding-top:120px;padding-left:120px;text-align:left;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Name: </th>
       <td>$name</td>
       <th style='text-align:right;padding-right:10px;'>Age/Sex: </th>
       <td>$age/$g</td>
       <th style='text-align:right;padding-right:10px;'>S.No.:  </th>
       <td>$visit_num</td>
       </tr>
       <tr>
      
       <th style='text-align:right;padding-right:10px;'>Date:  </th>
       <td>$date1</td>
       <th style='text-align:right;padding-right:10px;'>UID:  </th>
       <td>$id</td>
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
         echo '<script>$("<div title=\'Registration Successfull\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Patient registered successfully. <br/>UID Number is: '.$id.'. <br/>Please note down the UID for further reference.</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });printPage();</script>'; 
         
    
      }
      
      else
         {
            echo '<script>$("<div title=\'Failure Message\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Something went wrong during registration. <br/>Please try again!!!</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>';   
        }
        }
        else {
         	$sql=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
            $sql1=mysqli_fetch_array($sql);
            $chfname=$sql1['name'];
            $chconame=$sql1['co_name'];
            if(($name!=$chfname && $coname!=$chconame))
            {
                echo "<script>alert('Enter Correct UID');</script>";
            }
        else {
               $sql3=mysqli_query($con,"UPDATE patients SET ntitle='".$ntitle."',name='".$name."',co_name='".$coname."',gender='".$gender."',address='".$address."',phone_number='".$phno."' WHERE uid='".$uid."'");
     $date1=date("d-m-Y");
    $sql2=mysqli_query($con,"SELECT max(visit_num) FROM opd_entry WHERE date LIKE '$date1%'");
    if(mysqli_num_rows($sql2)>0)
    {
            $sql3=mysqli_fetch_array($sql2);
    $mid=$sql3['max(visit_num)'];
    //$sql4=mysqli_query($con,"SELECT * FROM opd_entry WHERE id='".$mid."'");
    //$sql5=mysqli_fetch_array($sql4);
    //$gnum=$sql5[visit_num];
    $visit_num=$mid+1;
      
    }
else {
      $visit_num=1;
}
             if($pmode=="Card")
        {
            $sql42=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','".$card_bank_name."','".$card_holder."','".$cheque_number."','opd','".$entry_person."')");
        }
        else if($pmode=="Cheque")
        {
             $sql42=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','opd','".$entry_person."')",$con);
        }
        else if($pmode=="Cash")
        {
	    $sql42=mysqli_query($con,"INSERT INTO opd_entry(patient_id,bill_number,visit_num,date,age,referred_by,referred_by_num,pro_name,doctor,doctor_fees,mode,status,entry_person) VALUES ('".$uid."','".$bill_number."','".$visit_num."','".$date."','".$age."','".$referred."','".$referred_num."','".$pro_name."','".$doctor."','".$doctor_fees."','".$pmode."','opd','".$entry_person."')");
		
        }
    $sql60=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
    if($gender=="MALE")
    {
        $g="M";
    }
else if($gender=="FEMALE")
{
    $g="F";
}
  $t="<html><table width='100%' style='font-size:14px;padding-top:100px;padding-left:120px;text-align:left;line-height:30px;line-width:15px;'>
       <tr>
       <th style='text-align:right;padding-right:10px;'>Name: </th>
       <td>$name</td>
       <th style='text-align:right;padding-right:10px;'>Age/Sex: </th>
       <td>$age/$g</td>
       <th style='text-align:right;padding-right:10px;'>S.No.:  </th>
       <td>$visit_num</td>
       </tr>
       <tr>
      
       <th style='text-align:right;padding-right:10px;'>Date:  </th>
       <td>$date1</td>
       <th style='text-align:right;padding-right:10px;'>UID:  </th>
       <td>$uid</td>
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
            
              if($sql42)
      {
         echo '<script>$("<div title=\'Entry Successfull\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>OPD Entry Successfull.</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });printPage();</script>'; 
         
    
      }
      
      else
         {
            echo '<script>$("<div title=\'Failure Message\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Something went wrong during registration. <br/>Please try again!!!</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>';   
        }
    
        	
        }
	
	   }
	   }
	 
	?>
	
	
	
 
<script>



$(function() {
$( "#pdetails" ).click(function(){
    var uid=$("#uid").val();
    
                     $.ajax({
                        type:"post",
                        url:"getpatientdetails.php",
                        data:"uid="+uid,
                        success:function(data){
                          //    $("#fname").html(data);
                          if(data=="no")
                          {
                              alert("Patient Not Available");
                              document.getElementById("uid").value="";
                              
                          }
                          else
                          {
                           var arr=data.split("^"); 
                          // document.getElementById("ntitle").value=arr[0];
                           document.getElementById("fname").value=arr[1];
                           document.getElementById("co_name").value=arr[2];
                           document.getElementById("phno").value=arr[4];
                           document.getElementById("address").value=arr[5];
                           document.getElementById(arr[0]).checked=true;
                           document.getElementById(arr[3]).checked=true;
                        }
                        }
                     });
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
	<?php include 'sidebar.php' ?>
	<form name="patient_register" method="post" >
	 <tr>
            <td colspan="5"><p id="panel">OPD Entry Screen</p></td>
            </tr>
		<table id="table11"  name="t1" border="2" width="100%" >
            <tr>
               <td id="headus">Enter UID</td>
               <td colspan="3"><input type="text" name="uid" id="uid" />&nbsp;&nbsp;<input type="button" name="pdetails" id="pdetails" value="Get Details" /> </td>
            </tr>
            </table>
		
		
		<table id="table1"  name="t1" border="2" width="100%" >
		   
			<tr>
			<td colspan="4" id="table_head" >Personal Details</td>
			</tr>
			<tr>
			    <td>Title</td>
			    <td><input type="radio" name="ntitle" id="Miss" value="Miss" required="required"/>Miss<input type="radio" name="ntitle" id="Mr" value="Mr" required="required"/>Mr<input type="radio" name="ntitle" id="Mrs" value="Mrs" required="required" />Mrs<input type="radio" name="ntitle" id="Master" value="Master" required="required" />Master
			        <input type="radio" name="ntitle" id="Baby_of" value="Baby_of" required="required" />Baby of<input type="radio" name="ntitle" id="Baby" value="Baby" required="required" />Baby</td>
                <td>Name</td>
                <td><input type="text" name="fname" id="fname" required="required" /></td>
                
			</tr>
			<tr>
			     <td>C/O Name</td>
                <td><input type="text" name="co_name" id="co_name" required="required" /> </td>
				<td>Gender</td>
                <td><input type="radio" name="gender" id="MALE" value="MALE" required="required" />Male<input type="radio" name="gender" id="FEMALE" value="FEMALE" required="required" />Female<input type="radio" name="gender" id="OTHERS" value="OTHERS" required="required"/>Others</td>
              
            </tr>
			<tr>
			      <td>Phone Number</td>
                <td><input type="text" name="phno" id="phno" required="required" /> </td>
			    <td>Address</td>
                <td><textarea name="address" id="address" required="required"></textarea> </td>
                
			</tr>
			<tr>
			    <td colspan="4" id="table_head">Consultation</td>
			</tr>
			<tr>
			    <td>Select Doctor</td>
			    <td><select name="doctor" id="doctor" required="required">
			        <option value="">Select</option>
			        <?php
			        $query=mysql_query("SELECT * FROM doctor_list",$con);
                    while($row=mysql_fetch_array($query))
                    {
                        echo "<option value='".$row[doctor_name]."'>$row[doctor_name]</option>";
                    }
			        ?>
			        
			        
			    </select></td>
			    <td>Patient Age</td>
			    <td><input type="text" name="age" id="age" size="3" /> years</td>
			</tr>
			<tr>
			    <td>Referred By</td>
			    <td><input type="text" name="referred" id="referred"/></td>
			    <td>Referred By (Phone)</td>
                <td><input type="text" name="referred_num" id="referred_num"/></td>
       		</tr>
       		<tr>
			    <td>Select PRO</td>
			    <td><select name="pro_name">
			    	<option value="">Select</option>
			    </select></td>
			    <td></td>
                <td></td>
       		</tr>
       <tr>
			    <td>Select Mode</td>
                <td><input type="radio" id="paid" name="mode" value="paid" checked="checked"/>Paid<input type="radio" name="mode" id="unpaid" value="unpaid"/>No Paid</td>
             
				<td>Select Type </td>
                                <td><select name="pmode" id="pmode" required="required">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Cheque">Cheque</option>
                                    </select></td>
				
				
			
			</tr>
                </table>
             <table id="table" class="depofie" name="t1" border="4" width="100%">
                
            </table>
             <table id="table"  name="t1" border="4" width="100%">
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /><input type="reset" name="reset" /></p></td>
			</tr>
		</table>
		
		
	</form>
		
	<?php include 'footer.php'; ?>
	
