<?php
include 'connection.php';
$fdate=$_POST['fromdate'];
$fdate=strtotime($fdate);
$tdate=$_POST['todate'];
$tdate=strtotime($tdate);
echo "
<tr>
  <th>S.no</th>
  <th>Date</th>
  <th>Consultation<br/>(OPD)</th>
  <th>Investigation<br/>(OPD)</th>
  <th>Procedure<br/>(OPD)</th>
   <th>Dental<br/>(OPD)</th>
  <th>IPD <br/>Indents</th>
  <th>Nutrition</th>
  <th>Total <br/>Expenses</th>
   <th>Total <br/>Refunds</th>
  <th>Total<br/> Collection</th>
 
  <th>Total Balance Collection</th>
</tr>
";
$inc=1;$amt=0;$totcon=0;$totinv=0;$totpro=0;$totden=0;$totipd=0;$totnut=0;$totphar=0;$totexpenses=0;$totdue=0;$totbalance=0;$totrefund=0;
for ($i=$fdate; $i<=$tdate; $i+=86400) {
       $cdate=date("d-m-Y", $i);
       $query=mysqli_query($con,"SELECT sum(doctor_fees) FROM opd_entry WHERE date LIKE '$cdate%'");
       $row=mysqli_fetch_array($query);
       $opdcon=$row['sum(doctor_fees)'];
       if($opdcon=="")
       {
           $opdcon=0;
       }
       
       $query1=mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE date LIKE '$cdate%'  && due_status=1");
       $row1=mysqli_fetch_array($query1);
       $opdinv=$row1['sum(investigation_fees)'];
        if($opdinv=="")
       {
           $opdinv=0;
       }
       
       $query2=mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE date LIKE '$cdate%'  && due_status=1");
       $row2=mysqli_fetch_array($query2);
       $opdpro=$row2['sum(procedure_fees)'];
        if($opdpro=="")
       {
           $opdpro=0;
       }
       
       
       
       $query3=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE (date LIKE '$cdate%' && status='D') OR (date LIKE '$cdate%' && status='FSREC')");
       $row3=mysqli_fetch_array($query3);
       $ipd=$row3['sum(amount)'];
        if($ipd=="")
       {
           $ipd=0;
       }
       
       $query4=mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE date LIKE '$cdate%' && due_status=1");
       $row4=mysqli_fetch_array($query4);
       $nutrition=$row4['sum(amount)'];
        if($nutrition=="")
       {
           $nutrition=0;
       }
       
       $query5=mysqli_query($con,"SELECT sum(discount_amount) FROM investigations_discounts WHERE date LIKE '$cdate%'");
       $row5=mysqli_fetch_array($query5);
        $invdiscounts=$row5['sum(discount_amount)'];
       
      
       $query6=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_discounts WHERE date LIKE '$cdate%'");
       $row6=mysqli_fetch_array($query6);
        $prodiscounts=$row6['sum(discount_amount)'];
       
       
        $query61=mysqli_query($con,"SELECT sum(discount_amount) FROM canteen_discounts WHERE date LIKE '$cdate%'");
       $row61=mysqli_fetch_array($query61);
        $candiscounts=$row61['sum(discount_amount)'];
       
       
       
       
       
        $query8=mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE date LIKE '$cdate%' && due_status=1");
       $row8=mysqli_fetch_array($query8);
       $opddpro=$row8['sum(dental_fees)'];
        if($opddpro=="")
       {
           $opddpro=0;
       }
       $query7=mysqli_query($con,"SELECT sum(discount_amount) FROM procedures_dental_discounts WHERE date LIKE '$cdate%'");
       $row7=mysqli_fetch_array($query7);
        $prodendiscounts=$row7['sum(discount_amount)'];
       
       
       
       $query9=mysqli_query($con,"SELECT sum(amount) FROM expenses WHERE date LIKE '$cdate%'");
       $row9=mysqli_fetch_array($query9);
        $expenses=$row9['sum(amount)'];
        if($expenses=="")
       {
           $expenses=0;
       }
       
       $query10=mysqli_query($con,"SELECT sum(totalamount) FROM due_amounts WHERE date_time LIKE '$cdate%'");
       $row10=mysqli_fetch_array($query10);
        $dueamt=$row9['sum(totalamount)'];
        if($dueamt=="")
       {
           $dueamt=0;
       }
       
       $query11=mysqli_query($con,"SELECT sum(amount) FROM deposits WHERE date LIKE '$cdate%' && status='FSREF'");
       $row11=mysqli_fetch_array($query11);
       $refunds=abs($row11['sum(amount)']);
        if($refunds=="")
       {
           $refunds=0;
       }
       
       //balance after discounts
       $opdinv=$opdinv-$invdiscounts;
       $opdpro=$opdpro-$prodiscounts;
       $opddpro=$opddpro-$prodendiscounts;
       $nutrition=$nutrition-$candiscounts;
       
       
       
       
       $total=$opdcon+$opdinv+$opdpro+$ipd+$opddpro+$nutrition;
       $balancecash=$total-$expenses-$refunds;
       $amt=$amt+$total;
       
       $date = date(" d-M-Y", strtotime($cdate));
       $totcon=$totcon+$opdcon;
       $totinv=$totinv+$opdinv;
	   $totpro=$totpro+$opdpro;
	   $totden=$totden+$opddpro;
	   $totnut=$totnut+$nutrition;
	   $totipd=$totipd+$ipd;
       $totexpenses=$totexpenses+$expenses;
       $totdue=$totdue+$dueamt;
	   $totbalance=$totbalance+$balancecash;
	   $totrefund=$totrefund+$refunds;
	   
        
				
           echo "
           <tr>
             <td align='center'>$inc</td>
             <td align='center'>$date</td>
             <td align='center'>Rs. $opdcon</td>
             <td align='center'>Rs. $opdinv</td>
             <td align='center'>Rs. $opdpro</td>
                 <td align='center'>Rs. $opddpro</td>
             <td align='center'>Rs. $ipd</td>
             <td align='center'>Rs. $nutrition</td>
            
            <td align='center'>Rs. $expenses</td>
              <td align='center'>Rs. $refunds</td>
            <td align='center'>Rs. $total</td>
            <td align='center'>Rs. $balancecash</td>
           </tr>
           ";
           $amt=$amt+$amount;
           $inc++;
       
}    

echo "<tr>
<td colspan='2'>Total Collection</td>
<td style='text-align:center;'>Rs. $totcon</td>
<td style='text-align:center;'>Rs. $totinv</td>
<td style='text-align:center;'>Rs. $totpro</td>
<td style='text-align:center;'>Rs. $totden</td>
<td style='text-align:center;'>Rs. $totipd</td>
<td style='text-align:center;'>Rs. $totnut</td>
<td style='text-align:center;'>Rs. $totexpenses</td>
<td style='text-align:center;'>Rs. $totrefund</td>
<td style='text-align:center;'>Rs. $amt</td>
<td style='text-align:center;'>Rs. $totbalance</td>

</tr>";
?>