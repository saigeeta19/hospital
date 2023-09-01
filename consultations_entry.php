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
$right=$check1['ipd'];

if($right=="no")
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>

<?php include 'sidebar.php' ?>
<script>
        $(document).ready(function() {
            
             $("#doctor_0").select2({
                    placeholder: "Select Doctor",
                    allowClear: true
             });
            
        });
</script>
<script>

var z=1;
//var res="";

$(function() {  
 $( "#add" ).click(function(){
     
           
              $("#doctor_"+z).select2({
                    placeholder: "Select Doctor",
                    allowClear: true
             });
             
             z=z+1;
   
           
}); 
});
</script>  
<?php
$sql=mysqli_query($con,"SELECT DISTINCT doctor FROM departments ORDER BY doctor");
$doctors=array();
while($sql1=mysqli_fetch_array($sql))
{
    array_push($doctors,$sql1['doctor']);
}
?> 

<script language="JavaScript">
var doctors = <?php echo json_encode('$doctors'); ?>;

</script> 
 
<script>

    $(function() {
        
    $( "#app_date" ).datepicker();  
    $( "#app_date" ).datepicker("option", "dateFormat", "dd-mm-yy");
$( "#check_name" ).click(function(){
    var patient_ip_id=$("#patient_ip_id").val();
    
                     $.ajax({
                        type:"post",
                        url:"getuid.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#patient_id").html('data');
                        }
                     });
    
                
});

});
</script>
<script language="javascript" type="text/javascript">
var i=1;
function addRow()
{
      
      var tbl = document.getElementById('table1');
      var lastRow = tbl.rows.length;
      var iteration = lastRow - 1;
      var row = tbl.insertRow('lastRow');
      
      
     
      
      var firstCell = row.insertCell('0');
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
     firstCell.appendChild('el2');
     
      
      

     
      //alert(i);
      i++;
      document.add_ward.h.value=i;
     //alert(i);
}
</script>
<?php

$sql4=mysqli_query($con,"SELECT DISTINCT doctor FROM departments ORDER BY doctor");

?>
<form name="add_ward" method="post">
        <tr>
            <td colspan="4"><p id="panel">IP Consultation Entry</p></td>
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
                <td>Select Date</td>
                <td><input type="text" name="app_date" id="app_date" /></td>
                <td></td>
                <td></td>
            </tr>
           </table>
           <table id="table1" cellpadding="10" border="1" width="100%" align="center">
        <tr>
           
            <td ><strong>Doctor</strong></td>
        </tr>
        <tr>
        
    <td>
        <select name="doctor_0" id="doctor_0" >
        <option value="">Select Doctor</option>
        <?php
        while($sql5=mysqli_fetch_array($sql4))
        {
            echo "<option value='".$sql5['doctor']."'>$sql5[doctor]</option>";
        }
        ?>    
        </select>
    </td>
    
</tr>
</table>
<label>
<input name="h" type="hidden" id="h" value="1" />
</label>
             <table id="table" name="t1" border="4" width="100%"> 
            <tr>
                <td colspan="4"><p id="button" ><input type="button" id="add" value="Add 1 row" onclick="addRow();" /></p></td>
            </tr> 
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
            </tr>
        
        </table>
</form>
<?php include 'footer.php'; ?>
<style>
    #routine
    {
        background-color: orange;
    }
    
</style>
<?php
if($_POST['submit'])
{
    $patient_ip_id=$_REQUEST['patient_ip_id'];
    $date=date("d-m-Y H:i:s");
   
     echo $num=$_REQUEST['h'];
     
    
     for($i=0;$i<$num;$i++)
    {
         $doctor=$_POST["doctor_$i"];
         
         
        $chksql=mysqli_query($con,"SELECT * FROM departments WHERE doctor='".$doctor."'");
        $chkfet=mysqli_fetch_array($chksql);
        $amount=$chkfet['doctor_fees'];
        $sql2=mysqli_query($con,"INSERT INTO consultations_indents(date,patient_ip_id,doctor_name,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$doctor."','".$amount."','".$entry_person."')");
          
    }
    
   
    if($sql2)
    {
      
       echo "<script>alert('Consultation Entry successfull');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
}
?>
