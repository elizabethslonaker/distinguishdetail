<?php
include("shared.php");

print $HTMLHeader;
// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
print makeMenu('schedule');
?>

<?php
function servicesOptionList($selectedSID){

	$list = "";

	global $conn;
	$sql = "SELECT SID, Service FROM services ORDER BY SID";

	$stmt = $conn->stmt_init();

	if ($stmt->prepare($sql)){

		$stmt->execute();
		$stmt->bind_result($SID, $Service);

		while ($stmt->fetch()) {
			$SID=$Service;
			if ($SID == $selectedSID){
				$selected = "Selected";
			} else {
				$selected = "";
			}
			$list = $list."<input type='checkbox' name='SID[]' id='SID' value='$SID' $selected>$Service</><br/>";
		}
	}
	$stmt->close();
	return $list;
}
?>

<main>
	<section class="card card-left">
		<div class="flex">
	 		<div class="col">
		 		<img src="images/appointment-hero.jpg" alt="Distinguish Detail Car Wash" width="100%">
	 		</div>
	 		<div class="col">
				<div class="content">
					<p class="title">Schedule Appointment</p>
					<h2>Book your inquiry online</h2>
					<p>Please give us a call at <a href="tel:+214228-5956">(214) 228-5956</a> or complete the form below to send us an inquiry! <strong>Please note that this is an <em>inuqiry</em>. We will contact you shortly to confirm your apppointment.</strong></p>
					<a href="#form" class="btn-secondary">Book Now</a>
				</div>
	 		</div>
 		</div>
	</section>

<div id="form" class="container">
	<form action="admin_appointmentEdit.php" method="post" class="form-appointment">
		<h2>Appointment Inquiry</h2>
		<!-- pass the aid information using a hidden field -->
		<input type="hidden" name="aid">
		<!-- pass status of pending using a hidden field -->
		<input type="hidden" name="status" value="Pending">
		<h3>Vehicle<hr></h3>
			<div class="flex">
				<div class="col-4">
					<label for="year">* Vehicle Year</label>
					<input type='text' name="year" placeholder="XXXX">
				</div>
				<div class="col-4">
					<label for="make">* Vehicle Make</label>
					<input type='text' name="make" placeholder="ex. Buick">
				</div>
				<div class="col-4">
					<label for="model">* Vehicle Model</label>
					<input type='text' name="model" placeholder="ex. Cascada">
				</div>
				<div class="col-4">
					<label for="mileage">* Vehicle Mileage</label>
					<input type='text' name="mileage" placeholder="Best Guess">
				</div>
			</div>

		<h3>Services<hr></h3>

			<input type="checkbox" id="services" name="services[]" value="basicWash">
			<label for="basicWash">Basic Wash $35</label>

			<input type="checkbox" id="services" name="services[]" value="deluxeWash">
			<label for="deluxeWash">Deluxe Wash $50</label>

			<input type="checkbox" id="services" name="services[]" value="premiumWash">
			<label for="premiumWash">Premium Wash $65</label>

			<input type="checkbox" id="services" name="services[]" value="ultimateWash">
			<label for="ultimateWash">Ultimate Wash $75</label>

			<br><label for="serviceComments">Comments</label>
			<textarea name="serviceComments" placeholder="Please describe your service needs or any other comments..."></textarea>

		<h3>Date/Time<hr></h3>
			<label for="appDate">* Date</label>
			<input type="date" name="appDate" min="today's date">

			<label for="appTime">* Time</label>
			<input type="time" name="appTime">

		<h3>Contact<hr></h3>
			<div class="flex">
				<div class="col">
					<label for="firstName">* First Name</label>
					<input type='text' name="firstName" placeholder="First Name">
				</div>
				<div class="col">
					<label for="lastName">* Last Name</label>
					<input type='text' name="lastName" placeholder="Last Name">
				</div>
			</div>

			<label for="address">* Address - Where will your vehicle be?</label>
			<input type='text' name="address" placeholder="">

			<div class="flex">
				<div class="col-3">
					<label for="city">* City</label>
					<input type='text' name="city" placeholder="">
				</div>
				<div class="col-3">
				<label for="address">* State</label>
					<input type='text' name="state" placeholder="">
				</div>
				<div class="col-3">
					<label for="zip">* Zip</label>
					<input type='text' name="zip" placeholder="">
				</div>
			</div>

			<div class="flex">
				<div class="col">
					<label for="phone">* Phone</label>
					<input type='tel' name="phone" placeholder="XXXXXXXXXX" maxlength="10">
				</div>
				<div class="col">
					<label for="email">* Email</label>
					<input type='email' name="email" placeholder="email@gmail.com">
				</div>
			</div>

			<label for="comments">Additional Comments</label>
			<textarea name="comments" placeholder="Please provide any additional comments and details regarding your appointment..."></textarea>

			<input type="submit" name="Submit" value="Submit" class="btn-primary">
	</form>
</div>
</main>

<?php print $footer; ?>

</body>
</html>
