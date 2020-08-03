<?php include("shared.php"); ?>
<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	print makeMenu('about');
?>

<body>
	<main>
		<div class="hero">
			<img src="images/wash.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-content">
				<p>About</p>
				<h1>Professional care, quality service</h1>
				<a href="#story" class="btn-primary">Our Story</a>
			</div>
		</div>

		<section id="story" class="wrapper card card-left">
			<div class="flex">
				<div class="col">
					<img src="images/blueCar.jpg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
				<div class="col">
					<div class="content">
						<p class="title">Who We Are</p>
						<h2>We are a full-service car wash and detail that drives to you</h2>
						<p>We are an independently-owned vehicle car service based in the Dallas-Forth Worth area. We are a mobile service company - we come to you. We dispatch our expert team of professionals and a fully equipped van to locations all across the metroplex.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="wrapper card card-right">
			<div class="flex">
				<div class="col">
					<div class="content">
						<p class="title">How We Help</p>
						<h2>We take care of your vehicle, so it can take care of you</h2>
						<p>We understand that you don’t always have the time to take special care of your vehicle. Let us worry about it. With only the best quality products, our team will clean your vehicle’s exterior and interior.</p>
						<a href="services.php" class="btn-secondary">View Services</a>
					</div>
				</div>
				<div class="col">
					<img src="images/contact-hero.jpg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
			</div>
		</section>

		<section class="wrapper card card-left">
			<div class="flex">
				<div class="col">
					<div class="reviews">
						<p class="name">Isabel Albany</p>
						<blockquote>"The team at Distinguish Detail is highly professional. They greatly cut down the time I have to spend on my car and let me focus on more pressing matters. I highly recommend giving them a call!"</blockquote>
					</div>
				</div>
				<div class="col">
					<div class="content">
						<p class="title">Reviews</p>
						<h2>Meet our happy clients</h2>
						<p>Join the community of hard-working people who care about quality service and exceptional results.</p>
					</div>
				</div>
			</div>
		</section>

		<div class="wrapper hero-sm hero-sm-right">
			<img src="images/water.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-sm-content">
				<h2>Book your consultation</h2>
				<p>Your time is valuable. Let us know when and where, and our expert team of professionals will take care of the rest.</p>
				<a href="appointment.php" class="btn-secondary">Request Appointment</a>
			</div>
		</div>
	</main>

  <?php print $footer; ?>
</body>
</html>
