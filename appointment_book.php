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
    $(document).ready(function()
{
    $('#search').keyup(function()
    {
        searchTable($(this).val());
    });
});

function searchTable(inputVal)
{
    var table = $('#tablepaging');
    table.find('tr').each(function(index, row)
    {
        var allCells = $(row).find('td');
        if(allCells.length > 0)
        {
            var found = false;
            allCells.each(function(index, td)
            {
                var regExp = new RegExp(inputVal, 'i');
                if(regExp.test($(td).text()))
                {
                    found = true;
                    return false;
                }
            });
            if(found == true)$(row).show();else $(row).hide();
        }
    });
}
    
</script>
<?php
$msg=$_GET['msg'];
$msg=str_replace("'", "", $msg);
$msg=trim($msg);
if($msg=="cancel")
{
    echo "<script>alert('Appointment Cancelled Successfully!!!');</script>";
    header("location:appointment_book.php"); 
}

?>
<?php
$msg=$_GET['msg'];
$msg=str_replace("'", "", $msg);
$msg=trim($msg);
if($msg=="completed")
{
    echo "<script>alert('Completion Successful!!!');</script>";
    header("location:appointment_book.php"); 
}
if($msg=="booked")
{
    echo "<script>alert('Undo Successful!!!');</script>";
    header("location:appointment_book.php"); 
}
?>



<script>

$(function(){
    $("#app_date").datepicker({ gotoCurrent: true}).datepicker('setDate',"0");
    $( "#app_date" ).datepicker("option", "dateFormat", "dd-mm-yy");
});

	$(function() {
	
	var app_date=$("#app_date").val();
    
    
                     $.ajax({
                        type:"post",
                        url:"getappointments.php",
                        data:"app_date="+app_date ,
                        success:function(data){
                              $("#tablepaging").html(data);
                        }
                     });


$( "#app_date" ).change(function(){
	var app_date=$("#app_date").val();
	
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getappointments.php",
           	   	     	data:"app_date="+app_date ,
           	   	     	success:function(data){
                              $("#tablepaging").html(data);
           	   	     	}
           	   	     });
});

$( "#refresh" ).click(function(){
    var app_date=$("#app_date").val();
    var doctor=$("#doctor").val();
    
                     $.ajax({
                        type:"post",
                        url:"getappointments.php",
                        data:"app_date="+app_date + "&doctor="+doctor,
                        success:function(data){
                              $("#tablepaging").html(data);
                        }
                     });
});
 
});
</script>
<?php
$date=date("d-m-Y");
$query=mysqli_query($con,"select * FROM appointments where appointment_date='".$date."' ORDER BY id");

?>
<?php include 'sidebar.php' ?>

<form name="appointment_book" method="post">
    <tr>
            <td colspan="5"><p id="panel">Book an Appointment</p></td>
            </tr>
<table id="table" name="t1" border="4" width="100%">
			
			
				<tr>
					<td>Select Date</td>
					<td><input type="text" name="app_date" id="app_date" required="required"/></td>
					<td>Patient Name</td>
                    <td><input type="text" name="patient_name" id="patient_name" required="required"/></td>
					
				</tr>
				<tr>
				    <td>Doctor</td>
				    <td><select name="doctor" id="doctor">
				        <option value="">Select</option><?php
				        $sql=mysqli_query($con,"SELECT * FROM doctor_list");
                        while($sql1=mysqli_fetch_array($sql))
                        {
                            echo "<option value='".$sql1['doctor_name']."'>$sql1[doctor_name]</option>";
                        }
				        ?>
				    </select></td>
				<td>Appointment Time</td>
				<td><select name="appointment_time" id="appointment_time">
						<option value="10:00 AM">10:00 AM</option>
						<option value="11:00 AM">11:00 AM</option>
						<option value="12:00 PM">12:00 PM</option>
						<option value="01:00 PM">01:00 PM</option>
						<option value="02:00 PM">02:00 PM</option>
						<option value="03:00 PM">03:00 PM</option>
						<option value="04:00 PM">04:00 PM</option>
						<option value="05:00 PM">05:00 PM</option>
						<option value="06:00 PM">06:00 PM</option>
						<option value="07:00 PM">07:00 PM</option>
						<option value="08:00 PM">08:00 PM</option>
						<option value="09:00 PM">09:00 PM</option>
					</select></td>
					
			</tr>
			<tr>
			    <td>Phone Number</td>
                <td><input type="text" name="phone" id="phone" /></td>
			    <td></td>
                <td></td>
            </tr>
			<tr>
                <td colspan="4" align="center"><p id="button" align="center"><input type="submit" name="submit" value="Book an appointment" /></p></td>
            </tr>
            
            </table>
             <tr >
                <td colspan="5">
            <p align="right">
        <label for="search">
            <strong>Search</strong>
        </label>
        <input type="text" id="search" align="right"/>&nbsp;
