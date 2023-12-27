<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$id = $_GET['id'];
			$query_selectAreaDetails = "SELECT * FROM area WHERE area_id='$id'";
			$result_selectAreaDetails = mysqli_query($con,$query_selectAreaDetails);
			$row_selectAreaDetails = mysqli_fetch_array($result_selectAreaDetails);
			$areaName = $areaCode = "";
			$areaNameErr = $requireErr = $confirmMessage = "";
			$areaNameHolder = $areaCodeHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtAreaName'])) {
					$areaNameHolder = $_POST['txtAreaName'];
					$areaName = $_POST['txtAreaName'];
				}
				if(!empty($_POST['txtAreaCode'])) {
					$areaCode = $_POST['txtAreaCode'];
					$areaCodeHolder = $_POST['txtAreaCode'];
				}
				if($areaName != null) {
					$query_UpdateArea = "UPDATE area SET area_name='$areaName',area_code='$areaCode' WHERE area_id='$id'";
					if(mysqli_query($con,$query_UpdateArea)) {
						echo "<script> alert(\"Area Updated Successfully\"); </script>";
						header('Refresh:0;url=view_area.php');
					}
					else {
						$requireErr = "Updating Area Failed";
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
	<title> Update Category </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Update Area</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="areaName">Area Name</label> </div>
			<div class="input-box"> <input type="text" id="areaName" name="txtAreaName" placeholder="Area Name" value="<?php echo $row_selectAreaDetails['area_name']; ?>" required /> </div> <span class="error_message"><?php echo $areaNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="areaCode">Area Code</label> </div>
			<div class="input-box"> <input type="text" id="areaCode" name="txtAreaCode" placeholder="Area Code" value="<?php echo $row_selectAreaDetails['area_code']; ?>" required /> </div>
		</li>
		<li>
			<input type="submit" value="Update Area" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>