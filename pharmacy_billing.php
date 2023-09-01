<?php
include 'session.php';
?>
<?php
include 'connection.php';
?>
<?php
$logger = $_SESSION['logger'];
$entry = mysqli_query($con,"SELECT * FROM users WHERE username='" . $logger . "'");
$entry1 = mysqli_fetch_array($entry);
$entry_person = $entry1['name'];
$check = mysqli_query($con,"SELECT * FROM assign_rights WHERE username='" . $logger . "'");
$check1 = mysqli_fetch_array($check);

if ($right == "no") {
	header("location:unauthorized.php");
	exit ;
}
?>
<?php
include 'header.php';
?>
<script>
	$(function() {
		var checked = [];
		var checker = "";
		$("input[name*='add']").click(function() {
			var qty = $(this).closest("tr").find("input[name='qty[]']").val();
			if (qty == "") {
				alert("Please enter quantity");
				$(this).closest("tr").find("input[name='qty[]']").focus();
			} else {
				var idnum = $(this).parent().attr('id');

				$.ajax({
					type : "post",
					url : "getpharmacyamtval.php",
					data : "idnum=" + idnum + "&qty=" + qty,
					success : function(data) {
						checked.push(data);
						var count = 0;
						for (var i = 0; i < checked.length; i++) {
							count += parseFloat(checked[i]);
						}
						document.getElementById('totamt').value = count.toFixed(2);
					}
				});

				$.ajax({
					type : "post",
					url : "getpharmacyamt.php",
					data : "idnum=" + idnum + "&qty=" + qty,
					success : function(data) {
						$('.medication tr:last').before(data);

						$("input[name='remove']").click(function() {

							var price = $(this).closest("tr").find("input[name='price[]']").val();
							$(this).parent().parent().remove();
							
							var rin=checked.indexOf(price);
							if(rin != -1) {
								checked.splice(rin,1);
								
							}
							
							var count1 = Number(0);
							$('input[name^="price"]').each(function() {
								count1 += Number($(this).val());
							});
						
						
							
							document.getElementById('totamt').value = count1.toFixed(2);

						});
					}
				});
					$(this).closest("tr").find("input[name='qty[]']").val('');
			}

		});

	}); 
</script>

<script src="js/script.js"></script>
<script>
	$(document).ready(function() {
		$('#search').keyup(function() {
			searchTable($(this).val());
		});
	});

	function searchTable(inputVal) {
		var table = $('#tablepaging');
		table.find('tr').each(function(index, row) {
			var allCells = $(row).find('td');
			if (allCells.length > 0) {
				var found = false;
				allCells.each(function(index, td) {
					var regExp = new RegExp(inputVal, 'i');
					if (regExp.test($(td).text())) {
						found = true;
						return false;
					}
				});
				if (found == true)
					$(row).show();
				else
					$(row).hide();
			}
		});
	}

</script>

