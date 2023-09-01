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
    <?php
    if($_POST['submit'])
    {
     
       $ntitle=$_REQUEST['ntitle'];
       $name=$_REQUEST['fname'];
       $coname=$_REQUEST['co_name'];
       $gender=$_REQUEST['gender'];
       $address=$_REQUEST['address'];
       $phno=$_REQUEST['phno'];
       $date=date("d-m-Y H:i:s");
       
     
       
         $sql=mysqli_query($con,"SELECT max(uid) FROM patients",);
          $sql2=mysqli_fetch_array($sql);
          $uid=$sql2['max(uid)'];
          if($uid=="NULL")
          {
               $uid=1;
          }
          $uid=$uid+1;
          $sql3=mysqli_query($con,"INSERT INTO patients(uid,date,ntitle,name,co_name,gender,address,phone_number,entry_person) 
      VALUES ('".$uid."','".$date."','".$ntitle."','".$name."','".$coname."','".$gender."','".$address."','".$phno."','".$entry_person."')");
$id=$uid;
  if($sql3)
  {
         echo '<script>$("<div title=\'Registration Successfull\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Patient registered successfully. <br/>UID Number is: '.$id.'. <br/>Please note down the UID for further reference.</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>'; 
         
    
      }
      
      else
         {
            echo '<script>$("<div title=\'Failure Message\' style=\'font-size:17px;background-color: #d68c43;color:#000000;   \'>Something went wrong during registration. <br/>Please try again!!!</div>").dialog({
                 resizable: false,
                 modal: true,
                 height: 300,
                 width: 400,
                 buttons: {
                 "Ok": function() 
                 {
                   $( this ).dialog( "close" );
                 }
               }
         });</script>';   
        }
        }

?>     
    <?php include 'sidebar.php' ?>
    <form name="patient_register" method="post" >
     <tr>
            <td colspan="5"><p id="panel">UID for IP</p></td>
            </tr>
        
        
        
        <table id="table1"  name="t1" border="2" width="100%" >
           
            <tr>
            <td colspan="4" id="table_head" >Personal Details</td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type="radio" name="ntitle" id="Miss" value="Miss" required="required"/>Miss<input type="radio" name="ntitle" id="Mr" value="Mr" required="required"/>Mr<input type="radio" name="ntitle" id="Mrs" value="Mrs" required="required" />Mrs<input type="radio" name="ntitle" id="Master" value="Master" required="required" />Master
                    <input type="radio" name="ntitle" id="Baby_of" value="Baby_of" required="required" />Baby of<input type="radio" name="ntitle" id="Baby" value="Baby" required="required" />Baby</td>
                <td>Name</td>
                <td><input type="text" name="fname" id="fname" required="required" /></td>
                
            </tr>
            <tr>
                 <td>C/O Name</td>
                <td><input type="text" name="co_name" id="co_name" required="required" /> </td>
                <td>Gender</td>
                <td><input type="radio" name="gender" id="MALE" value="MALE" required="required" />Male<input type="radio" name="gender" id="FEMALE" value="FEMALE" required="required" />Female<input type="radio" name="gender" id="OTHERS" value="OTHERS" required="required"/>Others</td>
              
            </tr>
            <tr>
                  <td>Phone Number</td>
                <td><input type="text" name="phno" id="phno" required="required" /> </td>
                <td>Address</td>
                <td><textarea name="address" id="address" required="required"></textarea> </td>
                
            </tr>
           
            <tr>
                <td colspan="4"><p id="button" align="center"><input type="submit" name="submit" value="Save" /><input type="reset" name="reset" /></p></td>
            </tr>
        </table>
        
        
    </form>
        
    <?php include 'footer.php'; ?>
    
