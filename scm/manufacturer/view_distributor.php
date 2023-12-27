<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		if($_SESSION['manufacturer_login'] == true) {
			$query_selectDistributor = "SELECT * FROM distributor";
			$result_selectDistributor = mysqli_query($con,$query_selectDistributor);
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
	<title> View Distributor </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>View Distributor</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th>Sr. No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
			</tr>
			<?php $i=1; while($row_selectDistributor = mysqli_fetch_array($result_selectDistributor)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_name']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_email']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_phone']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_address']; ?> </td>
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