<?php include 'sidebar.php' ?>
<?php
if ($_POST['submit']) {
	$date = date("d-m-Y H:i:s");
	// For Bill number
	$bd = date("Y/m/");
	$sql56 = mysqli_query($con,"SELECT * FROM billnumbers WHERE bill_format='" . $bd . "'");
	if (mysqli_num_rows($sql56) > 0) {
		$sql57 = mysqli_query($con,"SELECT max(bill_number) FROM billnumbers WHERE bill_format='" . $bd . "'");
		$sql58 = mysqli_fetch_array($sql57);
		$mbill = $sql58['max(bill_number)'];
		$bn = $mbill + 1;
		$bill_number = $bd . $bn;
	} else {
		$bn = 1;
		$bill_number = $bd . $bn;
	}
	//Bill number ends here

	$mobile = $_REQUEST['mobile'];
	$status = "yes";
	$mi = new MultipleIterator();
	$mi -> attachIterator(new ArrayIterator($_REQUEST['quantity']));
	$mi -> attachIterator(new ArrayIterator($_REQUEST['idn']));
	$mi -> attachIterator(new ArrayIterator($_REQUEST['rate']));
	$mi -> attachIterator(new ArrayIterator($_REQUEST['price']));
	$mi -> attachIterator(new ArrayIterator($_REQUEST['batchnum']));
	$newArray = array();
	foreach ($mi as $value) {

		list($qty, $pname, $rate, $price, $batch) = $value;
		$sql=mysqli_query($con,"SELECT * FROM pharmacy_stock WHERE batch_num='".$batch."'");
		$sql1=mysqli_fetch_array($sql);
		$cname=$sql1['company_name'];
		//$cname=$sql1['vendor_name'];
		$exdate=$sql1['expiry_date'];
		$prate=$sql1['purchase_rate'];
		$srate=$sql1['sale_rate'];
		$exdate = date("Y-m-d", strtotime($exdate));
		

		$query = mysqli_query($con,"INSERT INTO pharmacy_billing(date_tran,bill_number,mobile_number,pharmacy_name,batch_num,quantity,rate,price,status,entry_person) VALUES ('" . $date . "','" . $bill_number . "','" . $mobile . "','" . $pname . "','" . $batch . "','" . $qty . "','" . $rate . "','" . $price . "','" . $status . "','" . $entry_person . "')");
		$query1 = mysqli_query($con,"INSERT INTO pharmacy_stock(company_name,date_time,pharmacy_name,batch_num,expiry_date,purchase_rate,sale_rate,quantity,status,entry_person)VALUES ('".$cname."','".$date."','".$pname."','".$batch."','".$exdate."','".$prate."','".$srate."','".$qty."','dispatch','".$entry_person."')");
	}

	if ($query && $query1) {

		echo "<script>alert('Entry successfull');printPage();</script>";

	} else {
		echo "<script>alert('Please Try Again!!');</script>";
	}

}
?>
<form name="opd_entry" id="pharmacy_bill" method="post">
	<tr>
		<td colspan="2">
		<p id="panel">
			Pharmacy Billing
		</p></td>
	</tr>
	<table id="table" name="t1" border="4" width="100%">
		<tr>
			<td>Enter Mobile Number</td>
			<td>
			<input type="text" name="mobile" id="mobile" required="required"/>
			</td>

		</tr>

	</table>

	<table id="table" class="medication" name="t1" border="4" width="100%">
		<script></script>
		<tr width="100%">
			<th width="20%">Item Name</th>
			<th width="20%">Distributor</th>
			<th width="20%">Batch Number</th>
			<th width="10%">Rate</th>
			<th width="10%">Quantity</th>
			<th width="10%">Amount</th>
			<th width="10%">Action</th>
		</tr>
		<tr>
			<td colspan="5">Total</td>
			<td>Rs.
			<input type="text" id="totamt" name="totamount" size="8" value="0" disabled="disabled"/>
			</td>
		</tr>
	</table>

	<table id="table" name="t1" border="4" width="100%">
		<tr>
			<td colspan="2" style="text-align: center;">
				<p id="button" >
			<input type="submit" name="submit" id="submit" value="Save" />
			<input type="reset" name="reset" id="reset" value="Clear" />
			</p>
			</td>
		</tr>

	</table>
	<ul id="tabs">
		<li>
			<a href="#investigation">Medicines</a>
		</li>
	</ul>
	<div id="investigation" class="tab-section">
		<tr >
			<td colspan="5">
			<p align="right">
				<label for="search"> <strong>Search</strong> </label>
				<input type="text" id="search" align="right"/>
				&nbsp;
			</p></td>
		</tr>
		<table id="tablepaging" class="yui" name="t1" border="4" width="100%">

			<tr>
				<th>Item</th>
				<th>Company</th>
				<th>Distributer</th>
				<th>Code</th>
				<th>Generic</th>
				<th>Rate</th>
				<th>Stocks</th>
				<th>Expiry</th>
				<th>Rack</th>
				<th>Quantity</th>
				
				<th>Action</th>
			</tr>

			<?php
			$sql3 = mysqli_query($con,"SELECT * FROM pharmacy_stock WHERE quantity>0 && DATE(`expiry_date`) > CURDATE() GROUP BY batch_num");
			while ($sql4 = mysqli_fetch_array($sql3)) {
				$bt=$sql4['batch_num'];
				$sql6 = mysqli_query($con,"SELECT sum(quantity) FROM pharmacy_stock WHERE batch_num='".$bt."' && status='entry'");
				$sql7=mysqli_fetch_array($sql6);
				$ent=$sql7['sum(quantity)'];
				
				$sql8 = mysqli_query($con,"SELECT sum(quantity) FROM pharmacy_stock WHERE batch_num='".$bt."' && status='dispatch'");
				$sql9=mysqli_fetch_array($sql8);
				$dis=$sql9['sum(quantity)'];
				
				$quant=$ent-$dis;
				$comid=$sql4['company_name'];
				$sql11=mysqli_query($con,"SELECT * FROM company_list WHERE id='".$comid."'");
				$sql12=mysqli_fetch_array($sql11);
				
				
				
				echo "
<tr>
<td>$sql4[pharmacy_name]</td>
<td>$sql12[company_name]</td>
<td></td>
<td>$sql4[batch_num]</td>
<td>$sql4[pharmacy_name]</td>
<td>$sql4[sale_rate]</td>
<td>$quant<input type='hidden' name='stoc[]' value=$quant /></td>
<td>$sql4[expiry_date]</td>
<td>$sql4[rack_number]</td>
<td style='text-align:center;'><input type='text' name='qty[]' size='3' style='background:#000;' /></td>

<td style='text-align:center;'>&nbsp;<a href='#' id='" . $sql4['id'] . "'><input type='button' name='addi' value='Add' /></a></td>
</tr>
";
			}
			?>
		</table>
	</div>
</form>

<?php
include 'footer.php';
?>
