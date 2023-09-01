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
$right=$check1['opd'];

if($right=="no")
{
	header("location:unauthorized.php");
	exit;
}
?>
<?php include 'header.php'; ?>
<?php
$sql4=mysqli_query($con,"SELECT DISTINCT doctor FROM departments ORDER BY doctor");
$sql6=mysqli_query($con,"SELECT * FROM add_investigation");
?>
<script>
        $('document').ready(function() {
             $("#mode_0").select2({
                    placeholder: "Select Mode",
                    allowClear: true
             });
            $("#doctor_0").select2({
                    placeholder: "Select Doctor",
                    allowClear: true
             });
             $("#investigation_0").select2({
                    placeholder: "Select Investigation",
                    allowClear: true
             });
        });
</script>

<?php
	$query8=mysqli_query($con,"SELECT * FROM corporates");
	?>


<?php
$sql=mysqli_query($con,"SELECT DISTINCT doctor FROM departments ORDER BY doctor");
$doctors=array();
while($sql1=mysqli_fetch_array($sql))
{
    array_push($doctors,$sql1['doctor']);
}
?>
<?php
$sql2=mysqli_query($con,"SELECT * FROM add_investigation");
$investigations=array();
while($sql3=mysqli_fetch_array($sql2))
{
    array_push($investigations,$sql3['investigation_name']);
}

?>
<script language="JavaScript">
var doctors = <?php echo json_encode('$doctors'); ?>;
var investigations = <?php echo json_encode('$investigations'); ?>;
</script> 

<script>
var z=1;
var y=1;
var x=1;
//var res="";

$(function() {  
 $( "#add" ).click(function(){
     
           $("#mode_"+x).select2({
                    placeholder: "Select Mode",
                    allowClear: true
             });
             
             x=x+1;
   
            $("#doctor_"+z).select2({
                    placeholder: "Select Doctor",
                    allowClear: true
             });
             
             z=z+1;
             $("#investigation_"+y).select2({
                    placeholder: "Select Investigation",
                    allowClear: true
             });
             
             y=y+1;
}); 
});
</script>      

<script>
$('document').ready(function(){
	
		
		$("#credit_select").hide(); 
		$("#corporate").hide();
		
});



$(function() {
$( "#check_name" ).click(function(){
	var patient_id=$("#patient_id").val();
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getpatientname.php",
           	   	     	data:"patient_id="+patient_id,
           	   	     	success:function('data'){
                              $("#patient_name").html(data);
           	   	     	}
           	   	     });
});




$("#credit").click(function(){
	$("#credit_select").show(); 
	$("#corporate").show(); 
});
$("#cash").click(function(){
	$("#credit_select").hide(); 
	$("#corporate").hide(); 
});


});
</script>

