<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		if($_SESSION['manufacturer_login'] == true) {
			$query_selectRetailer = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id";
			$result_selectRetailer = mysqli_query($con,$query_selectRetailer);
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
	<title> View Retailer </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>View Retailer</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th>Sr. No.</th>
				<th>Username</th>
				<th>Area Code</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Address</th>
			</tr>
			<?php $i=1; while($row_selectRetailer = mysqli_fetch_array($result_selectRetailer)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectRetailer['username']; ?> </td>
				<td> <?php echo $row_selectRetailer['area_code']; ?> </td>
				<td> <?php echo $row_selectRetailer['phone']; ?> </td>
				<td> <?php echo $row_selectRetailer['email']; ?> </td>
				<td> <?php echo $row_selectRetailer['address']; ?> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>