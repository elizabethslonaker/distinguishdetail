<?php include("shared.php"); ?>
<?php
	print $HTMLHeader;
	// call the php function 'makeMenu' to generate the intelligent navigation menu. 'index' is the value of $page
	print makeMenu('services');
?>

<body>
	<main>
		<div class="hero">
			<img src="images/services-hero.jpg" alt="Distinguish Detail Car Wash" width="100%">
			<div class="hero-content">
				<p>Services</p>
				<h1>Luxury service for a busy life</h1>
				<a href="#packages" class="btn-primary">View Packages</a>
			</div>
		</div>

		<section id="packages" class="wrapper card card-right">
			<div class="content">
				<p class="title">Packages</p>
				<h2>Full service detailing packages</h2>
			</div>
			<table class="table-services">
				<tr>
					<th>Basic Wash</th>
					<th>Deluxe Wash</th>
					<th>Premium Wash</th>
				 	<th>Ultimate Wash</th>
				</tr>
				<tr>
					<td class="price">$35</td>
					<td class="price">$50</td>
					<td class="price">$65</td>
					<td class="price">$75</td>
				</tr>
				<tr>
					<td>Basic Wash</td>
					<td>Hand Prep</td>
					<td>Hand Prep</td>
					<td>Hand Prep</td>
				</tr>
				<tr>
					<td></td>
					<td>Undercarriage Rinse</td>
					<td>Undercarriage Rinse</td>
					<td>Undercarriage Rinse</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>Wax</td>
					<td>Wax</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td>Polish and Shine</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td>Hand Dry</td>
				</tr>
			</table>
		</section>

		<section class="wrapper card card-left">
			<div class="flex">
				<div class="col">
					<img src="images/exterior.jpg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
				<div class="col">
					<div class="content">
						<p class="title">Exterior</p>
						<h2>A difference that shines</h2>
						<p>Invest in your exterior with our thorough pressure wash, prep, and wax seal. Protect your exterior with our protective coating. All our washes include a free vacuum and air freshener.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="wrapper card card-right">
			<div class="flex">
				<div class="col">
					<div class="content">
						<p class="title">Interior</p>
						<h2>noticeably clean from the inside out</h2>
						<p>Our team performs a full interior deep cleaning to restore your interior to a new condition. We use special techniques to clean all the hard to reach areas and guard against scratches and stains.</p>
					</div>
				</div>
				<div class="col">
					<img src="images/interior.jpg" alt="Distinguish Detail Car Wash" width="100%">
				</div>
			</div>
		</section>

		<div class="wrapper hero-sm hero-sm-left">
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
