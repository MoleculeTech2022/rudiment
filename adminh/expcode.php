<?php
// database connection dbcon.php
require "dbcon.php";

if (isset($_POST['edit_expense'])) {
    $expid = mysqli_real_escape_string($con, $_POST['expid']);

    $expAmt = mysqli_real_escape_string($con, $_POST['expAmt']);
    $expDate = mysqli_real_escape_string($con, $_POST['expDate']);
    $expMode = mysqli_real_escape_string($con, $_POST['expMode']);
    $expCatgid = mysqli_real_escape_string($con, $_POST['expCatgid']);

    //  $query = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' WHERE id='$student_id' ";
    $sqlExpense = "UPDATE hexpense SET expAmt='$expAmt',expDate='$expDate',expMode='$expMode',expCatgid='$expCatgid' WHERE  expid = '$expid' ";
    $resultExpense = mysqli_query($con, $sqlExpense);

    if ($resultExpense) {
        $_SESSION['message'] = "Student Updated Successfully";
        header("Location: expense.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Updated";
        header("Location: expense.php");
        exit(0);
    }

}

?>