<?php
	require("../includes/config.php");
	session_start();
	$currentDate = date('Y-m-d');
	$order_id = $_POST['order_id'];
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!isset($_POST['distributor'])) {
			$_SESSION['error'] = "* Please choose distributor";
			header("Location:generate_invoice.php?id=$order_id");
		}
		else {
			$comment = "";
			$dist_id = $_POST['distributor'];
			if(isset($_POST['txtComment'])) {
				if(!empty($_POST['txtComment'])) {
					$comment = $_POST['txtComment'];
				}
			}
			$query_selectOrder = "SELECT * FROM orders WHERE order_id='$order_id'";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
			$row_selectOrder = mysqli_fetch_array($result_selectOrder);
			$retailer_id = $row_selectOrder['retailer_id'];
			$total_amount = $row_selectOrder['total_amount'];
			$query_selectInvoiceId = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='scm_new' AND TABLE_NAME='invoice'";
			$result_selectInvoiceId = mysqli_query($con,$query_selectInvoiceId);
			$row_selectInvoiceId = mysqli_fetch_array($result_selectInvoiceId);
			$invoice_id = $row_selectInvoiceId['AUTO_INCREMENT'];
			$queryInsertInvoice = "INSERT INTO invoice(order_id,retailer_id,dist_id,date,total_amount,comments) VALUES('$order_id','$retailer_id','$dist_id','$currentDate','$total_amount','$comment')";
			if(mysqli_query($con,$queryInsertInvoice)) {
				$query_selectOrderItems = "SELECT * FROM order_items WHERE order_id='$order_id'";
				$result_selectOrderItems = mysqli_query($con,$query_selectOrderItems);
				while($row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems)) {
					$product_id = $row_selectOrderItems['pro_id'];
					$quantity = $row_selectOrderItems['quantity'];
					$queryInsertInvoiceItems = "INSERT INTO invoice_items(invoice_id,product_id,quantity) VALUES('$invoice_id','$product_id','$quantity')";
					$result = mysqli_query($con,$queryInsertInvoiceItems);
				}
				if($result == 1) {
					$queryUpdateStatus = "UPDATE orders SET status=1 WHERE order_id='$order_id'";
					if(mysqli_query($con,$queryUpdateStatus)) {
						echo "<script> alert(\"Invoice Generated Successfully\"); </script>";
						header("Refresh:0;url=view_invoice_items.php?id=$invoice_id");
					}
					else {
						echo "Can not update the status of order.";
					}
				}
			}
			else {
				echo "There was some issue";
			}
		}
	}
?>