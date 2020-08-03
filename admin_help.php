<?php include("shared.php"); ?>

<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu.
	//print makeMenu('index');
	//print $adminTitle;
?>


<body>
	<main id="admin">
		<?php print makeAdminMenu('help'); ?>
		<div id="admin-main">
			<h2>Help</h2>
			<p>This guide explains each part of the admin system. For questions or website support, please send an email to <a href="mailto:elizaslonaker@gmail.com" style="text-decoration:underline;">elizaslonaker@gmail.com</a></p>
			<button class="accordion"><h3>Appointments</h3></button>
				<div class="panel">
					<p>The appointments page track all your appointments.</p>
					<h4>Filter Appointments by Status</h4>
						<p>You can sort by status by clicking these tags.</p>
							<a href="#" class="pending">Pending</a>
							<a href="#" class="accepted">Accepted</a>
							<a href="#" class="completed">Completed</a>
							<a href="#" class="declined">Declined</a>
					<h4>Add New Appointment</h4>
						<p>Create a new appointment by clicking the yellow button in the top right corner.</p>
							<a href="#" class="btn-primary">New Appointment</a>
					<h4>View, Edit, Delete Appointments</h4>
						<p>You can view, edit, and delete existing appointments by clicking on the option buttons in the table.</p>
				</div>
			<button class="accordion"><h3>Submissions</h3></button>
				<div class="panel">
					<p></p>
				</div>
			<button class="accordion"><h3>Contacts</h3></button>
				<div class="panel">
					<p></p>
				</div>
			<button class="accordion"><h3>General FAQ</h3></button>
				<div class="panel">
					<h4>Q. How do I change my login credentials?</h4>
					<p>A. Send an email to <a href="mailto:elizaslonaker@gmail.com" style="text-decoration:underline;">elizaslonaker@gmail.com</a></p>
				</div>
			<p>Contact: <a href="mailto:elizaslonaker@gmail.com" style="text-decoration:underline;">elizaslonaker@gmail.com</a></p>
		</div>
	</main>

	<!--FAQ Toggle is taken from a tanzTalks.tech Youtube video: https://www.youtube.com/watch?v=XfLMhmlGvEs -->
	<script type="text/javascript">
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight){
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}
	</script>
</body>
</html>
