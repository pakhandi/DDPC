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
	
	$leave_type = mysqli_real_escape_string($connection, $_POST['leave_type']);
	$leave_name = mysqli_real_escape_string($connection, $_POST['leave_name']);
	$no_of_days = mysqli_real_escape_string($connection, $_POST['no_of_days']);


	

	$query = "INSERT INTO `leavelookup` (`leave_type`, `leave_name`, `no_of_days`) VALUES ('$leave_type', '$leave_name', '$no_of_days')";
	$queryRan = mysqli_query($connection, $query);

	// If successful, then redirect. 
	if($queryRan)
	{
		
		header("location: ./adminDashboard.php");
	}
	else
	{
		echo "Unknown Error Occured";
	}
	

?>