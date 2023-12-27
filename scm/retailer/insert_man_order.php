<?php
	session_start();
	require("../includes/config.php");
	$currentDate = date('Y-m-d');
	$retailer_id = $_SESSION['retailer_id'];
	$sql = "SELECT pro_id FROM products ORDER BY pro_id DESC LIMIT 1";
	$result = mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	$total_products = $row[0];
	
	$quantityArray = array();
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!empty($_POST['total_price'])){
			$total_price = $_POST['total_price'];
			for($i=1;$i<=$total_products;$i++){
				$quantityArray[$i] = $_POST['txtQuantity'.$i];
			}
		}
		else{
			echo "Total price not recieved.";
		}
	}
	$query_insertOrder = "INSERT INTO orders(date,retailer_id,total_amount) VALUES('$currentDate','$retailer_id','$total_price')";
	if($con->query($query_insertOrder) === true){
		$sql_getOrderId = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
		$result_getOrderId = mysqli_query($con,$sql_getOrderId);
		$row_getOrderId =mysqli_fetch_array($result_getOrderId);
		$order_id = $row_getOrderId[0];
		foreach($quantityArray as $key_productId => $value_quantity){
			if($value_quantity != NULL){
				$query_insertOrderItems = "INSERT INTO order_items(order_id,pro_id,quantity) VALUES('$order_id','$key_productId','$value_quantity')";
				if($con->query($query_insertOrderItems) === true){
				}
				else {
					echo "There was some error.";
				}
			}
		}
	}
	else{
		echo "There was some error posting your order.";
	}
	header('Location:view_my_orders.php?status=redirect');
?>