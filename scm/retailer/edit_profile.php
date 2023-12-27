<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['retailer_login'])) {
		$username = $password = $areacode = $phone = $email = $address = "";
		$usernameErr = $passwordErr = $phoneErr = $emailErr = $requireErr = $confirmMessage = "";
		$usernameHolder = $phoneHolder = $areacodeHolder = $emailHolder = $addressHolder = "";
		$id = $_SESSION['retailer_id'];
		$query_selectRetailer = "SELECT * FROM retailer WHERE retailer_id='$id'";
		$result_selectRetailer = mysqli_query($con,$query_selectRetailer);
		$row_selectRetailer = mysqli_fetch_array($result_selectRetailer);
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			if(!empty($_POST['txtRetailerPhone'])) {
					$phoneHolder = $_POST['txtRetailerPhone'];
					$resultValidate_phone = validate_phone($_POST['txtRetailerPhone']);
					if($resultValidate_phone == 1) {
						$phone = $_POST['txtRetailerPhone'];
					}
					else {
						$phoneErr = $resultValidate_phone;
					}
				}
			if(!empty($_POST['txtRetailerEmail'])) {
					$emailHolder = $_POST['txtRetailerEmail'];
					$resultValidate_email = validate_email($_POST['txtRetailerEmail']);
					if($resultValidate_email == 1) {
						$email = $_POST['txtRetailerEmail'];
					}
					else {
						$emailErr = $resultValidate_email;
					}
				}
			if(!empty($_POST['txtRetailerAddress'])) {
					$address = $_POST['txtRetailerAddress'];
					$addressHolder = $_POST['txtRetailerAddress'];
				}
			if($phone != null) {
					$query_updateRetailer = "UPDATE retailer SET phone='$phone',email='$email',address='$address' WHERE retailer_id='$id'";
					if(mysqli_query($con,$query_updateRetailer)) {
						echo "<script> alert(\"Retailer Updated Successfully\"); </script>";
						header("Refresh:0");
					}
					else {
						$requireErr = "Updating Retailer Failed";
					}
				}
				else {
					$requireErr = "* Valid Phone number is compulsory";
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
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Edit Profile</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="retailer:phone">Phone</label> </div>
			<div class="input-box"> <input type="text" id="retailer:phone" name="txtRetailerPhone" placeholder="Phone" value="<?php echo $row_selectRetailer['phone']; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:email">Email</label> </div>
			<div class="input-box"> <input type="text" id="retailer:email" name="txtRetailerEmail" placeholder="Email" value="<?php echo $row_selectRetailer['email']; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:address">Address</label> </div>
			<div class="input-box"> <textarea type="text" id="retailer:address" name="txtRetailerAddress" placeholder="Address"><?php echo $row_selectRetailer['address']; ?></textarea> </div>
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