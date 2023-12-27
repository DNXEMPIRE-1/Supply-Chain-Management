<?php
	error_reporting(0);
	require("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
		if(isset($_SESSION['retailer_login'])) {
			$error = "";
			$retailer_id = $_SESSION['retailer_id'];
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['cmbFilter'])) {
					if(!empty($_POST['txtInvoiceId'])) {
						$result = validate_number($_POST['txtInvoiceId']);
						if($result == 1) {
							$invoice_id = $_POST['txtInvoiceId'];
							$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice_id='$invoice_id' AND invoice.retailer_id='$retailer_id'";
							$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
							$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
							if(empty($row_selectInvoice)){
							   $error = "* No invoice was found with this ID";
							}
							else {
								mysqli_data_seek($result_selectInvoice,0);
							}
						}
						else {
							$error = "* Invalid ID";
						}
					}
					else if(!empty($_POST['txtOrderId'])) {
						$result = validate_number($_POST['txtOrderId']);
						if($result == 1) {
							$order_id = $_POST['txtOrderId'];
							$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND order_id='$order_id' AND invoice.retailer_id='$retailer_id'";
							$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
							$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
							if(empty($row_selectInvoice)){
							   $error = "* No invoice was found with this ID";
							}
							else {
								mysqli_data_seek($result_selectInvoice,0);
							}
						}
						else {
							$error = "* Invalid ID";
						}
					}
					else if(!empty($_POST['txtDate'])) {
						$date = $_POST['txtDate'];
						$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.date='$date' AND invoice.retailer_id='$retailer_id'";
						$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
						$row_selectInvoice = mysqli_fetch_array($result_selectInvoice);
						if(empty($row_selectInvoice)){
						   $error = "* No invoice was found with the selected Date";
						}
						else {
							mysqli_data_seek($result_selectInvoice,0);
						}
						
					}
					else {
						$error = "* Please enter the data to search for.";
					}
				}
				else {
					$error = "Please choose an option to search for.";
				}
			}
			else {
				$query_selectInvoice = "SELECT * FROM invoice,retailer,area WHERE invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.retailer_id='$retailer_id'";
				$result_selectInvoice = mysqli_query($con,$query_selectInvoice);
			}
		}
		else {
			header('Location:../index.php');
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title> View Invoices </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<link rel="stylesheet" href="css/smoothness/jquery-ui.css">
	<script type="text/javascript" src="../includes/jquery.js"> </script>
	<script src="js/jquery-ui.js"></script>
	<script>
  $(function() {
    $( "#datepicker" ).datepicker({
     changeMonth:true,
     changeYear:true,
     yearRange:"-100:+0",
     dateFormat:"yy-mm-dd"
  });
  });
  </script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Invoices</h1>
		<form action="" method="POST" class="form">
		Search By: 
		<div class="input-box">
		<select name="cmbFilter" id="cmbFilter">
		<option value="" disabled selected>-- Search By --</option>
		<option value="invoiceId">  Invoice Id </option>
		<option value="orderId"> Order ID </option>
		<option value="date"> Date </option>
		</select>
		</div>
		
		<div class="input-box"> <input type="text" name="txtInvoiceId" id="txtInvoiceId" style="display:none;" /> </div>
		<div class="input-box"> <input type="text" name="txtOrderId" id="txtOrderId" style="display:none;" /> </div>
		<div class="input-box"> <input type="text" id="datepicker" name="txtDate" style="display:none;"/> </div>
		<input type="submit" class="submit_button" value="Search" /> <span class="error_message"> <?php echo $error; ?> </span>
		</form>
	
		<form action="" method="POST" class="form">
		<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> Invoice ID </th>
				<th> Date </th>
				<th> Order ID </th>
				<th> Total Amount </th>
				<th> Details </th>
			</tr>
			<?php while($row_selectInvoice = mysqli_fetch_array($result_selectInvoice)) { ?>
			<tr>
			
				<td> <?php echo $row_selectInvoice['invoice_id']; ?> </td>
				<td> <?php echo date("d-m-Y",strtotime($row_selectInvoice['date'])); ?> </td>
				<td> <?php echo $row_selectInvoice['order_id']; ?> </td>
				<td> <?php echo $row_selectInvoice['total_amount']; ?> </td>
				<td> <a href="view_invoice_items.php?id=<?php echo $row_selectInvoice['invoice_id']; ?>">Details</a> </td>
			</tr>
			<?php } ?>
		</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
	<script type="text/javascript">
		$('#cmbFilter').change(function() {
			var selected = $(this).val();
			if(selected == "invoiceId"){
				$('#txtInvoiceId').show();
				$('#txtOrderId').hide();
				$('#datepicker').hide();
			}
			else if (selected == "orderId"){
				$('#txtInvoiceId').hide();
				$('#txtOrderId').show();
				$('#datepicker').hide();
			}
			else if (selected == "date"){
				$('#txtInvoiceId').hide();
				$('#txtOrderId').hide();
				$('#datepicker').show();
			}
		});
	</script>
</body>
</html>