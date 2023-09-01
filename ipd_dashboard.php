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
     <?php include 'sidebar.php'; ?>
     
     <?php
       $limit = 1000;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$query=mysqli_query($con,"SELECT * FROM patient_diagnosis ORDER BY patient_ip_id DESC LIMIT $start_from, $limit");
?>
<script>
    $(document).ready(function()
{
    $('#search').keyup(function()
    {
        searchTable($(this).val());
    });
});

function searchTable('inputVal')
{
    var table = $('#tablepaging');
    table.find('tr').each(function(index, row)
    {
        var allCells = $('row').find('td');
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

<form name="patient_list" method="post">
    <tr>
            <td colspan="5"><p id="panel">IP Patients Dashboard</p></td>
            </tr>
    <tr >
                <td colspan="5">
            <p align="right">
        <label for="search">
            <strong>Search</strong>
        </label>
        <input type="text" id="search" align="right"/>&nbsp;
</p></td>
</tr>      
<?php  
$sql = "SELECT COUNT(id) FROM patient_diagnosis";  
$rs_result = mysqli_query($sql,$con);  
$row1 = mysqli_fetch_row($rs_result);  
$total_records = $row1['0'];  
$total_pages = ceil($total_records / $limit);  
$pagLink = "<div class='pagination' align='center'>";  
for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= " <a href='ipd_dashboard.php?page=".$i."'>".$i."</a> | ";  
};  
echo $pagLink . "</div><br/>";  
?>     
        <table id="tablepaging" class="yui" name="t1" border="4" width="100%" style="font-size:10px;" >
            
            
            <tr>
                <th>S.No.</th>
                <th>UID</th>
                <th>IP Number</th>
                <th>Admitted On</th>
                <th>Patient Name</th>
	        <th>Age</th>
                <th>Under Doctor</th>
                <th>Category</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Discharged On</th>
                <th>Registered By</th>
                <th>Discharged By</th>
                <th>Action</th>
            </tr>
            <?php
            $inc=1;
            while($row=mysqli_fetch_array($query))
            {
               
                $ip=$row['patient_ip_id'];
               
              
                $uid=$row['patient_id'];
                $sql=mysqli_query($con,"SELECT name FROM patients WHERE uid='".$uid."'");
                $sql1=mysqli_fetch_array($sql);
                $patient_name=$sql1['name'];
                $sql2=mysqli_query($con,"SELECT * FROM patient_admission WHERE patient_ip_id='".$ip."' && status!='shifted' && status!='re-admitted'");
                $sql3=mysqli_fetch_array($sql2);
                
                $adate=$row['admission_date'];
                $adate = date(" d-M-Y h:i a", strtotime($adate));
                $discharge_date=$row['discharge_date'];
                if($discharge_date=="")
                {
                    $discharge_date="";
                    $discharged_by="";
                }
                else {
                   $discharge_date = date(" d-M-Y h:i a", strtotime('$discharge_date')); 
                   $discharged_by=$row['entry_person'];
                   if($discharged_by=="")
                   {
                       //$discharged_by="BARKHA";
                   }
                }
                
                $mode=$row['mode_payment'];
                if($mode=="Credit")
                {
                   $mode=$mode." / ".$row['corporate'];
                }
            echo "
            <tr>
            <td align='center'>$inc</td>
            <td align='center'>$uid</td>
            <td align='center'>$ip</td>
            <td align='center'>$adate</td>
            <td align='center'>$patient_name</td>
 	        <td align='center'>$row[age] years</td>
            <td align='center'>$row[admit_under_doctor]</td>
            <td align='center'>$sql3[category] / $sql3[ward_name] / $sql3[bed_room_name]</td>
            <td align='center'>$row[mode]</td>
            <td align='center'>$sql3[status]</td>
            <td align='center'>$discharge_date</td>
            <td align='center'>$sql3[entry_person]</td>
			<td align='center'>$discharged_by</td>";
			 if($discharge_date!="")
                {
                    echo "<td align='center'><a href='printmainbill.php?ip=".$ip."' target='_blank' ><input type='button' name='pri' id='pri' value='Print' /></a></td>";
                }
			 else {
				 echo "<td></td>";
			 }
			
			echo "
            </tr>
            
            ";
            $inc++;
            }
            ?>
            
        </table>
</form>

    <!-- <div id="pageNavPosition" style="padding-top: 20px" align="center">
</div>
<script type="text/javascript"><!--
var pager = new Pager('tablepaging', 500);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script> -->
     
      <?php include 'footer.php'; ?>
      
