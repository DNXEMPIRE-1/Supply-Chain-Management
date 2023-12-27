<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['retailer_login']) || isset($_SESSION['admin_login'])) {
			$query_selectProducts = "SELECT * FROM products";
			$result_selectProducts = mysqli_query($con,$query_selectProducts);
	}
	else {
		header('Location:../index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Order Items </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Order Items</h1>
		<form action="insert_man_order.php" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> ID </th>
				<th> Name </th>
				<th> Price </th>
				<th> Available </th>
				<th> Quantity </th>
				<th> Price </th>
			</tr>
			<?php $i=1; while($row_selectProducts = mysqli_fetch_array($result_selectProducts)) { ?>
			<tr>
				<td> <?php echo $row_selectProducts['pro_id']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_name']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_price']; ?> </td>
				<td> <?php if($row_selectProducts['quantity'] == NULL){ echo "N/A";} else {echo $row_selectProducts['quantity'];} ?> </td>
				<td> <input type="text" class="quantity" id="<?php echo $row_selectProducts['pro_id']; ?>" name="<?php echo "txtQuantity".$row_selectProducts['pro_id']; ?>" /> </td>
				<td> <div id="<?php echo "totalPrice".$row_selectProducts['pro_id']; ?>"></div> </td>
			</tr>
			<?php $i++; } ?>
			<tr>
				<td colspan="5" style="text-align:right;"> Total Price: </td>
				<td> <input type="text" size="10" id="txtFinalAmount" name="total_price" readonly="readonly" value="" /> </td>
			</tr>
		</table>
		<input id="btnSubmit" type="submit" value="Post Order" class="submit_button" />
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
	<script type="text/javascript" src="../includes/jquery.js"> </script>
	<script type="text/javascript" src="order_items.js"> </script>
</body>
</html>