<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		$name = $phone = $email = "";
		$nameErr = $phoneErr = $emailErr = $requireErr = $confirmMessage = "";
		$usernameHolder = $phoneHolder = $emailHolder = "";
		$id = $_SESSION['manufacturer_id'];
		$query_selectMan = "SELECT * FROM manufacturer WHERE man_id='$id'";
		$result_selectMan = mysqli_query($con,$query_selectMan);
		$row_selectMan = mysqli_fetch_array($result_selectMan);
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			if(!empty($_POST['txtManufacturerName'])) {
					$nameHolder = $_POST['txtManufacturerName'];
					$resultValidate_name = validate_name($_POST['txtManufacturerName']);
					if($resultValidate_name == 1) {
						$name = $_POST['txtManufacturerName'];
					}
					else{
						$nameErr = $resultValidate_name;
					}
				}
				if(!empty($_POST['txtManufacturerEmail'])) {
					$emailHolder = $_POST['txtManufacturerEmail'];
					$resultValidate_email = validate_email($_POST['txtManufacturerEmail']);
					if($resultValidate_email == 1) {
						$email = $_POST['txtManufacturerEmail'];
					}
					else {
						$emailErr = $resultValidate_email;
					}
				}
				if(!empty($_POST['txtManufacturerPhone'])) {
					$phoneHolder = $_POST['txtManufacturerPhone'];
					$resultValidate_phone = validate_phone($_POST['txtManufacturerPhone']);
					if($resultValidate_phone == 1) {
						$phone = $_POST['txtManufacturerPhone'];
					}
					else {
						$phoneErr = $resultValidate_phone;
					}
				}
			if($name != null && $phone != null) {
					$query_updateMan = "UPDATE manufacturer SET man_name='$name',man_email='$email',man_phone='$phone' WHERE man_id='$id'";
					if(mysqli_query($con,$query_updateMan)) {
						echo "<script> alert(\"Manufacturer Updated Successfully\"); </script>";
						header("Refresh:0");
					}
					else {
						$requireErr = "Updating Manufacturer Failed";
					}
				}
				else {
					$requireErr = "* Valid Name & Phone is compulsory";
				}
		}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Edit Profile </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Edit Profile</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="manufacturer:name">Name</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:name" name="txtManufacturerName" placeholder="Name" value="<?php echo $row_selectMan['man_name']; ?>" required /> </div> <span class="error_message"><?php echo $nameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:email">Email</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:email" name="txtManufacturerEmail" placeholder="Email" value="<?php echo $row_selectMan['man_email']; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:phone">Phone</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:phone" name="txtManufacturerPhone" placeholder="Phone" value="<?php echo $row_selectMan['man_phone']; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<a href="change_password.php"><input type="button" value="Change Password" class="submit_button" /></a>
			<input type="submit" value="Update Profile" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>