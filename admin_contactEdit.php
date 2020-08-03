<?php include("shared.php");
/* ADDRESSED SUBMISSION (admin_contactSubmissions.php)*/
if (isset($_POST['Addressed'])) {
	if (isset($_GET['cid'])){

	$cid = intval($_GET['cid']);

	$stmt = $conn->stmt_init();

	$sql = "UPDATE contactSubmission SET Status = 'Addressed' WHERE CID = ?";

		if($stmt->prepare($sql)){

			/* bind the parameter onto the query*/
			$stmt->bind_param('i', $cid);
			$stmt_prepared = 1;
		}

		if ($stmt_prepared == 1){
			if ($stmt->execute()){
				$output = "<p>Submission addressed!</p><a href='admin_contactSubmissions.php'><p>Return to Submissions</p></a>";
			} else {
				//$stmt->execute() failed.
				$output = "<p>Database operation failed. Please contact the webmaster.</p>";
			}
		} else {
			// statement is not successfully prepared (issues with the query).
			$output = "<p>Database query failed. Please contact the webmaster.</p>";
		}
		//$stmt->close();
	}
}



/* SUBMISSION TO CONTACT FORM */
else if (isset($_POST['Submit'])) {

	//validate user input
	$required = array("firstName", "lastName", "email"); // spelling matches form field names
	$expected = array("firstName", "lastName", "phone", "email", "cid");
  // set up label array, field name is key and label is value
  $label = array ('firstName'=>'First Name', "lastName"=>'Last Name', "phone"=>'Phone', 'email'=>'Email', "cid"=>'Contact ID');
	$missing = array();

	foreach ($expected as $field){

		if (in_array($field, $required) && (!isset($_POST[$field]) || empty($_POST[$field]))) {
			array_push ($missing, $field);

		} else {
			// Passed the required field test, set up a variable to carry the user input.
			// Note the variable set up here uses the $field value as the veriable name. Notice the syntax ${$field}.  This is a "variable variable". For example, the first $field in the foreach loop here is "title" (the first one in the $expected array) and a $title variable will be created.  The value of this variable will be either "" or $_POST["title"] depending on whether $_POST["title"] is set up.
            // once we run through the whole $expected array, then these variables, $title, $artist, $price, $categoryID, $pDtail, and $cid, will be generated.

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

		//========================
		// processing user input

		$stmt = $conn->stmt_init();

		// compose a query: Insert or Update? Depending on whether there is a $cid.

		if ($cid != "") {
			/* there is an existing cid ==> need to deal with an existing contact ==> use an update query */

			// Ensure $cid contains an integer.
			$cid = intval($cid);

			//update ContactList table
			$sql = "Update contactList SET firstName = ?, lastName = ?, Phone = ?, Email = ? WHERE CID = ?";

			if($stmt->prepare($sql)){

				// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.

				//'ssii' stands for the type of data so string, string, integer, integer
				$stmt->bind_param('ssssi', $firstName,
				$lastName, $phone, $email, $cid);
				$stmt_prepared = 1;// set up a variable to signal that the query statement is successfully prepared.
			}

		} else {
			// no existing cid ==> this means no existing record to deal with, then it must be a new contact ==> use an insert query into contactList
			$sql = "Insert Into contactList (firstName, lastName, Phone, Email) values (?, ?, ?, ?)";

			if($stmt->prepare($sql)){
				$stmt->bind_param('ssss', $firstName,
				$lastName, $phone, $email);
				$stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
			}
		}

		if ($stmt_prepared == 1){
			if ($stmt->execute()){
				$output = "<p>Success! The following contact has been saved to the database.</p>";
				foreach($expected as $key){
					$value = $_POST[$key];
					$output .= "<div><b>{$label[$key]}</b>: $value <br></div>";
				}
				$output .= "<p><a href='admin_contactList.php'>Return to Contact List</a></p>";
			} else {
				//$stmt->execute() failed.
				$output = "<p>Database operation failed. Please contact the webmaster.</p>";
			}
		} else {
			// statement is not successfully prepared (issues with the query).
			$output = "<p>Database query failed. Please contact the webmaster.</p>";
		}
	} else {
		// $missing is not empty
		$output = "<p>The following required fields are missing. Please fill them out! \n<ul>\n";
		foreach($missing as $m){
			$output .= "<li>{$label[$m]}\n";
		}
		$output .= "</ul></p>\n";
	}
} else {
	$output = "<p>Please begin your contact managment from the <a href='admin_contactList.php'>admin page</a>.</p>";
}
?>

<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	//print makeMenu('index');
	//print $adminTitle;
	//print $adminNav;
?>

<main id="admin">
	<?php print makeAdminMenu('contacts'); ?>
	<div id="admin-main">
		<!-- ADD CONTACT BTN -->
		<a href="admin_contactForm.php" class="btn-primary btn-footer">New Contact</a>
		<?= $adminTitleContact ?>
    <?= $output ?>
	</div>
</main>

</body>
</html>
