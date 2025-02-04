<?php

include 'dbcon.php';

$response = array();

if($_POST['fname']) {
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

    // additional fields
    $for_school = $_POST['for_school'];
    $father_job = $_POST['father_job'];
    $mother_job = $_POST['mother_job'];
    $family_income = $_POST['family_income'];
    $family_details = $_POST['family_details'];
    $house_type = $_POST['house_type'];
    $tuition = $_POST['tuition'];
    $region = $_POST['region'];
    $details = $_POST['details'];
    $age = $_POST['age'];

    $stmt = $conn->prepare("INSERT INTO `normal_list`(`fname`, `mname`, `lname`, `faname`, `moname`, `fcontact`, `mcontact`, `school`, `forclass`, `meet_date`, `address`, `for_school`, `father_job`, `mother_job`, `family_income`, `family_details`, `house_type`, `region`, `tuition`, `details`,`age`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    if (!$stmt) {
        $response['error'] = true;
        $response['message'] = "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $stmt->bind_param("sssssssssssssssssssss", $fname, $mname, $lname, $faname, $moname, $fcontact, $mcontact, $school, $forclass, $meet_date, $address, $for_school, $father_job, $mother_job, $family_income, $family_details, $region, $house_type, $tuition, $details,$age);

        if($stmt->execute()) {
            $response['error'] = false;
            $response['message'] = "Student Added Successfully!";
        } else {
            $response['error'] = true;
            $response['message'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $response['error'] = true;
    $response['message'] = "Please Fill in All the Details";
}

// Close the connection
$conn->close();

echo json_encode($response);
?>
