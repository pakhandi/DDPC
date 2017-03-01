	<?php

		include("./includes/preProcess.php");
		$student_reg_no = $_GET['student_reg_no'];
		$query = "SELECT * FROM studentmaster NATURAL JOIN studentthesisdetails NATURAL JOIN currentsupervisor WHERE reg_no='$student_reg_no'";
		$results = mysqli_query($connection, $query);
		$student = mysqli_fetch_array($results);
		$query = "SELECT date_of_reg FROM studentregistration WHERE reg_no ='$reg_no' ORDER BY sem_no ASC";
		$results = mysqli_query($connection, $query);
		$arr = mysqli_fetch_array($results);
		$date_of_reg = $arr['date_of_reg'];
		if($date_of_reg === null) {
			$date_of_reg = date('Y-m-d');
		}
		$query = "SELECT sem_no FROM studentregistration WHERE reg_no ='$reg_no' ORDER BY sem_no DESC";
		$results = mysqli_query($connection, $query);
		if(mysqli_num_rows($results) == 0)
		{
		 $current_sem_no = 0;
		}
		else
		{
		    $arr = mysqli_fetch_array($results);
		    $current_sem_no = $arr['sem_no'];
		}
		$sem_no = $current_sem_no + 1;
		$thisQuery = "SELECT member_id FROM `members` WHERE role='ConvenerDDPC'";
		$thisResult = mysqli_query($connection, $thisQuery);
		$thisResult = mysqli_fetch_array($thisResult);
		$nextNotifTo = $thisResult['member_id'];
		function getFacultyName($faculty_id){
		include("./includes/connect.php");
		$query = "SELECT name FROM faculty WHERE faculty_id ='$faculty_id'";
		$result = mysqli_query($connection, $query);
		$faculty = mysqli_fetch_assoc($result);
		$faculty_name = $faculty['name'];
		return $faculty_name;
	}
	?> 
	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>MNNIT - DDPC</title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
		<meta name="viewport" content="width=device-width" />


		<!-- Bootstrap core CSS     -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />

		<!-- Animation library for notifications   -->
		<link href="assets/css/animate.min.css" rel="stylesheet"/>

		<!--  Paper Dashboard core CSS    -->
		<link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

		<!--  Fonts and icons     -->
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
		<link href="assets/css/themify-icons.css" rel="stylesheet">

		<link href="./css/myCss.css" rel="stylesheet">

		<link href="assets/css/datepicker.css" rel="stylesheet" />
		<script type="text/javascript">
			function nowsearch(faculty_id, num)
			{
				var url='./fetch_faculty.php?faculty_id=' + faculty_id;
				load_my_URL(url,function(data){
				var xml=parse_my_XMLdata(data);
				var Faculty = xml.documentElement.getElementsByTagName("faculty");
				var name = Faculty[0].getAttribute("name");
				var dept_name = Faculty[0].getAttribute("dept_name");
				var id = "1" + num;
				document.getElementById(id).innerHTML = dept_name;
				});
			}
			function load_my_URL(url, do_func)
			{
				var my_req = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
				my_req.onreadystatechange = function()
				{
					if (my_req.readyState == 4)
					{
						my_req.onreadystatechange = no_func;
						do_func(my_req.responseText, my_req.status);
					}
				};
				my_req.open('GET', url, true);
				my_req.send(null);
			}
			function parse_my_XMLdata(data)
			{
				if (window.ActiveXObject)
				{
					var doc = new ActiveXObject('Microsoft.XMLDOM');
					doc.loadXML(data);
					return doc;
				}
				else if (window.DOMParser)
				{
					return (new DOMParser).parseFromString(data, 'text/xml');
				}

			}
			function no_func() {}
			
		</script>

	</head>
	<body>
		<div class="wrapper">
			<div class="sidebar" data-background-color="black" data-active-color="warning">

		<!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
		<div class="sidebar-wrapper">
			<div class="logo">
				<?php include('./includes/topleft.php') ?>
			</div>

			<?php

			$currentTab = "application";

			include("./includes/sideNav.php");

			?>

		</div>
	</div>

	<div class="main-panel">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<?php include('./includes/logo.php'); ?>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="ti-panel"></i>
									<p style="display : none;">Stats</p>
							</a>
						</li>
						<?php include('./includes/notifications.php'); ?>
						<li>
							<a href="./logout.php">
								<i class="ti-settings"></i>
								<p>LogOut</p>
							</a>
						</li>
					</ul>

				</div>
			</div>
		</nav>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<b>
								<div class="col-md-offset-10"> Form: DP-02</div>
								<div class="col-md-offset-10"> (Clause 4.3, 12.2)</div>
								<center><h5><b>Motilal Nehru National Institute of Technology Allahabad</b></h5></center>
								<center><u><h5>Student Research Committee(SRC)</h5></u></center><br>
								<div class="col-md-offset-1" style="font-size:15px">
									<form class="form-inline" id="dp02" name="dp02" action="submitDP02.php" method="post">


									</b>
									Name of the Student : <b><?php echo $student['name']; ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reg. No. <b><?php echo $student['reg_no'];?> </b><br>
									Department : <b> Computer Science and Engineering </b><br>Date of First Registration: <b><?php echo $date_of_reg; ?></b><br>
									Area of Research : <b><?php echo $student['AOR'] ?></b><br>
									Supervisor(s) : <b><?php echo getFacultyName($student['supervisor1_id']); 
									if(!empty($student['supervisor2_id'])){
										echo getFacultyName($student['supervisor2_id']); 
									}
									?></b>
								</div>
								
								<div class="row col-md-offset-1">
									<div class="col-md-11" style="font-size:10px;">
										<table class="table table-bordered table-condensed" style="font-size:15px">
											<thead>
												<th>SI. No.</th>
												<th>Designation</th>
												<th>Name of Members</th>
												<th>Department</th>
											</thead>
											<tbody>
												<tr>
													<td>1.</td>
													<td>Internal SRC Member</td>
													<td><select class="form-control border-input" name="src_int_id" 
														onchange="nowsearch(this.value, 1);" required>
														<option value="">Select</option>
														<?php
														$query = "SELECT * FROM faculty NATURAL JOIN department";
														$faculty = mysqli_query($connection, $query);

														while( $thisFaculty = mysqli_fetch_array($faculty)  )
														{
														?>
															<option value="<?php echo $thisFaculty['faculty_id'] ?>"><?php echo $thisFaculty['name'] ?></option>
															<?php
														}
														?>
													</select>	
												</td>
												<td><p id=11></p></td>
											</tr>
											<tr>
													<td>2.</td>
													<td>External SRC Member</td>
													<td><select class="form-control border-input" name="src_ext_id" 
														onchange="nowsearch(this.value, 2);" required>
														<option value="">Select</option>
														<?php
														$query = "SELECT * FROM faculty NATURAL JOIN department";
														$faculty = mysqli_query($connection, $query);

														while( $thisFaculty = mysqli_fetch_array($faculty)  )
														{
														?>
															<option value="<?php echo $thisFaculty['faculty_id'] ?>"><?php echo $thisFaculty['name'] ?></option>
															<?php
														}
														?>
													</select>	
												</td>
												<td><p id=12></p></td>
											</tr>
										<tr>
													<td>3.</td>
													<td>Supervisor 1</td>
													<td><select class="form-control border-input" name="supervisor1_id" 
														onchange="nowsearch(this.value, 3);" required>
														<option value="">Select</option>
														<?php
														$query = "SELECT * FROM faculty NATURAL JOIN department";
														$faculty = mysqli_query($connection, $query);

														while( $thisFaculty = mysqli_fetch_array($faculty)  )
														{
														?>
															<option value="<?php echo $thisFaculty['faculty_id'] ?>"><?php echo $thisFaculty['name'] ?></option>
															<?php
														}
														?>
													</select>	
												</td>
												<td><p id=13></p></td>
											</tr>
									<tr>
													<td>4.</td>
													<td>Supervisor 2</td>
													<td><select class="form-control border-input" name="supervisor2_id" 
														onchange="nowsearch(this.value, 4);">
														<option value="">Select</option>
														<?php
														$query = "SELECT * FROM faculty NATURAL JOIN department";
														$faculty = mysqli_query($connection, $query);

														while( $thisFaculty = mysqli_fetch_array($faculty)  )
														{
														?>
															<option value="<?php echo $thisFaculty['faculty_id'] ?>"><?php echo $thisFaculty['name'] ?></option>
															<?php
														}
														?>
													</select>	
												</td>
												<td><p id=14></p></td>
											</tr>
							<input type="text" name="nextNotifTo" value="<?php echo $nextNotifTo ?>" style="display: none;">
							<input type="text" name="student_reg_no" value="<?php echo $student_reg_no ?>" style="display: none;">
						</tbody>
					</table>
				</div>
			</div>
			<div style="font-size:15px">
				<div class="col-md-offset-1">Proposed By: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supervisor(s) </div><br>
				<div class="col-md-offset-1">Forwarded By: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Convener DDPC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Head of Department</div><br>
				<div class="col-md-offset-1">Approved By: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chairman SDPC </div><br>



			</div>

			<div class="text-center">
				<button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
			</div><br>
			<h5 class="text-center" id="msg" style="color:red;"></h5>
		</form>
	</div>
</div>
<div>
</div>
</div>

</div>

</div>


<footer class="footer">
</footer>
</div>
</div>
<p></p>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/jquery-1.10.4.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio.js"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="assets/js/paper-dashboard.js"></script>


<!-- Javascript for Datepicker -->
<!-- <script src="assets/js/datepicker.js"></script> -->

<script type="text/javascript">
	function removeNot() {

		$('.notificationAlert').css({
			'display': 'none'
		});

		xmldata = new XMLHttpRequest();

		var el = document.getElementById('notid').innerHTML;

		var urltosend = "set_cookie.php?notid="+el;

		xmldata.open("GET", urltosend,false);
		xmldata.send(null);
		if(xmldata.responseText != ""){
			toPrint = xmldata.responseText;
		}
	}

</script>


</html> 