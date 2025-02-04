<?php
// Database Connection
include 'dbcon.php';

// Student Admission PHP Code File: admission.php
if (isset($_POST['add_button'])) {
    // Students Table Fields
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $mname = mysqli_real_escape_string($con, $_POST['mname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $reg_num = "None"; // Default value
    $classAdmitted = mysqli_real_escape_string($con, $_POST['classAdmitted']);
    $saadhar = mysqli_real_escape_string($con, $_POST['saadhar']);
    $religion = mysqli_real_escape_string($con, $_POST['religion']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $caste = mysqli_real_escape_string($con, $_POST['caste']);
    
    // Parents Table Fields
    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $padr = mysqli_real_escape_string($con, $_POST['padr']);
    $pdis = mysqli_real_escape_string($con, $_POST['pdis']);
    $local_addr = mysqli_real_escape_string($con, $_POST['local_addr']);
    $pstate = mysqli_real_escape_string($con, $_POST['pstate']);

    // Payment Table Fields
    $total_fees = mysqli_real_escape_string($con, $_POST['total_fees']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']); // Changed variable name
    $doa = mysqli_real_escape_string($con, $_POST['doa']); // Changed variable name
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $fees_plan = mysqli_real_escape_string($con, $_POST['fees_plan']);
    $fees_title = mysqli_real_escape_string($con, $_POST['fees_title']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);

    $lclass = "None";

    // Student Query
    $student_details_adding_query = "INSERT INTO students
    (fname, mname, lname, dob, gender, reg_num, classAdmitted, current_class, saadhar, religion, category, caste, doa) 
    VALUES ('$fname', '$mname', '$lname', '$dob', '$gender', '$reg_num', '$classAdmitted', '$classAdmitted', '$saadhar', '$religion', '$category', '$caste', '$doa')";
    $student_query_running = mysqli_query($con, $student_details_adding_query);

    // Get Maximum Sid For Other Queries
    $student_max_sid_query = "SELECT MAX(sid) AS max_sid FROM students";
    $running_max_sid = mysqli_query($con, $student_max_sid_query);
    $row_max_sid = mysqli_fetch_assoc($running_max_sid);
    $student_id = $row_max_sid['max_sid'];

    // Parent Query
    $parent_details_adding_query = "INSERT INTO parents
    (sid, faname, foccup, fcontact, moname, moccup, mcontact, padr, pdis, local_addr, pstate)
    VALUES ('$student_id', '$faname', '$foccup', '$fcontact', '$moname', '$moccup', '$mcontact', '$padr', '$pdis', '$local_addr', '$pstate')";
    $parent_query_running = mysqli_query($con, $parent_details_adding_query);

    // Payment Query
    $payment_details_adding_query = "INSERT INTO payment
    (sid, acdyear, payamt, paydate, feestitle, paymode)
    VALUES ('$student_id', '$acdyear', '$payamt', '$doa', '$fees_title', '$paymode')";
    $payment_query_running = mysqli_query($con, $payment_details_adding_query);

    // Acdyear Query
    $acdyear_details_adding_query = "INSERT INTO acdyear
    (sid, acdyear, class, total_fees, feesplan)
    VALUES ('$student_id', '$acdyear', '$classAdmitted', '$total_fees', '$fees_plan')";
    $acdyear_query_running = mysqli_query($con, $acdyear_details_adding_query);

    if ($student_query_running && $parent_query_running && $payment_query_running && $acdyear_query_running) {
        echo "Data Inserted Successfully!";
        header("Location: student-view.php?sid=$student_id");
        exit; // Ensure no further output is sent
    } else {
        echo "Data Not Inserted!. Error: " . mysqli_error($con);
    }
}


// Payment Edit Update ...payment_edit.php
if (isset($_POST['payment_edit'])) {
    $payid = mysqli_real_escape_string($con, $_POST['payid']);
    $sid = mysqli_real_escape_string($con, $_POST['sid']);
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $feestitle = mysqli_real_escape_string($con, $_POST['feestitle']);


    // Update Payment Details
    $payment_edit_query = "UPDATE `payment` SET `acdyear`='$acdyear',`payamt`='$payamt',`paymode`='$paymode',`paydate`='$paydate',`feestitle`='$feestitle' WHERE payid = $payid";
    $payment_edit_running = mysqli_query($con, $payment_edit_query);

    if ($payment_edit_running) {
        echo "Payment Edited Successfully!";
        header("Location: payment_due.php?sid=$sid");
        exit; // Ensure no further output is sent
    } else {
        echo "Data Not Updated !. Error: " . mysqli_error($con);
    }

}


// Insert or Make Payment  ...make_payment.php
if (isset($_POST['insert_payment'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $fees_title = mysqli_real_escape_string($con, $_POST['fees_title']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
   


    // Update Payment Details
    $payment_insert_query = "INSERT INTO `payment`(`acdyear`, `sid`, `payamt`, `paymode`, `paydate`,  `feestitle`  ) VALUES ('$acdyear','$student_id','$payamt','$paymode','$paydate','$fees_title')";
    $payment_insert_running = mysqli_query($con, $payment_insert_query);

    if ($payment_insert_running) {
        echo "Payment Inserted Successfully!";
        header("Location: payment_due.php?sid=$student_id");
        exit; // Ensure no further output is sent
    } else {
        echo "Payment Not Inserted!. Error: " . mysqli_error($con);
    }

}


// Update Total Fees 
if(isset($_POST['total_fees_edit_btn'])){
    
    $aid = mysqli_real_escape_string($con, $_POST['aid']);
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $total_fees = mysqli_real_escape_string($con, $_POST['total_fees']);

    // Update Total Fees 
    $totalFees_update_query = "UPDATE acdyear SET `total_fees` = '$total_fees'  WHERE aid = '$aid' AND acdyear = '$acdyear' AND sid = '$student_id';";
    $$totalFees_update_running = mysqli_query($con, $totalFees_update_query);

    if ($$totalFees_update_running) {
        echo "Payment Inserted Successfully!";
        header("Location: payment_due.php?sid=$student_id");
        exit; // Ensure no further output is sent
    } else {
        echo "Total Fees Not Inserted!. Error: " . mysqli_error($con);
    }
}


?>
