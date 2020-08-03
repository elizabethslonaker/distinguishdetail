<?php
include("shared.php");
print $HTMLHeader;
?>

<script>
function confirmDel(appDate, aid) {
// javascript function to ask for deletion confirmation

	url = "admin_delete.php?aid="+aid;
	var agree = confirm("Delete this item: <" + appDate + "> ? ");
	if (agree) {
		// redirect to the deletion script
		location.href = url;
	}
	else {
		// do nothing
		return;
	}
}
</script>

<body>
	<main id="admin">
	<!-- INTELLIGENT ADMIN MENU 'appointments is $page'-->
	<?php print makeAdminMenu('appointments'); ?>

	<?php
	/* DEFAULT STATUS - Pending */
	if (!empty($_GET['Status'])){

				 // get the CID value (integer value) from the query string
				 $Status = $_GET['Status'];

				 // If no category is selected, category 2 is the default
			 } else {
				 $Status = 'Pending';
			 }

	/* RETRIEVE LIST OF APPOINTMENTS */
	$sql = "SELECT AID, Status, firstName, lastName, appDate, appTime FROM appointment WHERE Status=? order by appDate ASC";

	$stmt = $conn->stmt_init();

	if ($stmt->prepare($sql)){

		$stmt->bind_param('s', $Status);

		$stmt->execute();

		$stmt->store_result();

		$stmt->bind_result($AID, $Status, $firstName, $lastName, $appDate, $appTime);

		if ($stmt->num_rows > 0) {

		$tblRows = "";
		while($stmt->fetch()){
			$appDate_js = htmlspecialchars($appDate, ENT_QUOTES); // convert quotation marks in the product title to html entity code.  This way, the quotation marks won't cause trouble in the javascript function call ( href='javascript:confirmDel ...' ) below.

			$tblRows = $tblRows."
					<tr>
						<td>$Status</td>
						<td>$firstName $lastName</td>
						<td>$appDate</td>
						<td>$appTime</td>
						<td>
							<form action='admin_appointmentEdit.php?aid=$AID' method='POST'>
								<input type='submit' name='Accept' value='Accept' class='btn-admin_primary'/>
							</form>
							<a href='admin_appointmentView.php?aid=$AID' class='btn-admin_tertiary'>View</a> | <a href='admin_appointmentForm.php?aid=$AID' class='btn-admin_tertiary'>Edit</a> | <a href='javascript:confirmDel(\"$appDate_js\",$AID)' class='btn-admin_tertiary'>Delete</a>
						</td>
					</tr>";
		}
		$output = "
    <div><table class='table-appointments'>\n
		<tr><th>Status</th><th>Name</th><th>Date</th><th>Time</th><th>Options</th></tr>\n".$tblRows.
		"</table></div>\n";
		//$stmt->close();
	} else {
		$output = "<p>There are no appointments under this status. <br>Please select a status from the tags above.</p>";
	}
}
/* close statement */
$stmt->close();

/* close connection */
$conn->close();
?>

	<div id="admin-main">
		<!-- NEW BTN -->
		<a href="admin_appointmentForm.php" class="btn-primary btn-footer">New Appointment</a>
		<!-- HEADING -->
		<?= $adminTitleAppointment ?>
		<!-- TAGS FOR FILTERING -->
		<div class="admin-filters">
			<a href="?Status=Pending" class="pending">Pending</a>
			<a href="?Status=Accepted" class="accepted">Accepted</a>
			<a href="?Status=Completed" class="completed">Completed</a>
			<a href="?Status=Declined" class="declined">Declined</a>
		</div>
		<!-- TABLE -->
		<?php echo $output ?>
	</div>
</main>
</body>
</html>
