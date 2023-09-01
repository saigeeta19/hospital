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


$( "#barcode_chk" ).click(function(){
	//var barcode=$("#barcode").val();
        var barcode=document.opd_entry.barcode.value;
                              $.ajax({
           	   	     	type:"post",
           	   	     	url:"getmedvalidity.php",
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
           	   	     	url:"getmedicinename.php",
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
            var total=0; var disc=0;
            var dmode=$("#pdmode").val();
            var dv=$("#pdval").val();
           
               
            $("input[name='bh[]']").each(function (){
                  
                  var ba=$(this).val();
                  var qt= $(':input:eq(' + ($(':input').index(this) + 1) + ')').val();
                  var that=$(':input:eq(' + ($(':input').index(this) + 3) + ')');
                  $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpharmarate.php",
           	   	     	data:"barcode="+ba+"&quantity="+qt,
           	   	     	success:function(data){
                                    
                                   
                             
                                //  $(':input:eq(' + ($(':input').index(this) + 2) + ')').val("neha");
                                 // $(':input:eq(' + ($(':input').index(this) + 2) + ')').val(data);
                               //document.getElementById("totamt").value=data;
                               total=parseFloat(total)+parseFloat(data);
                                $(that).val(data);
                            var bi=total;
                            
                            document.getElementById("subtot").value=bi;
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
            <td colspan="4"><p id="panel">Pharmacy Billing</p></td>
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
				<td>Enter Id</td>
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
                         <tr>
                            <td>Select Type </td>
                                <td><select name="pmode" id="pmode" required="required">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Cheque">Cheque</option>
                                    </select></td>
                                     <td>Select Discount </td>
                                <td><select name="pdmode" id="pdmode">
                                        <option value="">Select</option>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Amount">Amount</option>
                                        
                                    </select></td>
                        </tr>
                         <tr>
                            <td>Enter Discount Value </td>
                            <td><input type="text" name="pdval" id="pdval" size="3" value="0" />(Enter only Value)</td>
                                     <td></td>
                                <td></td>
                        </tr>
		</table>
              <table id="table" class="depofie" name="t1" border="4" width="100%">
                
            </table>
		<table id="table" class="medication" name="t1" border="4" width="100%">
			<tr width="100%">
				<th width="30%">Pharmacy Name</th>
				<th width="10%">Availability</th>
				<th width="10%">Quantity</th>
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
                        <td>Sub Total </td>
                        <td>Rs. <input type="text" id="subtot" size="3" /></td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>Rs. <input type="text" id="discount_val" name="discount_val" size="3" /></td>
                    </tr>
                    <tr>
                        <td>Total Bill Amount</td>
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
    
            <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
       <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>
  
  <script src="js/jquery-ui.js"></script>
  <script>
  $( function() {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
             primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
 
    $( "#combobox" ).combobox();
    
  } );
  </script>
	
		<div id="investigation" class="tab-section">
			<table width="100%" align="center">
                            <tr>
                                <td>Select Medicine</td>
                                <td><div class="ui-widget"><select id="combobox"  name="barcode">
                                            <option value="">Select</option>
                                         <?php
             $sql54=  mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE availability>0");
             while($sql55=  mysqli_fetch_array($sql54))
             {
                 $bar=$sql55['barcode'];
                 $ava=$sql55['availability'];
                 $sql56=  mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$bar."'");
                 $sql57=  mysqli_fetch_array($sql56);
                 
                 
                 echo "<option value='".$sql57['barcode' ]."'>$sql57[name]($ava)</option>";
             }
              ?>
			
                                        </select></div></td>
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
    $pmaxid="";
	$patient_id=$_REQUEST['patient_id'];
	$pid=$_REQUEST['pid'];
	$date=date("d-m-Y H:i:s");
        $btype=$_REQUEST['btype'];
        if($btype=="OPD")
        {
            $rnum="DL. No. CG-BZ2-18654 CG-BZ2-18655";
        }
 else if($btype=="IPD")
     {
        $rnum="DL. No. CG-BZ2-18622 CG-BZ2-18623";
     }
     
       //payment type
        $pmode=$_REQUEST['pmode'];
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
        //discount entry
                $pdmode=$_REQUEST['pdmode'];
                $pdval=$_REQUEST['pdval'];
                $damt=$_REQUEST['discount_val'];
                
                
              
       
     foreach (array_combine($_REQUEST[bh], $_REQUEST[qty]) as $bar => $qty) {
    $query1=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$bar."'");
	    $row1=mysqli_fetch_array($query1);
	    $amt=$row1['price'];
	    $amt=$amt*$qty;
	    $pharname=$row1['name'];
	
		$sql78=mysqli_query($con,"SELECT * FROM pharmacy_availability WHERE barcode='".$bar."'");
		$sql79=mysqli_fetch_array($sql78);
		$avail=$sql79['availability'];
                
               
		if($qty<=$avail)
		{
				$navail=$avail-$qty;
                                
                                 if($pmode=="Card")
        {
                $query=mysqli_query($con,"INSERT INTO pharmacy_entry(bill_number,pid,date,patient_id,barcode,pharmacy,quantity,amount,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person,type) VALUES ('".$bill_number."','".$pid."','".$date."','".$patient_id."','".$bar."','".$pharname."','".$qty."','".$amt."','".$pmode."','".$card_bank_name."','".$card_holder."','".$cheque_number."','pha','".$entry_person."','".$btype."')");
               
        }
        else if($pmode=="Cheque")
        {
           $query=mysqli_query($con,"INSERT INTO pharmacy_entry(bill_number,pid,date,patient_id,barcode,pharmacy,quantity,amount,`mode`, `bank_name`, `holder_name`, `cheque_number`,status,entry_person,type) VALUES ('".$bill_number."','".$pid."','".$date."','".$patient_id."','".$bar."','".$pharname."','".$qty."','".$amt."','".$pmode."','".$cheque_bank_name."','".$cheque_holder."','".$cheque_number."','pha','".$entry_person."','".$btype."')"); 
         
        }
        else if($pmode=="Cash")
        {
          $query=mysqli_query($con,"INSERT INTO pharmacy_entry(bill_number,pid,date,patient_id,barcode,pharmacy,quantity,amount,mode,status,entry_person,type) VALUES ('".$bill_number."','".$pid."','".$date."','".$patient_id."','".$bar."','".$pharname."','".$qty."','".$amt."','".$pmode."','pha','".$entry_person."','".$btype."')"); 
	  
        }
                                
                                
                                
				//$query=mysqli_query($con,"INSERT INTO pharmacy_entry(bill_number,pid,date,patient_id,barcode,pharmacy,quantity,amount,status,entry_person) VALUES ('".$bill_number."','".$pid."','".$date."','".$patient_id."','".$bar."','".$pharname."','".$qty."','".$amt."','pha','".$entry_person."')");
				$sql80=mysqli_query($con,"UPDATE pharmacy_availability SET availability='".$navail."' WHERE barcode='".$bar."'");
				
		}
		
}
  //get pharmacyid
               $sql33=mysqli_query($con,"SELECT max(id) FROM pharmacy_entry");
               $sql34=mysqli_fetch_array($sql33);
              $pmaxid=$sql34['max(id)'];
             
                
               $query777=  mysqli_query($con,"INSERT INTO `pharmacy_discounts`(`bill_number`, `discount_mode`, `discount_value`, `discount_amount`,date) VALUES ('".$bill_number."','".$pdmode."','".$pdval."','".$damt."','".$date."')");
                
  $sql60=mysqli_query($con,"INSERT INTO billnumbers(bill_format,bill_number) VALUES ('".$bd."','".$bn."')");
   $uid=$patient_id;
                $sql45=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql15=mysqli_fetch_array($sql45);
                $patient_name=$sql15['name'];
	$inc=1; $tot=0;
   $date = date("d-M-Y", strtotime($date));
	$t="<html><body style='margin:0;border:solid 1px #000000;margin:4px;'>
         <table width='100%' style='font-size:9px; border-bottom:solid 1px #000000;'>
       <tr>
       <td style='text-align:left; font-size:10px;width:50%;'> <b>MAHADEV PHARMACY</b><br/>Mahima Complex, Main Road, <br/>Vyapar Vihar<br/>Bilaspur-CG 495001</td>
       <td style='text-align:right; font-size:8px;width:50%;'>".$rnum."<br/>TIN: 22424105858</td>
       </tr>
       </table>
        <table width='100%' style='font-size:10px;'>
       <tr>
       <td colspan='4' style='text-align:center; font-size:10px; text-decoration:underline;'> <b>INVOICE</b> </td>
       </tr>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Date:  </th>
       <td style='padding-top:5px;'>$date</td>
       <th style='text-align:right;padding-right:10px;padding-top:5px;font-size:10px'>Bill Number:</th>
       <td style='padding-top:5px;'>$bill_number</td>
       </tr>
       <tr>
       <th style='text-align:right;padding-right:10px;font-size:10px'>UID: </th>
       <td>$patient_id</td>
       <th style='text-align:right;padding-right:10px;font-size:10px'>Patient Name: </th>
       <td><b>$patient_name</b></td>
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
	    $query1=mysqli_query($con,"SELECT * FROM pharmacy_entry WHERE bill_number='".$bill_number."'");
		while($row1=mysqli_fetch_array($query1))
		{
			 $barcode=$row1['barcode'];
				$sql67=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE barcode='".$barcode."'");
				$sql68=mysqli_fetch_array($sql67);
				$rate=$sql68['price'];
			$t=$t."<tr>
			
			<td>$sql68[batch_number]</td>
			<td>$row1[pharmacy]</td>
                        <td>$sql68[expiry_date]</td>
			<td>$row1[quantity]</td>
			<td>$rate</td>
			<td>$row1[amount]</td>
			</tr>";
			$tot=$tot+$row1['amount'];
                         $paitot=round($tot-$damt);
                        $amtwords=no_to_words($paitot);
                        
			
		}
		
	 
		$t=$t."<tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Sub Total</td>
		<td>Rs. $tot</td>
		</tr>
                <tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Discount</td>
		<td>Rs. $damt</td>
		</tr><tr>
		<td colspan='5' style='text-align:right;padding-right:10px;'>Paid Total</td>
		<td>Rs. $paitot</td>
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
      
       echo "<script>alert('Pharmacy Entry successfull');printPage();</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
 }
?>


<?php include 'footer.php'; ?>
