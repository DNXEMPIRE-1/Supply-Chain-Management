<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login']) || isset($_SESSION['admin_login']) || isset($_SESSION['retailer_login'])) {
			$order_id = $_GET['id'];
			$query_selectOrderItems = "SELECT *,order_items.quantity AS quantity FROM orders,order_items,products WHERE order_items.order_id='$order_id' AND order_items.pro_id=products.pro_id AND order_items.order_id=orders.order_id";
			$result_selectOrderItems = mysqli_query($con,$query_selectOrderItems);
			$query_selectOrder = "SELECT date,status FROM orders WHERE order_id='$order_id'";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
			$row_selectOrder = mysqli_fetch_array($result_selectOrder);
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
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Order Details</h1>
		<table class="table_infoFormat">
		<tr>
			<td> Order No: </td>
			<td> <?php echo $order_id; ?> </td>
		</tr>
		<tr>
			<td> Status: </td>
			<td>
			<?php
				if($row_selectOrder['status'] == 0) {
					echo "Pending";
				}
				else {
					echo "Completed";
				}
			?>
			</td>
		</tr>
		<tr>
			<td> Date: </td>
			<td> <?php echo date("d-m-Y",strtotime($row_selectOrder['date'])); ?> </td>
		</tr>
		</table>
		<form action="" method="POST" class="form">
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
				<td> <?php echo $row_selectOrderItems['quantity']; ?> </td>
				<td> <?php echo $row_selectOrderItems['quantity']*$row_selectOrderItems['pro_price']; ?> </td>
			</tr>
			<?php $i++; } ?>
			<tr style="height:40px;vertical-align:bottom;">
				<td colspan="3" style="text-align:right;"> Total Amount: </td>
				<td>
				<?php
					mysqli_data_seek($result_selectOrderItems,0);
					$row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems);
					echo $row_selectOrderItems['total_amount'];
				?>
				</td>
			</tr>
		</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>