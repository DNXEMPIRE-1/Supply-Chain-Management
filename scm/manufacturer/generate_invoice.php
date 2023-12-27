<?php
	require("../includes/config.php");
	session_start();
	$currentDate = date('Y-m-d');
	if(isset($_SESSION['manufacturer_login'])) {
		if(isset($_SESSION['manufacturer_login']) == true) {
			$order_id = $_GET['id'];
			$querySelectDistributor = "SELECT dist_id,dist_name FROM distributor";
			$resultDistributor = mysqli_query($con,$querySelectDistributor);
			$query_selectOrderItems = "SELECT *,order_items.quantity AS q FROM orders,order_items,products WHERE order_items.order_id='$order_id' AND order_items.pro_id=products.pro_id AND order_items.order_id=orders.order_id";
			$result_selectOrderItems = mysqli_query($con,$query_selectOrderItems);
			$query_selectOrder = "SELECT date,status FROM orders WHERE order_id='$order_id'";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
			$row_selectOrder = mysqli_fetch_array($result_selectOrder);
			$query_selectInvoiceId = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='scm_new' AND TABLE_NAME='invoice'";
			$result_selectInvoiceId = mysqli_query($con,$query_selectInvoiceId);
			$row_selectInvoiceId = mysqli_fetch_array($result_selectInvoiceId);
		}
		else {
			header('Location:../index.php');
		}
	}
	else {
		header('Location:../index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> View Orders </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Invoice Summary</h1>
		<table class="table_infoFormat">
		<tr>
			<td> Invoice No: </td>
			<td> <?php echo $row_selectInvoiceId['AUTO_INCREMENT']; ?> </td>
		</tr>
		<tr>
			<td> Invoice Date: </td>
			<td> <?php echo date('d-m-Y'); ?> </td>
		</tr>
		<tr>
			<td> Order No: </td>
			<td> <?php echo $order_id; ?> </td>
		</tr>
		<tr>
			<td> Order Date: </td>
			<td> <?php echo date("d-m-Y",strtotime($row_selectOrder['date'])); ?> </td>
		</tr>
		</table>
		<form action="insert_invoice.php" method="POST" class="form">
		<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
		<table class="table_invoiceFormat">
			<tr>
				<th> Products </th>
				<th> Unit Price </th>
				<th> Quantity </th>
				<th> Amount </th>
			</tr>
			<?php $i=1; while($row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems)) { ?>
			<tr>
				<td> <?php echo $row_selectOrderItems['pro_name']; ?> </td>
				<td> <?php echo $row_selectOrderItems['pro_price']; ?> </td>
				<td> <?php echo $row_selectOrderItems['q']; ?> </td>
				<td> <?php echo $row_selectOrderItems['q']*$row_selectOrderItems['pro_price']; ?> </td>
			</tr>
			<?php $i++; } ?>
			<tr style="height:40px;vertical-align:bottom;">
				<td colspan="3" style="text-align:right;"> Grand Total: </td>
				<td>
				<?php
					mysqli_data_seek($result_selectOrderItems,0);
					$row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems);
					echo $row_selectOrderItems['total_amount'];
				?>
				</td>
			</tr>
		</table>
			<br/>
			Ship via: &nbsp;&nbsp;&nbsp;&nbsp;<select name="distributor">
				<option value="" disabled selected>--- Select Distributor ---</option>
				<?php while($rowSelectDistributor = mysqli_fetch_array($resultDistributor)) { ?>
				<option value="<?php echo $rowSelectDistributor['dist_id']; ?>"> <?php echo $rowSelectDistributor['dist_name']; ?> </option>
				<?php } ?>
			</select> <br/>
			<br/>
			comments: <textarea maxlength="400" name="txtComment" rows="5" cols="30"></textarea>
			<br/>
			<input type="submit" value="Generate Invoice" class="submit_button" />
			<span class="error_message">
			<?php
				if(isset($_SESSION['error'])) {
					echo $_SESSION['error'];
					unset($_SESSION['error']);
				}
			?>
			</span>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>