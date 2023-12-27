<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$id = $_GET['id'];
			$query_selectUnitDetails = "SELECT * FROM unit WHERE id='$id'";
			$result_selectUnitDetails = mysqli_query($con,$query_selectUnitDetails);
			$row_selectUnitDetails = mysqli_fetch_array($result_selectUnitDetails);
			$unitName = $unitDetails = "";
			$unitNameErr = $requireErr = $confirmMessage = "";
			$unitNameHolder = $unitDetailsHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtUnitName'])) {
					$unitNameHolder = $_POST['txtUnitName'];
					$result = validate_name($_POST['txtUnitName']);
					if($result == 1) {
						$unitName = $_POST['txtUnitName'];
					}
					else{
						$unitNameErr = $result;
					}
				}
				if(!empty($_POST['txtunitDetails'])) {
					$unitDetails = $_POST['txtunitDetails'];
					$unitDetailsHolder = $_POST['txtunitDetails'];
				}
				if($unitName != null) {
					$query_UpdateUnit = "UPDATE unit SET unit_name='$unitName',unit_details='$unitDetails' WHERE id='$id'";
					if(mysqli_query($con,$query_UpdateUnit)) {
						echo "<script> alert(\"Unit Updated Successfully\"); </script>";
						header('Refresh:0;url=view_unit.php');
					}
					else {
						$requireErr = "Updating Unit Failed";
					}
				}
				else {
					$requireErr = "* Valid Unit Name is required";
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
	<title> Update Unit </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Update Unit</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="unitName">Unit Name</label> </div>
			<div class="input-box"> <input type="text" id="unitName" name="txtUnitName" placeholder="Unit Name" value="<?php echo $row_selectUnitDetails['unit_name']; ?>" required /> </div> <span class="error_message"><?php echo $unitNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="unitDetails">Details</label> </div>
			<div class="input-box"><textarea id="unitDetails" name="txtunitDetails" placeholder="Details"><?php echo $row_selectUnitDetails['unit_details']; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Update Unit" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>