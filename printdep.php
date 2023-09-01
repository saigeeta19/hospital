 <?php include 'session.php';
 include 'convert_words.php'; 
 include 'connection.php';
 $logger=$_SESSION['logger'];
$entry=mysqli_query($con,"SELECT * FROM users WHERE username='".$logger."'");
$entry1=mysqli_fetch_array($entry);
$entry_person=$entry1['name'];
 $id=$_GET['id'];
 $sta="";
 $query=mysqli_query($con,"SELECT * FROM deposits WHERE id='".$id."'");
     $row=mysqli_fetch_array($query);
    
     $patient_id=$row['patient_id'];
     $patient_ip_id=$row['patient_ip_id'];
     $amount=$row['amount'];
     $mode=$row['mode'];
     $status=$row['status'];
     $bill_number=$row['bill_number'];
     $date=$row[date];
     $date = date("d-M-Y", strtotime($date));
     $uid=$patient_id;
                $sql45=mysqli_query($con,"SELECT * FROM patients WHERE uid='".$uid."'");
                $sql15=mysqli_fetch_array($sql45);
                $patient_name=$sql15['name'];
     if($status=="D")
     {
         $sta="DEPOSIT";
     }
     else if($status=="CM")
     {
         $sta="CAUTION DEPOSIT";
     }
     else if($status=="CR")
     {
         $sta="CAUTION REFUND";
     }
     else if($status=="FSREC")
     {
         $sta="RECEIPT";
     }
     else if($status=="FSREF")
     {
         $sta="REFUND";
     }
     $amtwords=no_to_words($amount);
     
     $t="<html><table width='100%' style='font-size:14px ;padding-top:130px;line-height:30px;line-width:15px;'>
    <tr>
       <th style='text-align:center; font-size:18px;padding-right:20px; text-decoration:underline;' colspan='4'> $sta </th>
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
       </tr>";
     if($mode=="Card" || $mode=="Cheque")
     {
         $t=$t."<tr>
       <th style='text-align:right;padding-right:10px;'>Details: </th>
       <td colspan='3'>$mode / $row[bank_name] / $row[holder_name] / $row[cheque_number]</td>
       </tr>";
     }
     $t=$t." <tr>
       <th style='text-align:right;padding-right:10px;'>In words: </th>
       <td colspan='3' style='text-transform:uppercase;'>$amtwords rupees only.</td>
       
       </tr>";
       if($sta=="CR" && $amount<2500)
       {
              $sql=mysqli_query($con,"SELECT sum(amount) FROM caution_deduction WHERE patient_ip_id='".$patient_ip_id."'");
              $sql1=mysqli_fetch_array($sql);
              $cauded=$sql1['sum(amount)'];
              $reason=$sql1['reason'];
           echo "<tr>
       <th style='text-align:right;padding-right:10px;'>Deduction: </th>
       <td colspan='3' style='text-transform:uppercase;'>$cauded/- rupees ($reason) </td>
       </tr>";
           
       }
       
       echo "</table>";
       
            
        
        $t=$t."<br/><table width='85%' style='font-size:14px ;padding-top:50px;padding-left:100px;line-height:20px;line-width:15px;'><tr><td width='50%'>Cashier<br/>(".$entry_person.")</td><td width='50%' style='text-align:right;'>Receiver</td></tr></table>";
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
     echo "<script>printPage(); window.close();</script>";
     ?>
     