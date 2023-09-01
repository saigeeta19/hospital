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
<script src="js/script.js"></script>
<script>

	$(function() {
		$(".mes").hide();
		
	$( "#app_date" ).datetimepicker();	
	$( "#app_date" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
	
	
$( "#check_name" ).click(function(){
	var patient_ip_id=$("#patient_ip_id").val();
	
           	   	     $.ajax({
           	   	     	type:"post",
           	   	     	url:"getuid.php",
           	   	     	data:"patient_ip_id="+patient_ip_id,
           	   	     	success:function(data){
                              $("#patient_id").html(data);
           	   	     	}
           	   	     });
           	   	     $.ajax({
                        type:"post",
                        url:"getequ.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#equipments").html(data);
                             
               
                          
                        }
                     });
                     
                     $.ajax({
                        type:"post",
                        url:"getnut.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                              $("#nutritions").html(data);
                             
               
                          
                        }
                     });
                     
                     
                     $.ajax({
                        type:"post",
                        url:"view_patient_status.php",
                        data:"patient_ip_id="+patient_ip_id,
                        success:function(data){
                             
                               if(data=="admitted")
                                {             
                                 $(".dis").show();
                                 $(".mes").hide();
                                }
                                 else if(data=="discharged")
                                 {
                                     $(".dis").hide();
                                     $(".mes").show();
                                 }
                        }
                     });
});

});


</script>

