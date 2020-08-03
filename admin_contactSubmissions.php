<?php
include("shared.php");
print $HTMLHeader;
?>

<body>
	<main id="admin">
	<!-- INTELLIGENT ADMIN MENU 'submissions is $page'-->
	<?php print makeAdminMenu('submissions'); ?>

	<?php
	/* DEFAULT STATUS - NEW */
	if (!empty($_GET['Status'])){

				 // get the CID value (integer value) from the query string
				 $Status = $_GET['Status'];

				 // If no category is selected, category 2 is the default
			 } else {
				 $Status = 'New';
			 }


	/* RETRIEVE LIST OF SUBMISSIONS */
	$sql = "SELECT CID, Status, firstName, lastName, Phone, Email, Time, Message FROM contactSubmission WHERE Status=? order by CID ASC";

	$stmt = $conn->stmt_init();

	if ($stmt->prepare($sql)){

		$stmt->bind_param('s', $Status);

		$stmt->execute();

		$stmt->store_result();

		$stmt->bind_result($CID, $Status, $firstName, $lastName, $Phone, $Email, $Time, $Message);

		if ($stmt->num_rows > 0) {

		$tblRows = "";
		while($stmt->fetch()){

			$tblRows = $tblRows."<tr>
						<td>$Status</td>
						<td>$firstName<br>$lastName</td>
						<td><a href='tel:$Phone'>$Phone</a><br><a href = 'mailto: $Email'>$Email</a></td>
						<td>$Time</td>
						<td style='width:40%;'>$Message</td>
						<td>
							<form action='admin_contactEdit.php?cid=$CID' method='POST'>
							 <input type='submit' name='Addressed' class='btn-admin_primary' value='Yes'/>
						 	</form>
						 </td>
					</tr>";
		}

		$output = "
    <div><table class='table-contacts'>\n
		<tr><th>Status</th><th>Name</th><th>Contact</th><th>Time</th><th>Message</th><th>Addressed?</th></tr>\n".$tblRows.
		"</table></div>\n";
		//$stmt->close();
	} else {
		$output = "<p>There are no submissions under this status. <br>Please select a status from the tags above.</p>";
	}
}
/* close statement */
$stmt->close();

/* close connection */
$conn->close();
?>

	<div id="admin-main">
		<!-- HEADING -->
		<?= $adminTitleSubmission ?>
		<!-- TAGS FOR FILTERING -->
		<div class="admin-filters">
			<a href="?Status=New" class="new">New</a>
			<a href="?Status=Addressed" class="addressed">Addressed</a>
		</div>
		<!-- TABLE -->
		<?php echo $output ?>
	</div>
	</main>
</body>
</html>