<script language="javascript" type="text/javascript">
var i=1;
/*function delRow()
{
   var tbl = document.getElementById('table1');
      var lastRow = tbl.rows.length;
     
      var k=lastRow-1;
     // var iteration = lastRow - 1;
      //var row = tbl.insertRow(lastRow); 
      tbl.deleteRow(k);
} */
function addRow()
{
      
      var tbl = document.getElementById('table1');
      var lastRow = tbl.rows.length;
      var iteration = lastRow - 1;
      var row = tbl.insertRow('lastRow');
      
      var firstCell = row.insertCell('0');
      var el = document.createElement('select');
      el.type = 'text';
      el.name = 'mode_' + i;
      el.id = 'mode_' + i;
      el100= document.createElement('option');
       el100.value="";
       el100.innerHTML="Select Mode";
       el.appendChild('el100');
       el101= document.createElement('option');
       el101.value="Consultation";
       el101.innerHTML="Consultation";
       el.appendChild('el101');
       el102= document.createElement('option');
       el102.value="Investigation";
       el102.innerHTML="Investigation";
       el.appendChild('el102');
       
      
      firstCell.appendChild('el');
     
      var secondCell = row.insertCell('1');
      var el2 = document.createElement('select');
      el2.type = 'text';
      el2.name = 'doctor_' + i;
      el2.id = 'doctor_' + i;
      
      el200= document.createElement('option');
         
          el200.value="";
          el200.innerHTML="Select Doctor";
          el2.appendChild('el200');
      for(var m=0; m < doctors.length;m++)
      {
          var elh="el2"+m;
          
         elh= document.createElement('option');
         
          elh.value=doctors['m'];
          elh.innerHTML=doctors['m'];
          el2.appendChild('elh');
      }
     secondCell.appendChild('el2');
     
     
      
      var thirdCell = row.insertCell('2');
      var el3 = document.createElement('select');
      
      el3.type = 'text';
      el3.name = 'investigation_' + i;
      el3.id = 'investigation_' + i;
      
     // el.className='flexselect';
      
      
      el300= document.createElement('option');
         
          el300.value="";
          el300.innerHTML="Select Investigation";
          el3.appendChild('el300');
      for('var j=0; j < investigations.length;j++')
      {
          var elg="el3"+j;
          
         elg= document.createElement('option');
         
          elg.value=investigations['j'];
          elg.innerHTML=investigations['j'];
          el3.appendChild('elg');
      }
     thirdCell.appendChild('el3');
     
      var fourthCell = row.insertCell('3');
      var el4 = document.createElement("input");
      el4.type = "checkbox";
      el4.name="chkbox[]";
      fourthCell.appendChild('el4');

     
      //alert(i);
      i++;
      document.opd_entry.h.value=i;
     //alert(i);
}

  function deleteRow('tableID') {
try {
var table = document.getElementById('tableID');
var rowCount = table.rows.length;
for('var i=0; i<rowCount; i++') {
var row = table.rows['i'];
var chkbox = row.cells['3'].childNodes['0'];
if('null != chkbox && true == chkbox.checked') {
    
table.deleteRow('i');
rowCount--;
i--;
}
 }
}catch('e') {
alert('e');
}
}
</script>
<script>
$(function(){
$( "#totalamt" ).click(function(){
    var num=$("#h").val();
    document.getElementById("amt").value=0;
    for(var k=0; k<num; k++)
    {
        var mode=$("#mode_"+k).val();
        var doctor=$("#doctor_"+k).val();
        var investigation=$("#investigation_"+k).val();
       
          $.ajax({
                        type:"post",
                        url:"getopdamount.php",
                        data:"mode="+mode+"&doctor="+doctor+"&investigation="+investigation,
                        success:function('data'){
                            
                            if(data!="")
                            {
                            var dat=parseInt('data,10');
                            var amt=$("#amt").val();
                            //alert('amt');
                            var amt=parseInt('amt,10');
                            var amt=amt+dat;
                           // alert('amt');
                           document.getElementById("amt").value=amt;
                        }
                        }
                     });
    }
    
                  
});
});
</script>

<?php include 'sidebar.php' ?>
<form name="opd_entry" method="post" >
	<tr>
            <td colspan="4"><p id="panel">OPD Billing</p></td>
            </tr>	
		<table id="table" name="t1" border="4" width="100%">
			<tr>
				<td>Enter UID of patient</td>
          	    <td><input type="text" name="patient_id" id="patient_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Name</td>
          	    <td><select name="patient_name" id="patient_name">
          	    	
          	    </select></td>
			</tr>
			<tr>
				<td>Mode of Payment</td>
				<td><input type="radio" name="payment_mode" id="cash" value="Cash"/>Cash<input type="radio" name="payment_mode" id="credit" value="Credit" />Credit</td>
				<td><p id="credit_select">Select Credit Department</p></td>
				<td><select name="corporate" id="corporate">
					<option value="">Select</option>
					<?php
					while($row8=mysqli_fetch_array('$query8'))
					{
						echo "<option value=$row8[name]>$row8[name]</option>" ;
					}
					?>
				</select></td>
			</tr>
			<tr>
			    <td>Total Amount</td>
			    <td>Rs.<input type="text" id="amt" name="amt" value="0" disabled="disabled" size="3"/></td>
			    <td></td>
			    <td></td>
			</tr>
			<table id="table1" cellpadding="10" border="1" width="100%" align="center">
        <tr>
            <td><strong>Mode</strong></td>
            <td><strong>Doctor</strong></td>
            <td><strong>Investigation</strong></td>
            <td><strong> Action</strong></td>
  </tr>
  <tr>
     <td>
         <select name="mode_0" id="mode_0" >
            
             <option value="">Select Mode</option>
             <option value="Consultation">Consultation</option>
             <option value="Investigation">Investigation</option>
             
         </select>
         
     </td> 
    <td>
        <select name="doctor_0" id="doctor_0" >
        <option value="">Select Doctor</option>
        <?php
        while($sql5=mysqli_fetch_array('$sql4'))
        {
            echo "<option value='".$sql5['doctor']."'>$sql5[doctor]</option>";
        }
        ?>    
        </select>
    </td>
    <td><select name="investigation_0" type="text" id="investigation_0">
        <option value="">Select Investigation</option>
        <?php
        while($sql7=mysqli_fetch_array('$sql6'))
        {
            echo "<option value='".$sql7['investigation_name']."'>$sql7[investigation_name]</option>";
        }
        ?>    
        </select>
    </td>
    <td><input type="checkbox" name="chk"/></td>
    
