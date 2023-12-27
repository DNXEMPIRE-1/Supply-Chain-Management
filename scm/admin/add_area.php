<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$areaName = $areaCode = "";
			$areaNameErr = $requireErr = $confirmMessage = "";
			$areaNameHolder = $areaCodeHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtAreaName'])) {
					$unitNameHolder = $_POST['txtAreaName'];
					$result = validate_name($_POST['txtAreaName']);
					if($result == 1) {
						$areaName = $_POST['txtAreaName'];
					}
					else{
						$areaNameErr = $result;
					}
				}
				if(!empty($_POST['txtAreaCode'])) {
					$areaCode = $_POST['txtAreaCode'];
					$areaCodeHolder = $_POST['txtAreaCode'];
				}
				if($areaName != null) {
					$query_addArea = "INSERT INTO area(area_name,area_code) VALUES('$areaName','$areaCode')";
					if(mysqli_query($con,$query_addArea)) {
						echo "<script> alert(\"Area Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding New Area Failed";
					}
				}
				else {
					$requireErr = "* Valid Area Name is required";
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
	<title> Add Unit </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Add Unit</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="areaName">Area Name</label> </div>
			<div class="input-box"> <input type="text" id="areaName" name="txtAreaName" placeholder="Area Name" value="<?php echo $areaNameHolder; ?>" required /> </div> <span class="error_message"><?php echo $areaNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="areaCode">Area Code</label> </div>
			<div class="input-box"> <input type="text" id="areaCode" name="txtAreaCode" placeholder="Area Code" value="<?php echo $areaCodeHolder; ?>" required /> </div>
		</li>
		<li>
			<input type="submit" value="Add Area" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>