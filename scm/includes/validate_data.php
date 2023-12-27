<?php
	function validate_email($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		else {
			return "* Invalid Email";
		}
	}
	function validate_name($name) {
		if(preg_match("/^[a-zA-Z ]{2,50}$/",$name)) {
			return true;
		}
		else {
			return "* Invalid Name";
		}
	}
	function validate_password($password) {
		if(strlen($password) > 4 && strlen($password) < 31) {
			return true;
		}
		else {
			return "* Only 5-30 characters allowed";
		}
	}
	function validate_phone($phone) {
		if(preg_match("/^[0-9]{10}$/",$phone)) {
			return true;
		}
		else {
			return "* Invalid Phone Number";
		}
	}
	function validate_number($number) {
		if(preg_match("/^[0-9]*$/",$number)) {
			return true;
		}
		else {
			return "* Invalid number";
		}
	}
	function validate_price($price) {
		if(preg_match("/^[0-9.]*$/",$price)) {
			return true;
		}
		else {
			return "* Invalid Price";
		}
	}
	function validate_username($username) {
		if(preg_match("/^[a-zA-Z0-9]{5,14}$/",$username)) {
			return true;
		}
		else {
			return "* 5-14 characters, Only Alphabets & Numbers allowed";
		}
	}
?>