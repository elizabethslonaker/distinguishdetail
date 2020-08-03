<?php
include("shared.php");
print $HTMLHeader;
// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
//print makeMenu('index');
//print $adminTitle;
//print $adminNav;
?>

<?php
// This form is used for both adding or updating a record.
// When adding a new record, the form should be an empty one.  When editing an existing item, information of that item should be preloaded onto the form.  How do we know whether it is for adding or editing? Check whether a product id is available -- the form needs to know which item to edit.

$aid = ""; // place holder for product id information.  Set it as empty initally.  You may want to change its name to something more fitting for your application.  However, please note this variable is used in several places later in the script. You need to replace it with the new name through out the script.

// Set all values for the form as empty.  To prepare for the "adding a new item" scenario.
$year = "";
$make = "";
$model = "";
$mileage = "";
$services = "";
$serviceComments = "";
$appDate = "";
$appTime = "";
$firstName = "";
$lastName = "";
$address = "";
$city = "";
$state = "";
$zip = "";
$phone = "";
$email = "";
$comments = "";

$errMsg = "";

// check to see if a product id available via the query string
if (isset($_GET['aid'])) { // spelling 'aid' is based on the query string variable name. When linking to this form (form.php), if a query string is attached, ex. form.php?aid=3 , then that information will be detected here and used below.

	$aid = intval($_GET['aid']); // get the integer value from $_GET['aid'] (ensure $aid contains an integer before use it for the query).  If $_GET['aid'] contains a string or is empty, intval will return zero.

	// validate the product id -- $aid should be greater than zero.
	if ($aid > 0){

		//compose a select query
		$sql = "SELECT Status, Year, Make, Model, Mileage, Services, serviceComments, appDate, appTime, firstName, lastName, Address, City, State, Zip, Phone, Email, Comments FROM appointment WHERE AID = ?"; // note that the spelling "AID" is based on the field name in my product table (database).

		$stmt = $conn->stmt_init();

		if($stmt->prepare($sql)){
			$stmt->bind_param('i',$aid);
			$stmt->execute();

			$stmt->bind_result($Status, $Year, $Make, $Model, $Mileage, $Services, $serviceComments, $appDate, $appTime, $firstName,
			$lastName, $Address, $City, $State, $Zip, $Phone, $Email, $Comments); // bind the information necessary for the form.

			$stmt->store_result();

			// proceed only if a match is found -- there should be only one row returned in the result
			if($stmt->num_rows == 1){
				$stmt->fetch();
			} else {
				$errMsg = "<div class='center'>Information on the appointment you requested is not available.  If it is an error, please contact the webmaster. Thank you.</div>";
				$aid = ""; // reset $aid
			}
		} else {
			// reset $aid
			$aid = "";
			$errMsg = "<div class='center'> If you are expecting to edit an exiting item, there are some error occured in the process -- the selected appointment is not recognizable. Please follow the link below to the adminstration interface or contact the webmaster. Thank you.</div>";
		}
	}
	$stmt->close();
}
?>


<main id="admin">
		<?php print makeAdminMenu('appointments'); ?>
		<div id="admin-main">
			<?= $adminTitleAppointment ?>
			<p><?= $errMsg ?></p>
			<!-- set style of status -->
			<?php if ($Status == 'Pending') : ?>
			  <p class="pending"> <?= $Status ?> </p>
			<?php elseif ($Status == 'Accepted') : ?>
			  <p class="accepted"> <?= $Status ?> </p>
			<?php elseif ($Status == 'Completed') : ?>
			  <p class="completed"> <?= $Status ?> </p>
			<?php elseif ($Status == 'Declined') : ?>
			  <p class="declined"> <?= $Status ?> </p>
			<?php endif; ?>

			<form action="admin_appointmentEdit.php" method="post" class="form-appointment">
				<!-- pass aid using a hidden field -->
				<input type="hidden" name="aid" value="<?= $aid ?>">
				<!-- pass status using a hidden field -->
				<input type="hidden" name="status" value="<?= $Status ?>">
				<h3>Vehicle<hr></h3>
					<div class="flex">
						<div class="col-4">
							<label for="year">* Vehicle Year</label>
							<input type='text' name="year" placeholder="XXXX" value="<?= $Year ?>">
						</div>
						<div class="col-4">
							<label for="make">* Vehicle Make</label>
							<input type='text' name="make" placeholder="ex. Buick" value="<?= $Make ?>">
						</div>
						<div class="col-4">
							<label for="model">* Vehicle Model</label>
							<input type='text' name="model" placeholder="ex. Cascada" value="<?= $Model ?>">
						</div>
						<div class="col-4">
							<label for="mileage">* Vehicle Mileage</label>
							<input type='text' name="mileage" placeholder="Best Guess" value="<?= $Mileage ?>">
						</div>
					</div>

				<h3>Services<hr></h3>
					<input type="checkbox" id="" name="services[]" value="basicWash" value="<?= $Services ?>">
					<label for="basicWash">Basic Wash $35</label>
					<input type="checkbox" id="" name="services[]" value="deluxeWash" value="<?= $Services ?>">
					<label for="deluxeWash">Deluxe Wash $50</label>
					<input type="checkbox" id="" name="services[]" value="premiumWash" value="<?= $Services ?>">
					<label for="premiumWash">Premium Wash $65</label>
					<input type="checkbox" id="" name="services[]" value="ultimateWash" value="<?= $Services ?>">
					<label for="ultimateWash">Ultimate Wash $75</label>

					<br><label for="serviceComments">Comments</label>
					<textarea name="serviceComments" value="<?= $serviceComments ?>"></textarea>

				<h3>Date/Time<hr></h3>
					<label for="appDate">* Date</label>
					<input type="date" name="appDate" min="today's date" value="<?= $appDate ?>">

					<label for="appTime">* Time</label>
					<input type="time" name="appTime" value="<?= $appTime ?>">

				<h3>Contact<hr></h3>
					<div class="flex">
						<div class="col">
							<label for="firstName">* First Name</label>
							<input type='text' name="firstName" placeholder="First Name" value="<?= $firstName ?>">
						</div>
						<div class="col">
							<label for="lastName">* Last Name</label>
							<input type='text' name="lastName" placeholder="Last Name" value="<?= $lastName ?>">
						</div>
					</div>

					<label for="address">* Address - Where will your vehicle be?</label>
					<input type='text' name="address" placeholder="" value="<?= $Address ?>">

					<div class="flex">
						<div class="col-3">
							<label for="city">* City</label>
							<input type='text' name="city" placeholder="" value="<?= $City ?>">
						</div>
						<div class="col-3">
						<label for="address">* State</label>
							<input type='text' name="state" placeholder="" value="<?= $State ?>">
						</div>
						<div class="col-3">
							<label for="zip">* Zip</label>
							<input type='text' name="zip" placeholder="" value="<?= $Zip ?>">
						</div>
					</div>

					<div class="flex">
						<div class="col">
							<label for="phone">* Phone</label>
							<input type='tel' name="phone" placeholder="XXX-XXX-XXXX" value="<?= $Phone ?>">
						</div>
						<div class="col">
							<label for="email">* Email</label>
							<input type='email' name="email" placeholder="email@gmail.com" value="<?= $Email ?>">
						</div>
					</div>

					<label for="comments">Additional Comments</label>
					<textarea name="comments" value="<?= $comments ?>"></textarea>

					<input type="submit" name="Submit" value="Submit" class="btn-primary">
			</form>
		</div>
</main>

<?php //print $footer; ?>

</body>
</html>
