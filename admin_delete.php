<?php
include("shared.php");
//include("dbconn.inc.php"); // database connection
// make database connection
//$conn = dbConnect();

$cid = ""; // place holder for id information

//See if an id is available from the client side. If yes, then retrieve the info from the database based on the id.  If not, present the form.
if (isset($_GET['cid'])) { // note that the spelling 'cid' is based on the query string variable name

	// id available, validate the information, then compose a query accordingly to retrieve information.
	$cid = intval($_GET['cid']); // force all input into an integer.  If the input is a string or empty, it will be converted to 0.

	// validate the id -- check to see if it is greater than 0
		if ($cid>0 ){
			//compose the query
			$sql = "DELETE from contactList WHERE CID = ?"; // note that the spelling "CID" is based on the field name in the database contact table.

			$stmt = $conn->stmt_init();

			if ($stmt->prepare($sql)){

				$stmt->bind_param('i',$cid);

				if ($stmt->execute()){ // $stmt->execute() will return true (successful) or false
					$output = "<p class='center'>The selected contact was successfully deleted!</p><p class='center'><a href='admin_contactList.php'>Return to Contact List</a></p>";
				} else {
					$output = "<p>The database operation to delete the contact has failed. Please try again or contact the system administrator.</p><p class='center'><a href='admin_contactList.php'>Return to Contact List</a></p>";
				}
			}
		} else {
			$cid = "";
			// error message
			$output = "<p>An error has occured trying to delete an exiting item. The contact you selected is not recognizable. Please contact the webmaster.</p><p class='center'><a href='admin_dashboard.php'>Return to Dashboard</a></p>";
		}
} else {
	$output = "<p class='center'>Success! Item has been deleted.</p>";
}
?>

<?php
$aid = ""; // place holder for id information

//See if an id is available from the client side. If yes, then retrieve the info from the database based on the id.  If not, present the form.
if (isset($_GET['aid'])) { // note that the spelling 'cid' is based on the query string variable name

	// id available, validate the information, then compose a query accordingly to retrieve information.
	$aid = intval($_GET['aid']); // force all input into an integer.  If the input is a string or empty, it will be converted to 0.

	// validate the id -- check to see if it is greater than 0
		if ($aid>0 ){
			//compose the query
			$sql = "DELETE from appointment WHERE AID = ?"; // note that the spelling "CID" is based on the field name in the database contact table.

			$stmt = $conn->stmt_init();

			if ($stmt->prepare($sql)){

				$stmt->bind_param('i',$aid);

				if ($stmt->execute()){ // $stmt->execute() will return true (successful) or false
					$output = "<p class='center'>The selected appointment was successfully deleted!</p><p class='center'><a href='admin_appointmentList.php'>Return to Appointment List</a></p>";
				} else {
					$output = "<p>The database operation to delete the appointment has failed. Please try again or contact the system administrator.</p><p class='center'><a href='admin_appointmentList.php'>Return to Appointment List</a></p>";
				}
			}
		} else {
			$aid = "";
			// error message
			$output = "<p>An error has occured trying to delete an exiting item. The appointment you selected is not recognizable. Please contact the webmaster.</p><p class='center'><a href='admin_dashboard.php'>Return to Dashboard</a></p>";
		}
} else {
	$output = "<p class='center'>Success! Item has been deleted.</p>";
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
	<?php print makeAdminMenu('index'); ?>
	<div id="admin-main">
    <?= $output ?>
	</div>
</main>

</body>
</html>
