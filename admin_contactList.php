<?php include("shared.php"); ?>

<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	//print makeMenu('index');
	//print $adminTitle;
	//print $adminNav;
?>

<script>
function confirmDel(firstName, cid) {
// javascript function to ask for deletion confirmation

	url = "admin_delete.php?cid="+cid;
	var agree = confirm("Delete this item: <" + firstName + "> ? ");
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
		<?php print makeAdminMenu('contacts'); ?>

	<?php
// Retrieve the product & category info
	$sql = "SELECT CID, firstName, lastName, Phone, Email FROM contactList order by lastName ASC";

	$stmt = $conn->stmt_init();

	if ($stmt->prepare($sql)){

		$stmt->execute();
		$stmt->bind_result($CID, $firstName, $lastName, $Phone, $Email);

		$tblRows = "";
		while($stmt->fetch()){
			$firstName_js = htmlspecialchars($firstName, ENT_QUOTES); // convert quotation marks in the product title to html entity code.  This way, the quotation marks won't cause trouble in the javascript function call ( href='javascript:confirmDel ...' ) below.

			$tblRows = $tblRows."<tr><td>$firstName $lastName</td>
								 <td><a href='tel:$Phone'>$Phone</a></td>
								 <td><a href = 'mailto: $Email'>$Email</a></td>
							     <td><a href='admin_contactForm.php?cid=$CID' class='btn-admin_primary'>Edit</a> <a href='javascript:confirmDel(\"$firstName_js\",$CID)' class='btn-admin_secondary'>Delete</a> </td></tr>";
		}

		$output = "
    <div><table class='table-contacts'>\n
		<tr><th>Name</th><th>Phone</th><th>Email</th><th>Options</th></tr>\n".$tblRows.
		"</table></div>\n";

		$stmt->close();
	} else {

		$output = "<p class='error'>Query to retrieve information failed.</p>";
	}
	$conn->close();
?>

	<div id="admin-main">
		<!-- NEW BTN -->
		<a href="admin_contactForm.php" class="btn-primary btn-footer">New Contact</a>
		<!-- TITLE -->
		<?= $adminTitleContact ?>
		<!-- TABLE -->
		<?php echo $output ?>
	</div>

	</main>

</body>
</html>
