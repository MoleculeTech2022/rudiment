<?php
// database connection (required)
require "dbcon.php";

// Payment Insert Code Block student-view.php
if (isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);

    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $feestitle = mysqli_real_escape_string($con, $_POST['feestitle']);

    $sqlAddPayment = "INSERT INTO hpayment (sid,payamt,paydate,paymode,acdyear,feestitle) VALUES (' $student_id','$payamt','$paydate','$paymode','$acdyear','$feestitle')";

    $resultAddPayment = mysqli_query($con, $sqlAddPayment);
    if ($resultAddPayment) {
        $_SESSION['message'] = "Student Created Successfully";
        header("Location: student-view.php?sid= $student_id");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        header("Location: student-view.php?sid= $student_id");
        exit(0);
    }

}


// Payment Insert Code Block payments.php
if (isset($_POST['update_payment'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);

    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $feestitle = mysqli_real_escape_string($con, $_POST['feestitle']);

    $sqlInsertPayment = "INSERT INTO hpayment (sid,payamt,paydate,paymode,acdyear,feestitle) VALUES (' $student_id','$payamt','$paydate','$paymode','$acdyear','$feestitle')";

    $resultInsertPayment = mysqli_query($con, $sqlInsertPayment);
    if ($resultInsertPayment) {
        $_SESSION['message'] = "Payment recorded successfully";
        header("Location: payments.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: payments.php");
        exit(0);
    }

}


// students edit details students.php to student-edit.php
if (isset($_POST['edit_student_details'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);

    // Student Details
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $mname = mysqli_real_escape_string($con, $_POST['mname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $classAdmitted = mysqli_real_escape_string($con, $_POST['classAdmitted']);

    // Parent Details
    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $padr = mysqli_real_escape_string($con, $_POST['padr']);
    $pdis = mysqli_real_escape_string($con, $_POST['pdis']);
    $total_fees = mysqli_real_escape_string($con, $_POST['total_fees']);

    // Update query for student
    $sqlStudentUPDATE = "UPDATE hstudents SET fname='$fname', mname = '$mname',lname = '$lname', classAdmitted = '$classAdmitted' WHERE sid ='$student_id' ";

    // Update query for parent
    $sqlParentUPDATE = "UPDATE hparents SET faname='$faname', foccup='$foccup' , fcontact='$fcontact' , moname='$moname' , moccup='$moccup' , mcontact='$mcontact' , padr='$padr' , pdis='$pdis' WHERE sid='$student_id' ";

    // Update query for parent
    $sqlAcdyearUPDATE = "UPDATE hacdyear SET total_fees='$total_fees' WHERE sid='$student_id' ";

    $resultStudentUPDATE = mysqli_query($con, $sqlStudentUPDATE);
    $resultParentUPDATE = mysqli_query($con, $sqlParentUPDATE);
    $resultParentUPDATE = mysqli_query($con, $sqlAcdyearUPDATE);

    if ($resultStudentUPDATE && $resultParentUPDATE && $resultParentUPDATE) {
        $_SESSION['message'] = "Student Updated Successfully";
        header("Location: student-view.php?sid= $student_id");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Updated";
        header("Location: student-view.php?sid= $student_id");
        exit(0);
    }

}

// update student payment form on payments.php to payment_edit.php
if (isset($_POST['edit_payment'])) {
    $sid = mysqli_real_escape_string($con, $_POST['sid']);
    $payid = mysqli_real_escape_string($con, $_POST['payid']);
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $feestitle = mysqli_real_escape_string($con, $_POST['feestitle']);

    // query for edit payment
    $edit_payment_query = "UPDATE hpayment SET payamt='$payamt', paydate='$paydate', paymode='$paymode', acdyear='$acdyear', feestitle='$feestitle' WHERE payid='$payid'";

    $query_run = mysqli_query($con, $edit_payment_query);

    if ($query_run) {
        $_SESSION['message'] = "Payment Updated Successfully";
        header("Location: payment_due.php?sid=$sid");
        exit();
    } else {
        $_SESSION['message'] = "Payment Update Failed";
        header("Location: payment_due.php?sid=$sid");
        exit();
    }


} else {
    // nothing
}


// feedback Insert Code Block feedback.php
if (isset($_POST['add_feedback'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);

    $feedsub = mysqli_real_escape_string($con, $_POST['feedsub']);
    $feeddate = mysqli_real_escape_string($con, $_POST['feeddate']);
    $feedteacher = mysqli_real_escape_string($con, $_POST['feedteacher']);
    $feedtitle = mysqli_real_escape_string($con, $_POST['feedtitle']);
    $feeddetail = mysqli_real_escape_string($con, $_POST['feeddetail']);

    $query = "INSERT INTO hfeedback (sid,feedsub,feeddate,feedteacher,feedtitle,feeddetail) VALUES (' $student_id','$feedsub','$feeddate','$feedteacher','$feedtitle','$feeddetail')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Feedback added successfully";
        header("Location: feedback.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: feedback.php");
        exit(0);
    }

}


// feedback edit Code Block edit_feedback.php
if (isset($_POST['edit_feedback'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);

    $feedsub = mysqli_real_escape_string($con, $_POST['feedsub']);
    $feeddate = mysqli_real_escape_string($con, $_POST['feeddate']);
    $feedteacher = mysqli_real_escape_string($con, $_POST['feedteacher']);
    $feedtitle = mysqli_real_escape_string($con, $_POST['feedtitle']);
    $feeddetail = mysqli_real_escape_string($con, $_POST['feeddetail']);

    $query = "UPDATE hfeedback SET feedsub='$feedsub', feeddate='$feeddate', feedteacher='$feedteacher', feedtitle='$feedtitle',feeddetail='$feeddetail'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Feedback added successfully";
        header("Location: feedback.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: feedback.php");
        exit(0);
    }

}

// new admission code php code admission.php
if (isset($_POST['add_button'])) {
    // students table fields to insert
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $mname = mysqli_real_escape_string($con, $_POST['mname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $doa = mysqli_real_escape_string($con, $_POST['doa']);
    $saadhar = mysqli_real_escape_string($con, $_POST['saadhar']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $reg_num = mysqli_real_escape_string($con, $_POST['reg_num']);
    $classAdmitted = mysqli_real_escape_string($con, $_POST['classAdmitted']);

    // parents table fields to insert
    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $padr = mysqli_real_escape_string($con, $_POST['padr']);
    $pdis = mysqli_real_escape_string($con, $_POST['pdis']);

    // acdyear table fields
    $total_fees = mysqli_real_escape_string($con, $_POST['total_fees']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);

    // payment table paid fees entry
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);

    // students insert query
    $sqlStudents = "INSERT INTO hstudents (fname, mname, lname, dob, doa, saadhar, gender, reg_num, classAdmitted) VALUES ('$fname', '$mname', '$lname', '$dob', '$doa', '$saadhar', '$gender', '$reg_num', '$classAdmitted')";
    $students_run = mysqli_query($con, $sqlStudents);

    // Fetch sid 
    $sqlfetchsid = "SELECT MAX(sid) AS student_maxid FROM hstudents";
    $resultfetchsid = mysqli_query($con, $sqlfetchsid);
    if (mysqli_num_rows($resultfetchsid) > 0) {
        while ($rowsfetchsid = mysqli_fetch_assoc($resultfetchsid)) {
            $student_maxid = $rowsfetchsid['student_maxid'];
        }
    }

    // parents insert query
    $parents = "INSERT INTO hparents (`sid`, faname, foccup, fcontact, moname, moccup, mcontact, padr, pdis) VALUES ('$student_maxid', '$faname', '$foccup', '$fcontact', '$moname', '$moccup', '$mcontact', '$padr', '$pdis')";

    // acdyear insert query
    $acdyear = "INSERT INTO hacdyear (`sid`, acdyear, total_fees, feesplan) VALUES ('$student_maxid', '$acdyear', '$total_fees', '$feesplan')";

    // ... (previous code)

    // payment insert query
    // $payment = "INSERT INTO hpayment (`sid`, acdyear, payamt, paydate) VALUES ('$student_maxid', '$acdyear', '$payamt', '$doa')";
    $payment = "INSERT INTO hpayment (`sid`, acdyear,payamt,paydate,paymode) VALUES ('$student_maxid', '2023-24', '$payamt','$doa','$paymode')";

    $parents_run = mysqli_query($con, $parents);
    $acdyear_run = mysqli_query($con, $acdyear);
    $payment_run = mysqli_query($con, $payment);

    if ($students_run && $parents_run && $acdyear_run && $payment_run) {
        $_SESSION['message'] = "Student Created Successfully";
        header("Location: student-view.php?sid=$student_maxid");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        // Implement error handling/logging here
        header("Location: student-view.php?sid=$student_maxid");
        exit(0);
    }

}

// php to change default academic year settings.php
if (isset($_POST['set_button'])) {

    $default_acdyear = mysqli_real_escape_string($con, $_POST['default_acdyear']);

    $query = "UPDATE dacdyear SET default_acdyear='$default_acdyear'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Feedback added successfully";
        header("Location: settings.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: settings.php");
        exit(0);
    }

}


// insert query to expense table
if (isset($_POST['add_expense'])) {

    $expCatgid = mysqli_real_escape_string($con, $_POST['expCatgid']);
    $expamt = mysqli_real_escape_string($con, $_POST['expamt']);
    $expmode = mysqli_real_escape_string($con, $_POST['expmode']);
    $expdate = mysqli_real_escape_string($con, $_POST['expdate']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);

    $query = "INSERT INTO hexpense (expCatgid,expAmt,expMode,expDate,acdyear) VALUES (' $expCatgid','$expamt','$expmode','$expdate','$acdyear')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Student Created Successfully";
        header("Location: expense.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        header("Location: expense.php");
        exit(0);
    }

}

?>