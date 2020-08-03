<?php
	include("shared.php");
	print $HTMLHeader;
?>

<body>
	<main id="admin">
	<!-- INTELLIGENT ADMIN MENU 'home is $page'-->
	<?php print makeAdminMenu('appointments'); ?>


	<div id="admin-main">
		<h2>Dashboard<h2>
		<!-- TABLE -->
		<?php echo $output ?>
	</div>
</main>
</body>
</html>
