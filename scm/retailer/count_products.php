<?php
	require("../includes/config.php");
	$sql = "SELECT pro_id FROM products ORDER BY pro_id DESC LIMIT 1";
	$result = mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	echo $row[0];
?>