</p></td>
</tr>     
				<table id="tablepaging" class="yui" name="t1" border="4" width="100%">
				   
					<?php
					$count=mysqli_num_rows($query);
                    $sql=mysqli_query($con,"SELECT * FROM appointments WHERE appointment_date='".$date."' && status='completed'");
                    $completed=mysqli_num_rows($sql);
                    $pending=$count-$completed;
   if($count>0)
   {
  $inc=1;
  echo "<tr><th id='table_head' align='center'><b>Date:- ".$date." </b></th>
  <th id='table_head' align='center'><b>Total Appointments:- ".$count." </b></th>
  <th id='table_head' align='center'><b>Completed:- ".$completed." </b></th>
  <th id='table_head' align='center'><b>Pending:- ".$pending." </b></th>
  <th id='table_head' align='center'></th>
  
 
  </tr>";
  echo "<tr>
                        <th>S.No</th>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Appointment Time</th>
                        <th>Action</th>
        </tr>";
					$inc=1;
					 while($row=mysqli_fetch_array($query))
                     {
                          $id=$row['id'];
                          $status=$row['status'];
                        echo "<tr><td align='center'>$inc</td>
                             <td align='center'>$row[patient_name]</td>
                             <td align='center'>$row[phone]</td>
                             <td align='center'>$row[app_time]</td>
                            <td align='center'><a href='updatestatus.php?id=".$id."&status=".$status."' style='text-decoration:none;'>";if($status=='completed'){ echo "Done &nbsp;&nbsp; <input type='button' name='undo' value='Undo'/>"; } 
    else if($status=='booked') { echo "<input type='button' name='complete' value='Complete'/>"; } echo "</a>
    &nbsp;<a href='getcancelappointment.php?id=".$id."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a>
    </td></tr>";
    $inc=$inc+1; 
                     }
                     }
					?>
					
			</table>
			
			
		</form>
		<?php
if($_POST['submit'])
{
    
    $patient_name=$_REQUEST['patient_name'];
    $appointment_time=$_REQUEST['appointment_time'];
    $app_date=$_REQUEST['app_date'];
    $doctor=$_REQUEST['doctor'];
    $phone=$_REQUEST['phone'];
    $query=mysqli_query($con,"INSERT INTO appointments(patient_name,doctor_name,appointment_date,app_time,phone,status,entry_person) VALUES ('".$patient_name."','".$doctor."','".$app_date."','".$appointment_time."','".$phone."','booked','".$entry_person."')");
    if($query)
    {
      
       echo "<script>alert('Appointment added successfully');</script>";
       
    }
    else 
    {
        
       echo "<script>alert('Please Try Again!!');</script>";
    }

}
?>
		 <div id="pageNavPosition" style="padding-top: 20px" align="center">
</div>
<script type="text/javascript"><!--
var pager = new Pager('tablepaging', 20);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
<?php include 'footer.php'; ?>

