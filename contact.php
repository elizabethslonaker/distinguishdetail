<?php
include("shared.php");

print $HTMLHeader;

// call the php function 'makeMenu' to generate the intelligent navigation menu. 'contact' is the value of $page
print makeMenu('contact');
?>

<main>
  <section class="card card-left">
    <div class="flex">
    	 <div class="col">
    		 <img src="images/contact-hero.jpg" alt="Distinguish Detail Car Wash" width="100%">
    	 </div>
    	 <div class="col">
         <div class="content">
           <p class="title">Contact</p>
    		    <h2>Let Us Come to You</h2>
            <p><i class="fas fa-phone"></i><strong>Phone</strong><br> <a href="tel:+214228-5956">(214) 228-5956</a></p>
            <p><i class="fas fa-envelope"></i><strong>Email</strong><br>roderickmcneal1@yahoo.com</p>
            <a href="#form" class="btn-secondary">Contact Now</a>
          </div>
    	 </div>
     </div>
  </section>

  <div id="form" class="container">
    <form action="" method="POST">
      <!-- pass status of pending using a hidden field -->
  		<input type="hidden" name="status" value="New">
      <h2>Let's Get In Touch</h2>
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
        <div class="flex">
          <div class="col">
            <label for="phone">* Phone</label>
            <input type='tel' name="phone" placeholder="(XXX) XXX-XXXX">
          </div>
          <div class="col">
            <label for="email">* Email</label>
            <input type='text' name="email" placeholder="your@email.com">
          </div>
        </div>
        <div class="col">
          <label for="message">Message</label>
          <textarea rows="10" type='text' name="message" placeholder="Please leave us any questions or comments. We will respond to you shortly by email."></textarea>
        </div>
        <input type="submit" name="Submit" value="Submit" class="btn-primary">
    </form>
  </div>
</main>

