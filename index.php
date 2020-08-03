<?php include("shared.php"); ?>
<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	print makeMenu('index');
?>

<body>
	<main>
		<div class="hero">
			<img src="images/hero.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-content">
				<p>Distinguish Detail</p>
				<h1>We wash while you work</h1>
				<a href="services.php" class="btn-primary">View Services</a>
			</div>
		</div>

		<section class="wrapper card card-left">
			<div class="flex">
				<div class="col">
					<img src="images/washTire.jpeg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
				<div class="col">
					<div class="content">
						<p class="title">Who We Are</p>
						<h2>We are a full-service car wash that comes to you</h2>
						<p>No more driving to a crowded facility to wait in a long line.  We dispatch an expert team of professionals and a custom-equipment van to your house or business. As long as you have a water spout, we’ll take care of the rest!</p>
						<a href="about.php" class="btn-secondary">Learn More</a>
					</div>
				</div>
			</div>
		</section>

		<div class="wrapper hero-sm hero-sm-right">
			<img src="images/services.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-sm-content">
				<h2>Luxury service for a busy life</h2>
				<p>We work on your schedule to provide high-quality service and luxury results. Services include vehicle wash, detail, interior clean and polish, and wax and shine.</p>
				<a href="services.php" class="btn-secondary">View Services</a>
			</div>
		</div>

		<div class="wrapper hero-sm hero-sm-left">
			<img src="images/water.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-sm-content">
				<h2>Book your consultation</h2>
				<p>Your time is valuable. Let us know when and where, and our expert team of professionals will take care of the rest.</p>
				<a href="appointment.php" class="btn-secondary">Request Appointment</a>
			</div>
		</div>

		<section class="wrapper card card-right">
			<div class="flex">
				<div class="col">
					<div class="content">
						<p class="title">Contact Us</p>
						<h2>We value your opinion</h2>
						<p>We love hearing your feedback on our service! Please contact us regarding questions, concerns, or to leave a review. Let’s partner together, and make your vehicle one less thing you need to worry about.</p>
						<a href="contact.php" class="btn-secondary">Contact Us</a>
					</div>
				</div>
				<div class="col">
					<img src="images/porsche.jpg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
			</div>
		</section>
	</main>
  <?php print $footer; ?>
</body>
</html>
