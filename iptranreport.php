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

if($right=="no" )
{
    header("location:unauthorized.php");
    exit;
}
?>
<?php include 'header.php'; ?>



<script>

$(function() {
$( "#app_date" ).datepicker();
$( "#app_date" ).datepicker("option", "dateFormat", "dd-mm-yy");
});


</script>

<?php include 'sidebar.php' ?>

<form name="appointment_book" action="ipreport.php" method="post" target="_blank">
    <tr>
            <td colspan="5"><p id="panel">Cash Collection IP Reports</p></td>
            </tr>
    <table id="table" name="t1" border="4" width="100%">
            
            
                <tr>
                    <td>Select Date</td>
                    <td><input type="text" name="app_date" id="app_date"  required='required'/></td>
               </tr>
                
            <tr>
                <td colspan="2" align="center"><p id="button" align="center"><input type="submit" name="submit" id="submit" value="Get Reports" /></p></td>
            </tr>
            
            </table>
                <table id="get_reports" name="t1" border="4" width="100%">
                   
                  
                    
            </table>
            
            
        </form>
<?php include 'footer.php'; ?>
<style>
    #appointments
    {
        background-color: orange;
    }
    
</style>
