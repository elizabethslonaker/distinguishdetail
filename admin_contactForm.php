<?php
include("shared.php");
// This form is used for both adding or updating a record.
// When adding a new record, the form should be an empty one.  When editing an existing item, information of that item should be preloaded onto the form.  How do we know whether it is for adding or editing? Check whether a product id is available -- the form needs to know which item to edit.

$cid = ""; // place holder for contact id information.  Set it as empty initally.

// Set all values for the form as empty.  To prepare for the "adding a new item" scenario.
$firstName = "";
$lastName = "";
$phone = "";
$email = "";
$CID = "";

$errMsg = "";

// check to see if an id is available via the query string
if (isset($_GET['cid'])) { // spelling 'cid' is based on the query string variable name. When linking to this form (form.php), if a query string is attached, ex. form.php?cid=3 , then that information will be detected here and used below.

	$cid = intval($_GET['cid']); // get the integer value from $_GET['cid'] (ensure $cid contains an integer before use it for the query).  If $_GET['cid'] contains a string or is empty, intval will return zero.

	// validate the id -- $cid should be greater than zero.
	if ($cid > 0){

		//compose a select query
		$sql = "SELECT firstName, lastName, Phone, Email, CID from contactList WHERE CID = ?"; // note that the spelling "CID" is based on the field name in my product table (database).

		$stmt = $conn->stmt_init();

		if($stmt->prepare($sql)){
			$stmt->bind_param('i', $cid);
			$stmt->execute();

			$stmt->bind_result($firstName, $lastName, $phone, $email, $CID); // bind the information necessary for the form.

			$stmt->store_result();

			// proceed only if a match is found -- there should be only one row returned in the result
			if($stmt->num_rows == 1){
				$stmt->fetch();
			} else {
				$errMsg = "<div class='center'>Information on this contact is not available. If it's an error, please contact the webmaster. Thank you.</div>";
				$cid = ""; // reset $cid
			}
		} else {
			// reset $cid
			$cid = "";
			// error message
			$errMsg = "<div class='center'>The selected contact is not recognized. Please follow the link below to the dashboard or contact the webmaster. Thank you.</div>";
		}
		$stmt->close();
	} // close if(is_int($cid))
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
	  <p><?= $errMsg ?></p>
		<form action="admin_contactEdit.php" method="POST">
			<h3>Add New Contact</h3>
			<p>*Required</p>
			<!-- pass the cid information using a hidden field -->
			<input type="hidden" name="cid" value="<?=$cid?>">
			<div class="flex">
				<div class="col">
					<label for="firstName">* First Name</label>
					<input type="text" name="firstName" value="<?= $firstName ?>">
				</div>
				<div class="col">
					<label for="lastName">* Last Name</label>
					<input type="text" name="lastName" value="<?= $lastName ?>">
				</div>
			</div>
			<div class="flex">
				<div class="col">
					<label for="phone">Phone</label>
					<input type="tel" name="phone" value="<?= $phone ?>">
				</div>
				<div class="col">
					<label for="email">* Email</label>
					<input type="text" name="email" value="<?= $email ?>">
				</div>
			</div>
			<input type=submit name="Submit" value="Submit" class="btn-primary">
		</form>
</div>
</main>

</body>
</html>
