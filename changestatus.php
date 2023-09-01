<?php
include 'connection.php';
$type=$_GET['type'];
$bill=$_GET['bill'];
$date=date("d-m-Y H:i:s");
$date1=date("d-m-Y");
if($type=="inv")
{

    $query2=  mysqli_query($con,"SELECT sum(investigation_fees) FROM investigation_entry WHERE bill_number='".$bill."'");
    $row2=  mysqli_fetch_array($query2);
    $amount=$row2['sum(investigation_fees)'];
    
     $query3=  mysqli_query($con,"SELECT * FROM investigation_entry WHERE bill_number='".$bill."' && date LIKE '$date1%'");
     if(mysqli_num_rows($query3)>0)
     {
          $query=  mysqli_query($con,"UPDATE investigation_entry SET due_status=1 WHERE bill_number='".$bill."'");
      }
     else
     {
         $query1=  mysqli_query($con,"INSERT INTO `due_amounts`(`date_time`, `opd_type`, `bill_number`, `totalamount`) VALUES ('".$date."','".$type."','".$bill."','".$amount."')");
     }
    
    
   
    header("location:total_investigations.php");
    exit;
}
else if($type=="pro")
{
   
     $query2=  mysqli_query($con,"SELECT sum(procedure_fees) FROM procedure_entry WHERE bill_number='".$bill."'");
    $row2=  mysqli_fetch_array($query2);
    $amount=$row2['sum(procedure_fees)'];
    
     $query3=  mysqli_query($con,"SELECT * FROM procedure_entry WHERE bill_number='".$bill."' && date LIKE '$date1%'");
     if(mysqli_num_rows($query3)>0)
     {
         $query=  mysqli_query($con,"UPDATE procedure_entry SET due_status=1 WHERE bill_number='".$bill."'"); 
     }
     else
     {
        $query1=  mysqli_query($con,"INSERT INTO `due_amounts`(`date_time`, `opd_type`, `bill_number`, `totalamount`) VALUES ('".$date."','".$type."','".$bill."','".$amount."')");
     }
   
    header("location:total_procedures.php");
    exit;
}
else if($type=="dpro")
     
{
  
      $query2=  mysqli_query($con,"SELECT sum(dental_fees) FROM procedure_dental_entry WHERE bill_number='".$bill."'");
    $row2=  mysqli_fetch_array($query2);
    $amount=$row2['sum(dental_fees)'];
     $query3=  mysqli_query($con,"SELECT * FROM procedure_dental_entry WHERE bill_number='".$bill."' && date LIKE '$date1%'");
     if(mysqli_num_rows($query3)>0)
     {
           $query=  mysqli_query($con,"UPDATE procedure_dental_entry SET due_status=1 WHERE bill_number='".$bill."'");
     }
     else
     {
       $query1=  mysqli_query($con,"INSERT INTO `due_amounts`(`date_time`, `opd_type`, `bill_number`, `totalamount`) VALUES ('".$date."','".$type."','".$bill."','".$amount."')");
     }
    
   
    header("location:total_dental_procedures.php");
    exit;
}
else if($type=="nut")
{
    
     $query2=  mysqli_query($con,"SELECT sum(amount) FROM canteen_entry WHERE bill_number='".$bill."'");
    $row2=  mysqli_fetch_array($query2);
    $amount=$row2['sum(amount)'];
      $query3=  mysqli_query($con,"SELECT * FROM canteen_entry WHERE bill_number='".$bill."' && date LIKE '$date1%'");
     if(mysqli_num_rows($query3)>0)
     {
       $query=  mysqli_query($con,"UPDATE canteen_entry SET due_status=1 WHERE bill_number='".$bill."'");  
     }
     else
     {
      $query1=  mysqli_query($con,"INSERT INTO `due_amounts`(`date_time`, `opd_type`, `bill_number`, `totalamount`) VALUES ('".$date."','".$type."','".$bill."','".$amount."')");
     }
    
    header("location:total_nutritions.php");
    exit;
}
?>