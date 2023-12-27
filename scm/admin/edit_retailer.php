<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$id = $_GET['id'];
			$query_selectRetailerDetails = "SELECT * FROM retailer WHERE retailer_id='$id'";
			$result_selectRetailerDetails = mysqli_query($con,$query_selectRetailerDetails);
			$row_selectRetailerDetails = mysqli_fetch_array($result_selectRetailerDetails);
			$username = $password = $areacode = $phone = $email = $address = "";
			$usernameErr = $passwordErr = $phoneErr = $emailErr = $requireErr = $confirmMessage = "";
			$usernameHolder = $phoneHolder = $areacodeHolder = $emailHolder = $addressHolder = "";
			$query_selectArea = "SELECT * FROM area";
			$result_selectArea = mysqli_query($con,$query_selectArea);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtRetailerUname'])) {
					$usernameHolder = $_POST['txtRetailerUname'];
					$resultValidate_username = validate_username($_POST['txtRetailerUname']);
					if($resultValidate_username == 1) {
						$username = $_POST['txtRetailerUname'];
					}
					else{
						$usernameErr = $resultValidate_username;
					}
				}
				if(!empty($_POST['cmbAreaCode'])) {
					$areacode = $_POST['cmbAreaCode'];
				}
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
				if($username != null && $areacode != null && $phone != null) {
					$query_UpdateRetailer = "UPDATE retailer SET username='$username',address='$address',area_id='$areacode',phone='$phone',email='$email' WHERE retailer_id='$id'";
					if(mysqli_query($con,$query_UpdateRetailer)) {
						echo "<script> alert(\"Retailer Updated Successfully\"); </script>";
						header('Refresh:0;url=view_retailer.php');
					}
					else {
						$requireErr = "Updating Retailer Failed";
					}
				}
				else {
					$requireErr = "* Valid Username, Password, Areacode & Email are compulsory";
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
	<title> Edit Retailer </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Edit Retailer</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="retailer:username">Username</label> </div>
			<div class="input-box"> <input type="text" id="retailer:username" name="txtRetailerUname" placeholder="Username" value="<?php echo $row_selectRetailerDetails['username']; ?>" required /> </div> <span class="error_message"><?php echo $usernameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:areaCode">Area Code</label> </div>
			<div class="input-box">
				<select name="cmbAreaCode" id="retailer:areaCode">
					<option value="" disabled>--- Select Area Code ---</option>
			<?php while($row_selectArea = mysqli_fetch_array($result_selectArea)) { ?>
					<option value="<?php echo $row_selectArea["area_id"]; ?>" <?php if($row_selectRetailerDetails['area_id'] == $row_selectArea["area_id"]){echo "selected";} ?>><?php echo $row_selectArea["area_code"]." (".$row_selectArea["area_name"].")"; ?></option>
			<?php } ?>
				</select>
			 </div>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:phone">Phone</label> </div>
			<div class="input-box"> <input type="text" id="retailer:phone" name="txtRetailerPhone" placeholder="Phone" value="<?php echo $row_selectRetailerDetails['phone']; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:email">Email</label> </div>
			<div class="input-box"> <input type="text" id="retailer:email" name="txtRetailerEmail" placeholder="Email" value="<?php echo $row_selectRetailerDetails['email']; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:address">Address</label> </div>
			<div class="input-box"> <textarea type="text" id="retailer:address" name="txtRetailerAddress" placeholder="Address"><?php echo $row_selectRetailerDetails['address']; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Update Retailer" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>