</tr>

</table>
<table id="view_data">
    
</table>

<label>
<input name="h" type="hidden" id="h" value="1" />

</label>
			 <table id="table" name="t1" border="4" width="100%"> 
			     
            <tr>
                 <td><p id="button" align="center"><input type="button" id="add" value="Add New Row" onclick="addRow();" /></p></td>
                 <td><p id="button" align="center"><input type="button" id="del" value="Delete Checked Rows" onclick="deleteRow('table1');" /></p></td>
                 <td><p id="button" align="center"><input type="button" id="totalamt" name="totalamt" value="Total Amount"  /></p></td>
                 <td colspan="2"><p id="button" align="center"><input type="submit" name="view" id="view" value="View Bill Details" onclick="action='getopdbill.php'; target='_blank';" /></p></td>
                <td colspan="2"><p id="button" align="center"><input type="submit" name="save" id="save" value="Save" onclick="action='opd_entry.php'; target='_parent';"/></p></td>
            
            </tr> 
			 
			
</table>
</form>


<?php
   
    $patient_id=$_REQUEST['patient_id'];
    if($patient_id!="")
    {
       
    $patient_name=$_REQUEST['patient_name'];
    $date=date("d-m-Y H:i:s");
    $payment_mode=$_REQUEST['payment_mode'];
    $corporate=$_REQUEST['corporate'];
     $num=$_REQUEST['h'];
     $queryb=mysqli_query($con,"SELECT max(id) FROM opd_entry");
     if(mysqli_num_rows('$queryb')>0)
     {
         $queryc=mysqli_fetch_array('$queryb');
         $bill_number=$queryc['max(id)']+1;
         $bill_number="OPD".$bill_number;
     }
    
     for($i=0;$i<$num;$i++)
    {
        
          $mode=$_POST["mode_$i"];
           $doctor=$_POST["doctor_$i"];
          $investigation=$_POST["investigation_$i"];
         
         if($mode=="Consultation")
         {
             $investigation="";
             $investigation_fees="";
             $query1=mysqli_query($con,"SELECT * FROM departments WHERE doctor='".$doctor."'");
             $row1=mysqli_fetch_array($query1);
             $doctor_fees=$row1['doctor_fees'];
         }
         else if('$mode=="Investigation"')
         {
             $doctor_fees="";
             $query2=mysqli_query($con,"SELECT * FROM add_investigation WHERE investigation_name='".$investigation."'");
             $row2=mysqli_fetch_array('$query2');
             $investigation_fees=$row2['price'];
         }
         if($mode!="")
         {
       $query=mysqli_query($con,"INSERT INTO opd_entry(bill_number,patient_id,patient_name,date,opd_mode,doctor,doctor_fees,investigation,investigation_fees,payment_mode,corporate_name,status,entry_person) VALUES ('".$bill_number."','".$patient_id."','".$patient_name."','".$date."','".$mode."','".$doctor."','".$doctor_fees."','".$investigation."','".$investigation_fees."','".$payment_mode."','".$corporate."','opd','".$entry_person."')");
         }  
    }
    
   
    if($query)
    {
      
       echo "<script>alert('OPD Entry successfull');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    }

?>


<?php include 'footer.php'; ?>
