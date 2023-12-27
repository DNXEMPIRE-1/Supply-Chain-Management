<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$query_selectRetailer = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id";
			$result_selectRetailer = mysqli_query($con,$query_selectRetailer);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['chkId'])) {
					$chkId = $_POST['chkId'];
					foreach($chkId as $id) {
						$query_deleteRetailer = "DELETE FROM retailer WHERE retailer_id='$id'";
						$result = mysqli_query($con,$query_deleteRetailer);
					}
					if(!$result) {
						echo "<script> alert(\"There was some problems deleting retailer\"); </script>";
						header('Refresh:0');
					}
					else {
						echo "<script> alert(\"Retailer Deleted Successfully\"); </script>";
						header('Refresh:0');
					}
				}
			}
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
	<script language="JavaScript">
	function toggle(source) {
		checkboxes = document.getElementsByName('chkId[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}
	</script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>View Retailer</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> <input type="checkbox" onClick="toggle(this)" /> </th>
				<th>Sr. No.</th>
				<th>Username</th>
				<th>Area Code</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Address</th>
				<th> Edit </th>
			</tr>
			<?php $i=1; while($row_selectRetailer = mysqli_fetch_array($result_selectRetailer)) { ?>
			<tr>
				<td> <input type="checkbox" name="chkId[]" value="<?php echo $row_selectRetailer['retailer_id']; ?>" /> </td>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectRetailer['username']; ?> </td>
				<td> <?php echo $row_selectRetailer['area_code']; ?> </td>
				<td> <?php echo $row_selectRetailer['phone']; ?> </td>
				<td> <?php echo $row_selectRetailer['email']; ?> </td>
				<td> <?php echo $row_selectRetailer['address']; ?> </td>
				<td> <a href="edit_retailer.php?id=<?php echo $row_selectRetailer['retailer_id']; ?>"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		<input type="submit" value="Delete" class="submit_button"/>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>