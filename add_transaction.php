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
<?php
$msg=$_GET['msg'];
$msg=str_replace("'", "", $msg);
$msg=trim($msg);
if($msg=="cancel")
{
    echo "<script>alert('Deleted Successful!!!');</script>"; 
    header("location:add_transaction.php");
}
?>
<?php include 'header.php'; ?>
<?php
if($_POST['submit'])
{
    $date=$_REQUEST['app_date'];
    $reason=$_REQUEST['reason'];
	$stype=$_REQUEST['stype'];
	$status=$_REQUEST['status'];
	
    $amount=$_REQUEST['amount'];
    $person=$_REQUEST['person'];
     
     $query=mysqli_query($con,"INSERT INTO banktransactions(date,reason,amount,person,stype,status,entry_person) VALUES ('".$date."','".$reason."','".$amount."','".$person."','".$stype."','".$status."','".$entry_person."')");
    if($query)
    {
      
       echo "<script>alert('Transaction added successfully');</script>";
       header("refresh:0");
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
    }
    

?>
<script>


    $(function() {
		$("#app_date").datepicker({ gotoCurrent: true}).datepicker('setDate',"0");
    $("#app_date").datepicker("option", "dateFormat", "dd-mm-yy");
		
    
    $( "#app_date" ).change(function(){
	
	var app_date=$("#app_date").val();
	
	window.location = "add_transaction.php?app_date="+app_date;       	    
});

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}
if($.urlParam('app_date')!="")
{
	$("#app_date").datepicker("setDate", $.urlParam('app_date'));
}

   });
</script>
<?php
$d=$_GET['app_date'];
if($d=="")
{
    $d=date("d-m-Y");
}
else
{
	$d=date($d);
}

$query=mysqli_query($con,"select * FROM banktransactions where date LIKE '$d%' && entry_person='".$entry_person."' ORDER BY id ASC");

$inc=1;$amt=0;
?>
<?php include 'sidebar.php' ?>
<form name="add_investigation" method="post">
        <tr>
            <td colspan="4"><p id="panel">Add Bank/Cheque Transactions</p></td>
            </tr>
        <table id="table" name="t1" border="4" width="100%">
            
            <tr>
                <td>Date</td>
                <td><input type="text" name="app_date" id="app_date" value="<?php echo date('d-m-Y', strtotime($d)); ?>" /></td>
                <td>Type</td>
                <td><select name="stype" id="stype" required="required">
				<option value="">Select</option>
				<option value="Bank">Bank</option>
				<option value="Cheque">Cheque</option>
				</select></td>
                </tr>
            <tr>
				<td>Reason</td>
                <td><input type="text" name="reason" id="reason" required="required"/></td>
                <td>Amount</td>
                <td>Rs. <input type="text" name="amount" id="amount" size="3" required="required"/></td>
              
                
            </tr>
			<tr>
               
                <td>Given to</td>
                <td><input type="text" name="person" id="person" /></td>
				<td>Status</td>
				 <td><select name="status" id="status" required="required">
				<option value="">Select</option>
				<option value="Paid">Paid</option>
				<option value="Not Paid">Not Paid</option>
				</select></td>
                
            </tr>
              <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
            </tr>
         </table>
         
          <table id="tablepaging" class="yui" name="t1" border="4" width="100%">
              
              <tr>
                  <th>S.No.</th>
                  <th>Date</th>
                  <th>Reason</th>
				  <th>Type</th>
                  <th>Amount</th>
                  <th>Person</th>
				  <th>Status</th>
                  <th>Entry By</th>
                  <th>Action</th>
              </tr>
             <?php
             if(mysqli_num_rows($query)>0)
             {
             while($row=mysqli_fetch_array($query))
             {
                 $id=$row['id'];
                 $amount=$row['amount'];
                 echo "
                 <tr>
                   <td align='center'>$inc</td>
                   <td align='center'>$row[date]</td>
                   <td align='center'>$row[reason]</td>
					 <td align='center'>$row[stype]</td>
                  
                   <td align='center'>$row[person]</td>
				    <td align='center'>$row[status]</td>
				    <td align='center'>Rs. $amount</td>
                   <td align='center'>$row[entry_person]</td>
                   <td align='center'>";
				  if($row['stype']=="Cheque")
				  {
				  echo " <a href='edit_transaction.php?id=".$id."'><img src='images/edit.png' title='Edit' id='edit' alt='edit' height='20px' width='20px'/></a> &nbsp;&nbsp;";
				   
				  }
				   echo "<a href='del_transaction.php?id=".$id."'><img src='images/cancel.png' title='Cancel' id='cancel' alt='Cancel' height='20px' width='20px'/></a>
    </td>
                 </tr>
                 ";
                 $inc++;
                 $amt=$amt+$amount;
             }
             
             echo "<tr>
             <td colspan='6' style='text-align:right;'>Total Cash</td>
             <td style='text-align:center;'>Rs. $amt</td>
             <td colspan='3'></td>
             </tr>";
             }
             else {
                 echo "<tr><td align='center' colspan='8' align='center'>No Transactions recorded till now</td></tr>";
             }
             ?>
          </table>
         
         
</form>
<?php include 'footer.php'; ?>