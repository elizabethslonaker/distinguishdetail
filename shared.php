<?php
// shared.php stores shared information that will be on EVERY page (headers, menu, footer, etc.)

//Start session variable
//session_start();

// database connection
include("dbconn.inc.php");

// make database connection
$conn = dbConnect();

// HTML Header
$HTMLHeader =
'<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="description goes here">
	<meta name="keywords" content="HTML, CSS, XML, Javascript">
	<meta name="author" content="your name">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Distinguish Detail</title>
	<link rel="stylesheet" href="CSS/styles.css" type="text/css">
	<script src="https://kit.fontawesome.com/393e357d21.js" crossorigin="anonymous"></script>
</head>
';



// Intelligent Menu - Highlights Current Page
function makeMenu ($page) {

	// set all CSS classes as a default value
	$class2 = $class3 = $class4 = $class5 = $class6 = "menu";

	// Use multiple else if statements to selectively highlight one of the pages
	if ($page == "index") {
		$class2 = "menu_highlight";
	} else if ($page == "services") {
		$class3 = "menu_highlight";
	} else if ($page == "about") {
		$class4 = "menu_highlight";
	} else if ($page == "contact") {
		$class5 = "menu_highlight";
	} else if ($page == "appointment") {
		$class6 = "menu_highlight";
	}

	$menu = "
	<nav>
		<a href='index.php'><img src='images/logo_black.svg' class='logo' alt='Distinguish Detail Logo'/></a>
		<ul>
			<li><a href='index.php' class='$class2'>Home</a></li>
			<li><a href='services.php' class='$class3'>Services</a></li>
			<li><a href='about.php' class='$class4'>About</a></li>
			<li><a href='contact.php' class='$class5'>Contact</a></li>
			<li><a href='appointment.php' class='$class6 btn-primary'>Schedule</a></li>
		</ul>
	</nav>
	";
	return $menu;
}



// Admin Nav
// Intelligent Menu - Highlights Current Page
function makeAdminMenu ($page) {

	// set all CSS classes as a default value
	$class2 = $class3 = $class4 = $class5 = "adminNav";

	// Use multiple else if statements to selectively highlight one of the pages
	if ($page == "appointments") {
		$class2 = "menu_highlight";
	} else if ($page == "submissions") {
		$class3 = "menu_highlight";
	} else if ($page == "contacts") {
		$class4 = "menu_highlight";
	} else if ($page == "help") {
		$class5 = "menu_highlight";
	}
$adminNav = "
<div class='nav-admin'>
		<ul>
			<li><img src='images/logo_black.svg' class='logo' alt='Distinguish Detail Logo'/></li>
			<li><a href='admin_appointmentList.php' class='$class2'>Appointments</a></li>
			<li><a href='admin_contactSubmissions.php' class='$class3'>Submissions</a></li>
			<li><a href='admin_contactList.php' class='$class4'>Contacts</a></li>
		</ul>
		<ul class='bottom'>
			<li><a href='admin_help.php' class='$class5'>Help</a></li>
			<li><a href='admin_login.php?logout'>Log Out</a></li>
		</ul>
</div>
";
return $adminNav;
}


$adminTitleAppointment = "
	<h2>Appointments</h2>
	<h4>Track all your appointments. Sort by status. Add a new appointment, or view, edit, and delete existing appointments.</h4>
";
$adminTitleSubmission = "
	<h2>Contact Submissions</h2>
	<h4>Track all submissions to the contact form. Respond to new comments.</h4>
";
$adminTitleContact = "
	<h2>Contact List</h2>
	<h4>Track all your contacts. Add a new contact, or edit and delete existing contacts.</h4>
";



// Footer
$footer = '
<footer>
	<div class="flex">
		<div class="col-4">
			<img src="images/logo_black.svg" alt="Distinguish Detail Logo" class="logo"/>
			<p><i class="far fa-copyright"></i>Distinguish Detail 2020</p>
			<p>This is for a course project</p>
		</div>
		<div class="col-4">
			<p><a href="index.php">Home</a></p>
			<p><a href="services.php">Services</a></p>
			<p><a href="about.php">About</a></p>
			<p><a href="contact.php">Contact</a></p>
			<p><a href="appointment.php">Schedule</a></p>
		</div>
		<div class="col-4">
			<p><a href="#" target="_blank"><i class="fab fa-facebook-f"></i>Facebook</a></p>
			<p><a href="#" target="_blank"><i class="fab fa-twitter"></i>Twitter</a></p>
			<p><a href="#" target="_blank"><i class="fab fa-instagram"></i>Instagram</p>
		</div>
		<div class="col-4">
			<p>Roderick McNeal</p>
			<p><a href="tel:+214228-5956">(214) 228-5956</a></p>
			<p><a href="mailto:roderickmcneal1@yahoo.com">roderickmcneal1@yahoo.com</a></p>
		</div>
	</div>
	<a href="admin_login.php" class="btn-primary btn-footer">Admin</a>
</footer>

<!-- SCRIPT TAG -->
<script src="js/app.js"></script>
';
?>
