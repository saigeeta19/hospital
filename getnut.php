<script>
    $(function(){
       $( "input[name*='nut_list']" ).datetimepicker(); 
    $("input[name*='nut_list']" ).datetimepicker("option", "dateFormat", "dd-mm-yy");
     
    });
</script>
<?php
include 'connection.php';
$patient_ip_id=$_POST['patient_ip_id'];

?>
<?php
            $inv=mysqli_query($con2,"SELECT * FROM je_products WHERE mode='admitpat' ORDER BY name");
			
             echo "<table width='100%'><tr>"; 
              
               while($inv1 = mysqli_fetch_assoc($inv)) 
               {
                   $nut_name=$inv1['name'];
                 $inv2=mysqli_query($con,"SELECT * FROM nutrition_indents WHERE patient_ip_id='".$patient_ip_id."' && nutri_name='".$nut_name."' && end_time=''");
                 if(mysqli_num_rows($inv2)>0)
                 {
                     $inv3=mysqli_fetch_array($inv2);
                     $strt_equ=$inv3['start_time'];
                     ?>
                     <script>
                     var strt="<?php echo $strt_equ; ?>";
                     var nuname="<?php echo $nut_name; ?>";
                     
                        $(function(){
                           $('#'+nuname).datetimepicker( "setDate", strt); 
                        });
                         
                    </script>
                                        
                     <?php
                      echo "<tr><td>".$inv1['name']."<input type='hidden' name='nutrition_name[]' value='".$inv1['name']."' /></td>"; 
                  echo "<td>Start&nbsp;<input type='text' name='nut_list[]' id='".$nut_name."' /></td>";
                  echo "<td>End &nbsp;<input type='text' name='nut_list1[]' /></td><td></td>";
                  echo "</tr>";
                 
                  
                   
                 }
                    else {
                	    echo "<tr><td>".$inv1['name']."<input type='hidden' name='nutrition_name[]' value='".$inv1['name']."' /></td>"; 
                  echo "<td>Start&nbsp;<input type='text' name='nut_list[]' /></td>";
                  echo "<td>End &nbsp;<input type='text' name='nut_list1[]' /></td><td></td>";
                  echo "</tr>";
      
                }
                    } 
             echo "</table>";  
?>
