<?php
include("shared.php");
print $HTMLHeader;
// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
//print makeMenu('index');
//print $adminTitle;
//print $adminNav;

$aid = "";
$errMsg = "";

// check to see if a product id available via the query string
if (isset($_GET['aid'])) { // note that the spelling 'aid' is based on the query string variable name.  When linking to this form (form.php), if a query string is attached, ex. form.php?aid=3 , then that information will be detected here and used below.

	$aid = intval($_GET['aid']); // get the integer value from $_GET['aid'] (ensure $aid contains an integer before use it for the query).  If $_GET['aid'] contains a string or is empty, intval will return zero.

	// validate the product id -- $aid should be greater than zero.
	if ($aid > 0){

		//compose a select query
		$sql = "SELECT Status, Year, Make, Model, Mileage, Services, serviceComments, appDate, appTime, firstName, lastName, Address, City, State, Zip, Phone, Email, Comments FROM appointment WHERE AID = ?";

		$stmt = $conn->stmt_init();

		if($stmt->prepare($sql)){
			$stmt->bind_param('i',$aid);
			$stmt->execute();

			$stmt->bind_result($Status, $Year, $Make, $Model, $Mileage, $Services, $serviceComments, $appDate, $appTime, $firstName,
			$lastName, $Address, $City, $State, $Zip, $Phone, $Email, $Comments);

			$stmt->store_result();

			if($stmt->num_rows == 1){
				$stmt->fetch();
			} else {
				$errMsg = "<div class='error'>Information on this appointment is not available.  If it is an error, please contact the webmaster. Thank you!</div>";
				$aid = ""; // reset $aid
			}
		} else {

			$aid = "";

			$errMsg = "<div class='error'> An error occured while trying to retrieve this appointment. Please try again later or contact the webmaster. Thank you!</div>";
		}
		$stmt->close();
	}
}
?>

<body>
	<main id ="admin">
		<?php print makeAdminMenu('appointments'); ?>
		<div id='admin-main'>
			<!-- NEW BTN -->
			<a href="admin_appointmentForm.php" class="btn-primary btn-footer">New Appointment</a>
			<?= $adminTitleAppointment ?>
	    <p><?= $errMsg ?></p>
			<table>
				<tr>
					<th>Status</th>
					<td><!-- setting style of status -->
					<?php if ($Status == 'Pending') : ?>
					  <p class="pending"> <?= $Status ?> </p>
					<?php elseif ($Status == 'Accepted') : ?>
					  <p class="accepted"> <?= $Status ?> </p>
					<?php elseif ($Status == 'Completed') : ?>
					  <p class="completed"> <?= $Status ?> </p>
					<?php elseif ($Status == 'Declined') : ?>
					  <p class="declined"> <?= $Status ?> </p>
					<?php endif; ?></td>
				</tr>
				<tr>
					<th>Name</th>
					<td><?= $firstName ?> <?= $lastName ?></td>
				</tr>
				<tr>
					<th>Phone</th>
					<td><a href="tel:$Phone"><?= $Phone ?></a></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><a href="mailto:$Email"><?= $Email ?></a></td>
				</tr>
				<tr>
					<th>Address</th>
					<td><?= $Address ?> <br> <?= $City ?>, <?= $State ?> <?= $Zip ?></td>
				</tr>
				<tr>
					<th>Date</th>
					<td><?= $Date ?></td>
				</tr>
				<tr>
					<th>Time</th>
					<td><?= $Time ?></td>
				</tr>
				<tr>
					<th>Services</th>
					<td><?= $Services ?></td>
				</tr>
				<tr>
					<th>Service Comments</th>
					<td><?= $serviceComments ?></td>
				</tr>
				<tr>
					<th>Vehicle Year</th>
					<td><?= $Year ?></td>
				</tr>
				<tr>
					<th>Vehicle Make</th>
					<td><?= $Make ?></td>
				</tr>
				<tr>
					<th>Vehicle Model</th>
					<td><?= $Model ?></td>
				</tr>
				<tr>
					<th>Vehicle Mileage</th>
					<td><?= $Mileage ?></td>
				</tr>
				<tr>
					<th>Additional Comments</th>
					<td><?= $Comments ?></td>
				</tr>
			</table>
			<a href="admin_appointmentList.php" class="center"><p>Return to Appointments</p></a>
	</div>
</main>
</body>
</html>
