<script>
    $(function(){
       $( "input[name*='equ_list']" ).datetimepicker(); 
    $("input[name*='equ_list']" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
     
    });
</script>
<?php
include 'connection.php';
$patient_ip_id=$_POST['patient_ip_id'];

?>
<?php
            $inv=mysqli_query($con,"SELECT * FROM equipments_list ORDER BY equipment_name");
             echo "<table width='100%'><tr>"; 
              
               while($inv1 = mysqli_fetch_assoc($inv)) 
               {
                   $equ_name=$inv1['equipment_name'];
                 $inv2=mysqli_query($con,"SELECT * FROM medical_equipments WHERE patient_ip_id='".$patient_ip_id."' && equipments_name='".$equ_name."' && end_time=''");
                 if(mysqli_num_rows($inv2)>0)
                 {
                     $inv3=mysqli_fetch_array($inv2);
                     $strt_equ=$inv3['start_time'];
                     ?>
                     <script>
                     var strt="<?php echo $strt_equ; ?>";
                     var eqname="<?php echo $equ_name; ?>";
                     
                        $(function(){
                           $('#'+eqname).datetimepicker( "setDate", strt); 
                        });
                         
                    </script>
                                        
                     <?php
                      echo "<tr><td>".$inv1['equipment_name']."<input type='hidden' name='equip_name[]' value='".$inv1['equipment_name']."' /></td>"; 
                  echo "<td>Start&nbsp;<input type='text' name='equ_list[]' id='".$equ_name."' /></td>";
                  echo "<td>End &nbsp;<input type='text' name='equ_list1[]' /></td><td></td>";
                  echo "</tr>";
                 
                  
                   
                 }
                    else {
  
              	    echo "<tr><td>".$inv1['equipment_name']."<input type='hidden' name='equip_name[]' value='".$inv1['equipment_name']."' /></td>"; 
                  echo "<td>Start&nbsp;<input type='text' name='equ_list[]' id='".$equ_name."' /></td>";
                  echo "<td>End &nbsp;<input type='text' name='equ_list1[]' /></td><td></td>";
                  echo "</tr>";
      
                }
                    } 
             echo "</table>";  
?>