<?php
// If there's a submission
if (isset($_POST['Submit'])) {

	//validate user input
	$required = array("firstName", "lastName", "phone", "email"); // spelling matches form field names
	$expected = array("status", "firstName", "lastName", "phone", "email", "message");
  // set up label array, field name is key and label is value
  $label = array ('status'=> 'Status','firstName'=>'First Name', "lastName"=>'Last Name', "phone"=>'Phone', 'email'=>'Email', 'message'=>'Message', "cid"=>'Contact ID');
	$missing = array();

	foreach ($expected as $field){

		if (in_array($field, $required) && (!isset($_POST[$field]) || empty($_POST[$field]))) {
			array_push ($missing, $field);

		} else {
			// Passed the required field test, set up a variable to carry the user input.
			// Note the variable set up here uses the $field value as the veriable name. Notice the syntax ${$field}.  This is a "variable variable". For example, the first $field in the foreach loop here is "title" (the first one in the $expected array) and a $title variable will be created.  The value of this variable will be either "" or $_POST["title"] depending on whether $_POST["title"] is set up.
            // once we run through the whole $expected array, then these variables, $title, $artist, $price, $categoryID, $pDtail, and $cid, will be generated.

			if (!isset($_POST[$field])) {
				//$_POST[$field] is not set, set the value as ""
				${$field} = "";
			} else {

				${$field} = $_POST[$field];
			}
		}
	}

	//print_r ($missing); // for debugging purpose

	/* proceed only if there is no required fields missing and all other data validation rules are satisfied */
	if (empty($missing)){

		//========================
		// processing user input

		$stmt = $conn->stmt_init();

		// compose a query: Insert or Update? Depending on whether there is a $cid.

		/*if ($cid != "") {
			/* there is an existing cid ==> need to deal with an existing contact ==> use an update query */

			// Ensure $cid contains an integer.
			//$cid = intval($cid);

			//update ContactList table
			//$sql2 = "Update contactList SET firstName = ?, lastName = ?, Phone = ?, Email = ? WHERE CID = ?";

		/*	if($stmt->prepare($sql2)){

				// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.

				//'ssii' stands for the type of data so string, string, integer, integer
				$stmt->bind_param('ssisi', $firstName,
				$lastName, $phone, $email, $cid);
				$stmt_prepared = 1;// set up a variable to signal that the query statement is successfully prepared.
			}

		}*/
			// no existing cid ==> this means no existing record to deal with, then it must be a new contact ==> use an insert query

			//insert into ContactList table
			//$sql2 = "Insert Into contactList (firstName, lastName, Phone, Email) values (?, ?, ?, ?)";

      //insert into contactSubmission table
      $sql = "Insert Into contactSubmission (Status, firstName, lastName, Phone, Email, Message, Time) values (?, ?, ?, ?, ?, ?, NOW()-INTERVAL 5 HOUR)";

      if($stmt->prepare($sql)){

				// Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.
				$stmt->bind_param('sssiss', $status, $firstName,
				$lastName, $phone, $email, $message);
				$stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
			}

			/*if($stmt->prepare($sql)){
				$stmt->bind_param('sssiss', $status, $firstName,
				$lastName, $phone, $email, $message);
				$stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
			}*/


      /* =======================================
			SEND EMAIL TO CLIENT

			Styling HTML email:
					1. Put html content in $headers
					2. $htmlContent is $message
					3. Use full url for links and images
			========================================== */
			$to= "eelizabethsss@hotmail.com"; //this should be $email
			$subject ="NEW Contact Sunbmission - Distinguish Detail";
			$htmlContent =
				'
					<html>
					<head></head>
					<body>
						<!-- HEADER IMAGE -->
						<img src="http://projects.elizabethslonaker.co/dd/images/hero.jpg" alt="Distinguish Detail Contact Submission Email" width="100%">

						<!-- EMAIL MESSAGE -->
						<h1>You have a new contact submission</h1>
						<h3>'.$firstName.' is waiting for your response.</h3>

						<table style="margin: 4em 0; border-collapse:collapse; text-align:left;">
							<tr><td><strong>First Name</strong><br>'.$firstName.'</td></tr>
							<tr><td><strong>Last Name</strong><br>'.$lastName.'</td><tr>
							<tr><td><strong>Phone</strong><br>'.$phone.'</td></tr>
							<tr><td><strong>Email</strong><br>'.$email.'</td></tr>
							<tr><td><strong>Address</strong><br>'.$message.'</td></tr>
						</table>

						<!-- FOOTER -->
						 <div style="margin-top:4em; text-align:center;">
						  <a href="http://projects.elizabethslonaker.co/dd/index.php" style="color:gray;text-decoration:none">Website</a>
							&nbsp;&nbsp;
							<a href="http://projects.elizabethslonaker.co/dd/admin_login.php" style="color:gray;text-decoration:none;">Admin</a>
						 </div>
					</body>
					</html>
				';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .="From: donotreply@website";
			$mailSent = mail($to,$subject,$htmlContent,$headers);
			/* END OF EMAIL */


		if ($stmt_prepared == 1){
			if ($stmt->execute()){
				$output = "<p>Thank you for your submission! We will be in contact with you shortly, regarding the following details.</p>";
				foreach($expected as $key){
					$value = $_POST[$key];
					$output .= "<div><b>{$label[$key]}</b>: $value <br></div>";
				}
			} else {
				//$stmt->execute() failed.
				$output = "<p class='center'>Database operation failed. Please contact the webmaster.</p>";
			}
		} else {
			// statement is not successfully prepared (issues with the query).
			$output = "<p class='center>Database query failed. Please contact the webmaster.</p>";
		}
    $stmt->close();
    /* END OF FIRST SQL */

    /* SQL 2 FOR CONTACTLIST */
    $stmt = $conn->stmt_init();

      //insert into ContactList table
      $sql2 = "Insert Into contactList (firstName, lastName, Phone, Email) values (?, ?, ?, ?)";

      if($stmt->prepare($sql2)){
        // Note: user input could be an array, the code to deal with array values should be added before the bind_param statment.
        $stmt->bind_param('ssis', $firstName,
        $lastName, $phone, $email);
        $stmt_prepared = 1; // set up a variable to signal that the query statement is successfully prepared.
      }

      if ($stmt_prepared == 1){
        if ($stmt->execute()){
        } else {
          //$stmt->execute() failed.
          $output = "<p class='center'>Database operation failed. Please contact the webmaster.</p>";
        }
      } else {
          // statement is not successfully prepared (issues with the query).
          $output = "<p class='center>Database query failed. Please contact the webmaster.</p>";
      }

    $stmt->close();
    /* END OF SQL 2 */


	} else {
		// $missing is not empty
		$output = "<p>The following required fields are missing. Please fill them out! \n<ul>\n";
		foreach($missing as $m){
			$output .= "<li>{$label[$m]}\n";
		}
		$output .= "</ul></p>\n";
	}
}
?>

<main class="container">
    <?= $output ?>
</main>

<?php print $footer; ?>

</body>
</html>
