<?php

	// Start the session.
	session_start();
	if(!isset($_SESSION['reg_no']))
	{
		header("location: ./");
	}
	else
		$reg_no = $_SESSION['reg_no'];

	// Establish the connection.
	include("./includes/connect.php");
	
	$member_id = mysqli_real_escape_string($connection, $_POST['member_id']);
	$member_type = mysqli_real_escape_string($connection, $_POST['member_type']);
	$dept_id = mysqli_real_escape_string($connection, $_POST['dept_id']);
	$committee_id = mysqli_real_escape_string($connection, $_POST['committee_id']);
	$role = mysqli_real_escape_string($connection, $_POST['role']);
	$query = "INSERT INTO `members` (`member_id`, `member_type`, `committee_id`, `dept_id`, `role`) VALUES ('$member_id', '$member_type','$committee_id', '$dept_id', '$role')";

	$queryRan = mysqli_query($connection, $query);
	// If successful, then redirect. 
	if($queryRan)
	{
		header('Location: ./adminDashboard.php');	
	}
	else
	{
		echo "Unknown Error Occured";
	}
	

?>