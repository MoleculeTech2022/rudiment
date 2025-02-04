<?php

include "dbcon.php";

if (isset($_POST['readmission_btn'])) {

    $sid = mysqli_real_escape_string($con, $_POST['sid']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $total_fees = mysqli_real_escape_string($con, $_POST['total_fees']);
    $student_class = mysqli_real_escape_string($con, $_POST['student_class']);
    $payamt = mysqli_real_escape_string($con, $_POST['payamt']);
    $paydate = mysqli_real_escape_string($con, $_POST['paydate']);
    $paymode = mysqli_real_escape_string($con, $_POST['paymode']);
    $feesplan = mysqli_real_escape_string($con, $_POST['feesplan']);

    $query = "INSERT INTO acdyear (acdyear,`sid`,class,total_fees,feesplan) VALUES ('$acdyear','$sid','$student_class','$total_fees','$feesplan')";

    $current_class_update = "UPDATE students SET current_class='$student_class' WHERE sid = '$sid'";

    $query_payment = "INSERT INTO payment (acdyear,`sid`,payamt,paydate,paymode) VALUES ('$acdyear','$sid','$payamt','$paydate','$paymode')";

    $query_run = mysqli_query($con, $query);
    $current_class_run = mysqli_query($con, $current_class_update);
    $query_payment = mysqli_query($con, $query_payment);

    if ($query_run && $query_payment && $current_class_run) {
        $_SESSION['message'] = "Work Added Successfully";
        header("Location: student-view.php?sid=$sid");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        header("Location: readmission_view.php?sid=$sid");
        exit(0);
    }

}

?>