<?php
if($_REQUEST['submit'])
{
	$patient_ip_id=$_REQUEST['patient_ip_id'];
	$patient_id=$_REQUEST['patient_id'];
	$date=$_REQUEST['app_date'];
	
	foreach($_REQUEST['inv_list'] as $invlist)
	{
		$inves_name=$invlist;
		$query=mysqli_query($con,"SELECT * FROM investigations_list WHERE investigation_name='".$inves_name."'");
		$query1=mysqli_fetch_array($query);
		$amount=$query1['investigation_amount'];
		$sql=mysqli_query($con,"INSERT INTO investigations_indents(date,patient_ip_id,investigation_name,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$inves_name."','".$amount."','".$entry_person."')");
	}
	foreach($_REQUEST['doc_list'] as $doclist)
	{
		$doctor_name=$doclist;
        $query=mysqli_query("SELECT * FROM patient_admission WHERE patient_ip_id='".$patient_ip_id."' && status='admitted'",$con);
        $query1=mysqli_fetch_array($query);
        $category=$query1['category'];
        $ward_name=$query1['ward_name'];
        $query2=mysqli_query($con,"SELECT * FROM doctor_ipd_consultation WHERE category_name='".$category."' && ward_name='".$ward_name."' && doctor_name='".$doctor_name."'");
        $query3=mysqli_fetch_array($query2);
        $amount=$query3['consultation_amount'];
		$sql=mysqli_query($con,"INSERT INTO consultations_indents(date,patient_ip_id,doctor_name,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$doctor_name."','".$amount."','".$entry_person."')");
	}
       
	foreach($_REQUEST['pro_list'] as $prolist)
	{
		$proce_name=$prolist;
		$query=mysqli_query($con,"SELECT * FROM procedures_list WHERE procedure_name='".$proce_name."'");
		$query1=mysqli_fetch_array($query);
		$amount=$query1['procedure_amount'];
		$sql=mysqli_query($con,"INSERT INTO procedures_indents(date,patient_ip_id,procedure_name,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$proce_name."','".$amount."','".$entry_person."')");
	}
   
   
	$mi = new MultipleIterator();
	$mi->attachIterator(new ArrayIterator($_REQUEST['equip_name']));
   $mi->attachIterator(new ArrayIterator($_REQUEST['equ_list']));
   $mi->attachIterator(new ArrayIterator($_REQUEST['equ_list1']));
   $newArray = array();
   foreach ( $mi as $value ) {
   	$remainder=0;$quotient=0;$total_hours=0;
    list($equip, $eq_start, $eq_end) = $value;
   if($eq_start!="")
   {
       
      if($eq_end=="")
       {
       	 $amount="";
           $eq_end1=date("d-m-Y H:i:s");
          $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end1 );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
       $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
       $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;
	     if($equip=="INFUSION-PUMP")
      {
          
          $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
      $rem=ceil($total_hours/24);
      $amount=$rem*$amount_std;
      }
       
            $sql1=mysqli_query($con,"SELECT * FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."' && equipments_name='".$equip."' && end_time=''");
              if(mysqli_num_rows($sql1)>0)
              {
              	$sql56=mysqli_fetch_array($sql1);
				$sqlid=$sql56['id'];
                $sql=mysqli_query($con,"UPDATE medical_equipments SET start_time='".$eq_start."', end_time='".$eq_end."',total_hours='".$total_hours."',amount='".$amount."' WHERE id='".$sqlid."'");
        
              }
              else {
                 $eq_end="";
          
          
        
           $sql=mysqli_query($con,"INSERT INTO medical_equipments(date,patient_ip_id,equipments_name,start_time,end_time,total_hours,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$equip."','".$eq_start."','".$eq_end."','".$total_hours."','".$amount."','".$entry_person."')");
       
              }
                   
       }    
       
      else
          {
              
              $sql1=mysqli_query($con,"SELECT * FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."' && equipments_name='".$equip."' && end_time=''");
              if(mysqli_num_rows($sql1)>0)
              {
                  $sql2=mysqli_fetch_array($sql1);
                  $eid=$sql2['id'];
                  $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
      $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
       $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;
      
      if($equip=="INFUSION-PUMP")
      {
         
          $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
      $rem=ceil($total_hours/24);
      $amount=$rem*$amount_std;
      }
     
    $sql=mysqli_query($con,"UPDATE medical_equipments SET start_time='".$eq_start."', end_time='".$eq_end."',total_hours='".$total_hours."',amount='".$amount."' WHERE id='".$eid."'");
         
              }
              else {
                
                 $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
      $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
       $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;
      if($equip=="INFUSION-PUMP")
      {
         
          $query=mysqli_query($con,"SELECT * FROM equipments_list WHERE equipment_name='".$equip."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['equipment_price'];
      $rem=ceil($total_hours/24);
      $amount=$rem*$amount_std;
      }
      
    $sql=mysqli_query($con,"INSERT INTO medical_equipments(date,patient_ip_id,equipments_name,start_time,end_time,total_hours,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$equip."','".$eq_start."','".$eq_end."','".$total_hours."','".$amount."','".$entry_person."')");
    
           
              }
                  
          } 
	  }
}

//nutritions

$mi = new MultipleIterator();
	$mi->attachIterator(new ArrayIterator($_REQUEST['nutrition_name']));
   $mi->attachIterator(new ArrayIterator($_REQUEST['nut_list']));
   $mi->attachIterator(new ArrayIterator($_REQUEST['nut_list1']));
   $newArray = array();
   foreach ( $mi as $value ) {
   	$remainder=0;$quotient=0;$total_hours=0;
    list($nutri, $eq_start, $eq_end) = $value;
    
   if($eq_start!="")
   {
       
      if($eq_end=="")
       {
       	 $amount="";
           $eq_end1=date("d-m-Y H:i:s");
          $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end1 );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
       $query=mysqli_query($con2,"SELECT * FROM je_products WHERE name='".$nutri."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['price'];
     /*  $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;*/
      
       $remainder=$total_hours % 24;
	  $quotient=($total_hours-$remainder)/24;
	  if($remainder==0)
	  {
	  	$amount=$quotient*$amount_std;
	  }
	  else
	  	{
	  		$amount=$quotient*$amount_std+$amount_std;		
	  	}
	  
	  
       
            $sql1=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."' && nutri_name='".$nutri."' && end_time=''");
              if(mysqli_num_rows($sql1)>0)
              {
              	$sql56=mysqli_fetch_array($sql1);
				$sqlid=$sql56['id'];
                $sql=mysqli_query($con,"UPDATE nutrition_indents SET start_time='".$eq_start."', end_time='".$eq_end."',total_hours='".$total_hours."',amount='".$amount."' WHERE id='".$sqlid."'");
        
              }
              else {
                 $eq_end="";
          
          
        
           $sql=mysqli_query($con,"INSERT INTO nutrition_indents(date,patient_ip_id,nutri_name,start_time,end_time,total_hours,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$nutri."','".$eq_start."','".$eq_end."','".$total_hours."','".$amount."','".$entry_person."')");
       
              }
                   
       }    
       
      else
          {
              
              $sql1=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."' && nutri_name='".$nutri."' && end_time=''");
              if(mysqli_num_rows($sql1)>0)
              {
                  $sql2=mysqli_fetch_array($sql1);
                  $eid=$sql2['id'];
                  $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
      $query=mysqli_query($con2,"SELECT * FROM je_products WHERE name='".$nutri."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['price'];
      /* $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;*/
      
      $remainder=$total_hours % 24;
	  $quotient=($total_hours-$remainder)/24;
	 if($remainder==0)
	  {
	  	$amount=$quotient*$amount_std;
	  }
	  else
	  	{
	  		$amount=$quotient*$amount_std+$amount_std;		
	  	}
	  
      
      
     
    $sql=mysqli_query($con,"UPDATE nutrition_indents SET start_time='".$eq_start."', end_time='".$eq_end."',total_hours='".$total_hours."',amount='".$amount."' WHERE id='".$eid."'");
         
              }
              else {
                
                 $t1 = StrToTime ( $eq_start );
      $t2= StrToTime ( $eq_end );
      $diff = $t2 - $t1;
      $total_hours = $diff / ( 60 * 60 );
      $total_hours=round($total_hours);
      $query=mysqli_query($con2,"SELECT * FROM je_products WHERE name='".$nutri."'");
      $query1=mysqli_fetch_array($query);
      $amount_std=$query1['price'];
     /*  $remainder = $total_hours % 12;
     
      $quotient = ($total_hours - $remainder) / 12;
      
      $amount=$quotient*$amount_std/2+$amount_std/2;*/
       $remainder=$total_hours % 24;
	  $quotient=($total_hours-$remainder)/24;
	 if($remainder==0)
	  {
	  	$amount=$quotient*$amount_std;
	  }
	  else
	  	{
	  		$amount=$quotient*$amount_std+$amount_std;		
	  	}
      
      
    $sql=mysqli_query($con,"INSERT INTO nutrition_indents(date,patient_ip_id,nutri_name,start_time,end_time,total_hours,amount,entry_person) VALUES ('".$date."','".$patient_ip_id."','".$nutri."','".$eq_start."','".$eq_end."','".$total_hours."','".$amount."','".$entry_person."')");
    
           
              }
                  
          } 
	  }
}









    
	
	 if($sql)
    {
      
       echo "<script>alert('Indents Entry successfull');</script>";
       
    }
    else 
    {
       echo "<script>alert('Please Try Again!!');</script>";
    }
	
}
?>
<?php

?>
<form name="add_ward"  method="post">
		<tr>
		    <td colspan="4"><p id="panel">Patient Indent Entry</p></td>
		</tr>
		<table id="table"  name="t1" border="4" width="100%">
			
			 <tr>
				<td>Enter IP number of patient</td>
          	    <td><input type="text" name="patient_ip_id" id="patient_ip_id"/>&nbsp;<input type="button" id="check_name" value="Check" /></td>
          	    <td>Patient UID / Name</td>
          	    <td><select name="patient_id" id="patient_id" required="required">
          	    	
          	    </select></td>
			</tr>
			<tr>
			    <td>Select Date</td>
			    <td><input type="text" id="app_date" name="app_date" required="required" /></td>
			    <td></td>
			    <td></td>
			</tr>
			
		</table>
		<div class="dis">
			<ul id="tabs">
		    <li><a href="#investigation">Investigations</a></li>
		    <li><a href="#procedure">Procedures</a></li>
		    <li><a href="#consultation">Consultation</a></li>
		    <li><a href="#equipments">Equipments</a></li>
                    <li><a href="#nutritions">Nutrition</a></li>
		    </ul>
		       
		<div id="investigation" class="tab-section">
			<?php
			$inv=mysqli_query($con,"SELECT * FROM investigations_list ORDER BY investigation_name");
			 echo "<table width='100%'><tr>"; 
			   $x = 0; 
			   while($inv1 = mysqli_fetch_assoc($inv)) 
			   { 
			       echo "<td><input type='checkbox' name='inv_list[]' id='inv_list[]' value='".$inv1['investigation_name']."' />".$inv1['investigation_name']."</td>"; 
			       $x++; 
			       if ($x % 3 == 0) { echo "<tr>"; } 
			   } 
		     echo "</tr></table>";  
			?>
			
		</div>
		
		<div id="procedure" class="tab-section">
			<?php
			$inv=mysqli_query($con,"SELECT * FROM procedures_list ORDER BY procedure_name");
			 echo "<table width='100%'><tr>"; 
			   $x = 0; 
			   while($inv1 = mysqli_fetch_assoc($inv)) 
			   { 
			       echo "<td><input type='checkbox' name='pro_list[]' id='pro_list[]' value='".$inv1['procedure_name']."' />".$inv1['procedure_name']."</td>"; 
			       $x++; 
			       if ($x % 3 == 0) { echo "<tr>"; } 
			   } 
		     echo "</tr></table>";  
			?>
		</div>
		
		<div id="consultation" class="tab-section">
			<?php
			$inv=mysqli_query($con,"SELECT * FROM doctor_list ORDER BY doctor_name");
			 echo "<table width='100%'><tr>"; 
			   $x = 1; 
			   while($inv1 = mysqli_fetch_assoc($inv)) 
			   { 
			       echo "<td><input type='checkbox' name='doc_list[]' id='doc_list[]' value='".$inv1['doctor_name']."' />".$inv1['doctor_name']."</td>"; 
			       $x++; 
			       if ($x % 1 == 0) { echo "</tr><tr>"; } 
			   } 
		     echo "</tr></table>";  
			?>
		</div>
		<div id="equipments" class="tab-section">
			<?php
			
			$inv=mysqli_query($con,"SELECT * FROM equipments_list ORDER BY equipment_name");
			 echo "<table width='100%'><tr>"; 
			  
			   while($inv1 = mysqli_fetch_assoc($inv)) 
			   {
			       $equ_name=$inv1['equipment_name']; 
			       echo "<tr><td>".$inv1['equipment_name']."<input type='hidden' name='equip_name[]' value='".$inv1['equipment_name']."' /></td>"; 
			      echo "<td>Start&nbsp;<input type='text' name='equ_list[]' id='".$equ_name."' /></td>";
				  echo "<td>End &nbsp;<input type='text' name='equ_list1[]' /></td><td></td>";
				  echo "</tr>";
			   } 
		     echo "</table>";  
			?>
	    </div>
                    <div id="nutritions" class="tab-section">
                    	
                    	<?php
			
			$inv45=mysqli_query($con2,"SELECT * FROM je_products WHERE mode='admitpat' ORDER BY name");
			
			 echo "<table width='100%'><tr>"; 
			  
			   while($inv145 = mysqli_fetch_assoc($inv45)) 
			   {
			       $nut_name=$inv145['name']; 
			       echo "<tr><td>".$inv145['name']."<input type='hidden' name='nut_name[]' value='".$inv145['name']."' /></td>"; 
			      echo "<td>Start&nbsp;<input type='text' name='nut_list[]' id='".$nut_name."' /></td>";
				  echo "<td>End &nbsp;<input type='text' name='nut_list1[]' /></td><td></td>";
				  echo "</tr>";
			   } 
		     echo "</table>";  
			?>
			
                    	
                    	
                       
                    </div>
		
		<table width="100%">	
			
			<tr>
				<td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /></p></td>
			</tr>
		
		</table>
		</div>
		<div class="mes" style="text-align: center; padding-top:20px; color:#930000;">
			Please enter correct IP number.
		</div>
		
</form>
<?php include 'footer.php'; ?>
