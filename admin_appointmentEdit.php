<?php include("shared.php"); ?>

<?php
/* ACCEPT APPOINTMENT (appointmentList.php)*/
if (isset($_POST['Accept'])) {
	if (isset($_GET['aid'])){

	$aid = intval($_GET['aid']);

	$stmt = $conn->stmt_init();

	$sql = "UPDATE appointment SET Status = 'Accepted' WHERE AID = ?";

		if($stmt->prepare($sql)){

			/* bind the parameter onto the query*/
			$stmt->bind_param('i', $aid);
			$stmt_prepared = 1;
		}

		if ($stmt_prepared == 1){
			if ($stmt->execute()){
				$output = "<p class='center'>Appointment accepted!</p><a href='admin_appointmentList.php' class='center'><p>Return to Appointments</p></a>";
			} else {
				//$stmt->execute() failed.
				$output = "<p class='center'>Database operation failed. Please contact the webmaster.</p>";
			}
		} else {
			// statement is not successfully prepared (issues with the query).
			$output = "<p class='center>Database query failed. Please contact the webmaster.</p>";
		}
		//$stmt->close();
	}
}

/*  SUBMISSION TO FORM (appointmentForm.php) */
else if (isset($_POST['Submit'])) {
	//validate user input
	$required = array("year", "make", "model", "mileage", "services", "appDate", "appTime", "firstName", "lastName", "address", "city", "state", "zip", "phone", "email"); // spelling matches form field names
	$expected = array("status", "year", "make", "model", "mileage", "services", "serviceComments", "appDate", "appTime", "firstName", "lastName", "address", "city", "state", "zip", "phone", "email", "comments", "aid");
  // set up label array, field name is key and label is value
  $label = array ('year'=>'Year', "make"=>'Make', "model"=>'Model', "mileage"=>'Mileage', "services"=>'Services',"serviceComments"=>'Service Comments', 'appDate'=>'Appt Date', 'appTime'=>'Appt Time', 'firstName'=>'First Name', 'lastName'=>'Last Name', 'address'=>'Address', 'city'=>'City', 'state'=>'State', 'zip'=>'Zip', 'phone'=>'Phone', 'email'=>'Email', 'status'=>'Status', 'aid'=>'Appointment ID');

	$missing = array();

	foreach ($expected as $field){

		if (in_array($field, $required) && (!isset($_POST[$field]) || empty($_POST[$field]))) {
			array_push ($missing, $field);

		} else {
			// Passed the required field test, set up a variable to carry the user input.
			// Note the variable set up here uses the $field value as the veriable name. Notice the syntax ${$field}.  This is a "variable variable". For example, the first $field in the foreach loop here is "title" (the first one in the $expected array) and a $title variable will be created.  The value of this variable will be either "" or $_POST["title"] depending on whether $_POST["title"] is set up.
            // once we run through the whole $expected array, then these variables, $title, $artist, $price, $categoryID, $pDtail, and $aid, will be generated.

			if (!isset($_POST[$field])) {
				//$_POST[$field] is not set, set the value as ""
				${$field} = "";
			} else {

				${$field} = $_POST[$field];
			}
		}
	}

	//print_r ($missing); // for debugging purpose

	/* proceed only if there is no required fields missing and all other data validation rules are satisfied */
	if (empty($missing)){

		// deal with array input for services
		//$servicesStr = implode(", ", $services);

		// deal with multi-line text input
		$serviceCommentsStr = nl2br(htmlentities($serviceComments));

		// deal with multi-line text input
		$commentsStr = nl2br(htmlentities($comments));

		//$appDate = $_POST['appDate'];
		//$dArr = explode("-", $appDate);  // break it to an array by “-“
		//$newAppDate = $dArr[2]."- ".$dArr[0]."- ".$dArr[1];

		//========================
		// processing user input

		//FIRST SQL FOR APPOINTMENTS
		$stmt = $conn->stmt_init();

		// compose a query: Insert or Update? Depending on whether there is a $aid.

		if ($aid != "") {
			/* there is an existing aid ==> need to deal with an existing appointment ==> use an update query */

			// Ensure $aid contains an integer.
			$aid = intval($aid);

			$sql = "Update appointment SET Status = ?, Year = ?, Make = ?, Model = ?, Mileage = ?, Services = ?, serviceComments = ?, appDate = ?, appTime = ?, firstName = ?, lastName = ?, Address = ?, City = ?, State = ?, Zip = ?, Phone = ?, Email = ?, Comments = ? WHERE AID = ?";


			if($stmt->prepare($sql)){

				// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.

				//'ssii' stands for the type of data so string, string, integer, integer
				$stmt->bind_param('sississsssssssisssi', $status, $year, $make, $model, $mileage, $services, $serviceCommentsStr, $appDate, $appTime, $firstName,
				$lastName, $address, $city, $state, $zip, $phone, $email, $commentsStr, $aid);
				$stmt_prepared = 1;// set up a variable to signal that the query statement is successfully prepared.
			}

		} else {
			// no existing aid ==> this means no existing record to deal with, then it must be a new appointment ==> use an insert query

			$sql = "Insert Into appointment (Status, Year, Make, Model, Mileage, Services, serviceComments, appDate, appTime, firstName, lastName, Address, City, State, Zip, Phone, Email, Comments) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


			if($stmt->prepare($sql)){
				// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.
				$stmt->bind_param('sississsssssssisss', $status, $year, $make, $model, $mileage, $services, $serviceCommentsStr, $appDate, $appTime, $firstName,
				$lastName, $address, $city, $state, $zip, $phone, $email, $commentsStr);
				$stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
			}

			/* =======================================
			SEND EMAIL TO CLIENT

			Styling HTML email:
					1. Put html content in $headers
					2. $htmlContent is $message
					3. Use full url for links and images
			========================================== */

			$to= "eelizabethsss@hotmail.com"; //this should be $email
			$subject ="NEW Appointment Inquiry - Distinguish Detail";
			$htmlContent =
				'
					<html>
					<head></head>
					<body>
						<!-- HEADER IMAGE -->
						<img src="http://projects.elizabethslonaker.co/dd/images/hero.jpg" alt="Distinguish Detail Appointment Inquiry Email" width="100%">

						<!-- EMAIL MESSAGE -->

						<h1>You have a new appointment</h1>
						<p>Please review the details, and accept or reject this appointment in the admin dashboard.</p>

						<table style="margin: 4em 0; border-collapse:collapse; text-align:left;">
							<tr><th>First Name</th><td>'.$firstName.'</td></tr>
							<tr><th>Last Name</th><td>'.$lastName.'</td><tr>
							<tr><th>Phone</th><td>'.$phone.'</td></tr>
							<tr><th>Email</th><td>'.$email.'</td></tr>
							<tr><th>Address</th><td>'.$address.'</td></tr>
							<tr><th>Date</th><td>'.$date.'</td></tr>
							<tr><th>Time</th><td>'.$time.'</td></tr>
							<tr><th>Services</th><td>'.$services.'</td></tr>
							<tr><th>Service Comments</th><td>'.$serviceCommentsStr.'</td></tr>
							<tr><th>Vehicle Year</th><td>'.$year.'</td></tr>
							<tr><th>Vehicle Make</th><td>'.$make.'</td></tr>
							<tr><th>Vehicle Model</th><td>'.$model.'</td></tr>
							<tr><th>Vehicle Mileage</th><td>'.$mileage.'</td></tr>
							<tr><th>Comments</th><td>'.$commentsStr.'</td></tr>
						</table>

						<!-- FOOTER -->
						 <div style="margin-top:4em; text-align:center;">
						  <a href="http://projects.elizabethslonaker.co/dd/index.php" style="color:gray;text-decoration:none">Website</a>
							&nbsp;&nbsp;
							<a href="http://projects.elizabethslonaker.co/dd/admin_login.php" style="color:gray;text-decoration:none;">Admin</a>
						 </div>
					</body>
					</html>
				';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .="From: donotreply@website";
			$mailSent = mail($to,$subject,$htmlContent,$headers);
			/* END OF EMAIL */

		}


		if ($stmt_prepared == 1){
			if ($stmt->execute()){
				$output = "<p>Thank you! We have received the following appointment details.</p>
				<p><strong>Please note that this is an <em>inuqiry</em>. We will contact you shortly to confirm your apppointment.</strong></p>";
				foreach($expected as $key){
					$value = $_POST[$key];
					$output .= "<div><b>{$label[$key]}</b>: $value <br></div>";
				}
				$output .= "<p class='center'><a href='index.php'>Return to Homepage</a></p>";
			} else {
				//$stmt->execute() failed.
				$output = "<p class='center'>Database operation failed. Please contact the webmaster.</p>";
			}
		} else {
			// statement is not successfully prepared (issues with the query).
			$output = "<p class='center>Database query failed. Please contact the webmaster.</p>";
		}
		$stmt->close();
		//END OF FIRST SQL


		//SECOND SQL FOR CONTACTS
		$stmt = $conn->stmt_init();

				$sql2 = "Insert Into contactList (firstName, lastName, Phone, Email) values (?, ?, ?, ?)";

				if($stmt->prepare($sql2)){
					// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.
					$stmt->bind_param('ssss', $firstName, $lastName, $phone, $email);
					$stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
				}

			if ($stmt_prepared == 1){
				if ($stmt->execute()){

				} else {
					//$stmt->execute() failed.
					$output = "<p class='center'>Database operation failed. Please contact the webmaster.</p>";
				}
			} else {
				// statement is not successfully prepared (issues with the query).
				$output = "<p class='center>Database query failed. Please contact the webmaster.</p>";
			}

		$stmt->close();
		//END OF SECOND SQL


	} else {
		// $missing is not empty
		$output = "<p>The following required fields are missing. Please fill them out! \n<ul>\n";
		foreach($missing as $m){
			$output .= "<li>{$label[$m]}\n";
		}
		$output .= "</ul></p>\n";
	}
} else {
	$output = "<p class='center'>Please complete the online appointment inquiry form <a href='appointment.php'>here</a>.</p>";
}
?>

<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	//print makeMenu('schedule');
	//print $adminTitle;
	//print $adminNav;
?>

<main class="container">
		<?= $output ?>
</main>

</body>
</html>
