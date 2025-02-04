<?php

include 'dbcon.php';

// $servername = "localhost";

// // for testing the user name is root. 
// $username = "root";

// // the password for testing is "blank"
// $password = "";

// // below is the name for our 
// // database which we have added. 
// $dbname = "marketing";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// an array to display response
$response = array();
// on below line we are checking if the body provided by user contains 
// this keys as course name,course description and course duration
if ($_POST['fname'] && $_POST['mname'] && $_POST['lname'] && $_POST['faname'] && $_POST['moname'] && $_POST['fcontact'] && $_POST['mcontact'] && $_POST['school'] && $_POST['forclass'] && $_POST['meet_date'] && $_POST['address']) {
	// if above three parameters are present then we are extracting values 
	// from it and storing it in new variables.
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$faname = $_POST['faname'];
	$moname = $_POST['moname'];
	$fcontact = $_POST['fcontact'];
	$mcontact = $_POST['mcontact'];
	$school = $_POST['school'];
	$forclass = $_POST['forclass'];
	$meet_date = $_POST['meet_date'];
	$address = $_POST['address'];
	// after that we are writing an sql query to 
	// add this data to our database.
	// on below line make sure to add your table name 
	// in previous article we have created our table name
	// as courseDb and add all column headers to it except our id. 
	$stmt = $conn->prepare("INSERT INTO `prospect_list`(`fname`, `mname`, `lname` , `faname` , `moname`, `fcontact`, `mcontact`, `school`, `forclass`, `meet_date`, `address`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssssssss", $fname, $mname, $lname, $faname, $moname, $fcontact, $mcontact, $school, $forclass, $meet_date, $address);
	// on below line we are checking if our sql query is executed successfully.
	if ($stmt->execute() == TRUE) {
		// if the script is executed successfully we are 
		// passing data to our response object
		// with a success message.
		$response['error'] = false;
		$response['message'] = "Student Added To Master List successfully!";
	} else {
		// if we get any error we are passing error to our object.
		$response['error'] = true;
		$response['message'] = "failed\n " . $conn->error;
	}
} else {
	// this method is called when user
	// donot enter sufficient parameters. 
	$response['error'] = true;
	$response['message'] = "Insufficient parameters";
}
// at last we are printing our response which we get. 
echo json_encode($response);
?>