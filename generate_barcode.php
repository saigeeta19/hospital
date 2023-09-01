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

<script src="js/jquery-ui.js" type="text/javascript"></script>



<script>

$(function(){
    $("#app_from").datepicker();
    $( "#app_from" ).datepicker("option", "dateFormat", "dd-mm-yy");
    $("#app_to").datepicker();
    $( "#app_to" ).datepicker("option", "dateFormat", "dd-mm-yy");
});
</script>

    <?php
    if($_POST['submit'])
    {
     $from=$_REQUEST['app_from'];
     $to=$_REQUEST['app_to'];
     $from = strtotime($from);
     $to = strtotime($to);
     for ($i=$from; $i<=$to; $i+=86400) {
        
         $date=date("d-m-Y",$i); 
        $query=mysqli_query($con,"SELECT * FROM pharmacy_stocklist WHERE date_time LIKE '$date%'");
      while( $row=mysqli_fetch_array($query))
      {
        $barcode=$row['barcode'];
        $amt=$row['price'];
            

   
       echo '<script>$(function(){
           
            $("<p style=font-size:7px;background-color:#FFFFFF;color:#000000;margin-bottom:-15px;>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rs. '.$amt.'&nbsp;&nbsp;&nbsp;&nbsp;</p>").appendTo("#bar");    
           var a="'.$barcode.'"; $("<p></p>").appendTo("#bar").barcode(a, "ean13",{barWidth:1, barHeight:25});  
          
          
      
      });</script>';
      
      
      
      
      
      
     }
     }


echo '<script language="javascript" type="text/javascript">
function printDiv()
{
      var divElements = document.getElementById("bar").innerHTML;
      var oldPage = document.body.innerHTML;

            
            document.body.innerHTML = 
              "<html><head><title></title></head><body  style=font-size:7px;background-color:#FFFFFF;color:#000000;><div style=width:120px;font-size:7px;background-color:#FFFFFF;color:#000000;>" + 
              divElements + "</div></body>";

           
            window.print();

            
            document.body.innerHTML = oldPage;
            window.location.href = window.location.href;
}
            </script>';
            
    }
    ?>
    
    
   
 
    



<?php include 'sidebar.php' ?>

<form name="patient_list" method="post">
    <tr>
            <td colspan="5"><p id="panel">Generate Barcode</p></td>
            </tr>
              <table id="table" name="t1" border="4" width="100%">
            <tr>
                    <td>Select From Date</td>
                    <td><input type="text" name="app_from" id="app_from" /></td>
                    <td>Select To Date</td>
                    <td><input type="text" name="app_to" id="app_to" /></td>
                </tr>
                
            <tr>
                <td colspan="4" align="center"><p id="button" align="center"><input type="submit" name="submit" id="submit" value="Generate Barcode" /></p></td>
            </tr>
            
            </table>
             <input type="button"  value="Print Barcodes" onclick="javascript:printDiv()" />
            
</form>
  <div id="bar" style="background-color: #FFFFFF;padding:10px;">
           
                    
        </div>
      <?php include 'footer.php'; ?>
