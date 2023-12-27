<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$username = $password = $areacode = $phone = $email = $address = "";
			$usernameErr = $passwordErr = $phoneErr = $emailErr = $requireErr = $confirmMessage = "";
			$usernameHolder = $phoneHolder = $emailHolder = $addressHolder = "";
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
				if(!empty($_POST['txtRetailerPassword'])) {
					$resultValidate_username = validate_password($_POST['txtRetailerPassword']);
					if($resultValidate_username == 1) {
						$password = $_POST['txtRetailerPassword'];
					}
					else {
						$passwordErr = $resultValidate_username;
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
				if($username != null && $password != null && $areacode != null && $phone != null) {
					$query_addRetailer = "INSERT INTO retailer(username,password,address,area_id,phone,email) VALUES('$username','$password','$address','$areacode','$phone','$email')";
					if(mysqli_query($con,$query_addRetailer)) {
						echo "<script> alert(\"Retailer Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding Retailer Failed";
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
	<title> Add Retailer </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Add Retailer</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="retailer:username">Username</label> </div>
			<div class="input-box"> <input type="text" id="retailer:username" name="txtRetailerUname" placeholder="Username" value="<?php echo $usernameHolder; ?>" required /> </div> <span class="error_message"><?php echo $usernameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:password">Password</label> </div>
			<div class="input-box"> <input type="password" id="retailer:password" name="txtRetailerPassword" placeholder="Password" required /> </div> <span class="error_message"><?php echo $passwordErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:areaCode">Area Code</label> </div>
			<div class="input-box">
				<select name="cmbAreaCode" id="retailer:areaCode">
					<option value="" disabled selected>--- Select Area Code ---</option>
			<?php while($row_selectArea = mysqli_fetch_array($result_selectArea)) { ?>
			<option value="<?php echo $row_selectArea["area_id"]; ?>"><?php echo $row_selectArea["area_code"]." (".$row_selectArea["area_name"].")"; ?></option>
			<?php } ?>
				</select>
			 </div>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:phone">Phone</label> </div>
			<div class="input-box"> <input type="text" id="retailer:phone" name="txtRetailerPhone" placeholder="Phone" value="<?php echo $phoneHolder; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:email">Email</label> </div>
			<div class="input-box"> <input type="text" id="retailer:email" name="txtRetailerEmail" placeholder="Email" value="<?php echo $emailHolder; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="retailer:address">Address</label> </div>
			<div class="input-box"> <textarea type="text" id="retailer:address" name="txtRetailerAddress" placeholder="Address"><?php echo $addressHolder; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Add Retailer" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>