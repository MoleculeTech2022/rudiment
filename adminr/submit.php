<?php
// Database connection settings
require "dbcon.php";

// Process form data and insert into tables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Student Information
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $dob = $_POST["dob"];
    $doa = $_POST["doa"];
    $saadhar = $_POST["saadhar"];
    $reg_num = $_POST["reg_num"];
    $classAadmitted = $_POST["classAadmitted"];
    $gender = $_POST["gender"]; // New field

    // Parent Information
    $faname = $_POST["faname"];
    $foccup = $_POST["foccup"];
    $fcontact = $_POST["fcontact"];
    $moname = $_POST["moname"];
    $moccup = $_POST["moccup"];
    $mcontact = $_POST["mcontact"];
    $padr = $_POST["padr"];
    $pdis = $_POST["pdis"];

    // Academic Year Information
    $total_fees = $_POST["total_fees"];
    $paid_fees = $_POST["paid_fees"]; // New field

    // Insert data into the respective tables
    $sql1 = "INSERT INTO students (fname, mname, lname, dob, doa, saadhar, reg_num, reg_class, gender)
             VALUES ('$fname', '$mname', '$lname', '$dob', '$doa', '$saadhar', '$reg_num', '$reg_class', '$gender')";

    $sql2 = "INSERT INTO parents (faname, foccup, fcontact, moname, moccup, mcontact, padr, pdis)
             VALUES ('$faname', '$foccup', '$fcontact', '$moname', '$moccup', '$mcontact', '$padr', '$pdis')";

    $sql3 = "INSERT INTO acdyear (acdyear, total_fees, paid_fees)
             VALUES ('$acdyear', '$total_fees', '$paid_fees')";

    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

}
?>
