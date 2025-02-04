<?php
// database connection dbcon.php
require "dbcon.php";

// Update Expense
if (isset($_POST['edit_expense'])) {
    $expid = mysqli_real_escape_string($con, $_POST['expid']);

    $expAmt = mysqli_real_escape_string($con, $_POST['expAmt']);
    $expDate = mysqli_real_escape_string($con, $_POST['expDate']);
    $expMode = mysqli_real_escape_string($con, $_POST['expMode']);
    $expCatgid = mysqli_real_escape_string($con, $_POST['expCatgid']);

    //  $query = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' WHERE id='$student_id' ";
    $sqlExpense = "UPDATE expense SET expAmt='$expAmt',expDate='$expDate',expMode='$expMode',expCatgid='$expCatgid' WHERE  expid = '$expid' ";
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


// insert query to expense table
if (isset($_POST['ExpenseAddBtn'])) {

    $expcatgid = mysqli_real_escape_string($con, $_POST['expCatgId']);
    $expAmt = mysqli_real_escape_string($con, $_POST['expAmt']);
    $expMode = mysqli_real_escape_string($con, $_POST['expMode']);
    $expDate = mysqli_real_escape_string($con, $_POST['expDate']);
    $details = mysqli_real_escape_string($con, $_POST['details']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $month = date("M");

    $query = "INSERT INTO expense (expcatgid,expAmt,expMode,expDate,acdyear,`month`,details) VALUES ('$expcatgid','$expAmt','$expMode','$expDate','$acdyear','$month','$details')";

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

if (isset($_POST['add_temp_btn'])) {

    $sid = mysqli_real_escape_string($con, $_POST['sid']);
    $text_one = mysqli_real_escape_string($con, $_POST['text_one']);
    $text_two = mysqli_real_escape_string($con, $_POST['text_two']);
    $text_three = mysqli_real_escape_string($con, $_POST['text_three']);

    $query = "INSERT INTO temporary (`sid`,text_one,text_two,text_three) VALUES ('$sid','$text_one','$text_two','$text_three')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Work Added Successfully";
        header("Location: temporary.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        header("Location: temp_add.php");
        exit(0);
    }

}

if (isset($_POST['edit_temp_btn'])) {

    $temp_id = mysqli_real_escape_string($con, $_POST['temp_id']);
    $text_one = mysqli_real_escape_string($con, $_POST['text_one']);
    $text_two = mysqli_real_escape_string($con, $_POST['text_two']);
    $text_three = mysqli_real_escape_string($con, $_POST['text_three']);

    $query = "UPDATE temporary SET text_one = '$text_one', text_two = '$text_two', text_three = '$text_three' WHERE temporary.temp_id = '$temp_id'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Work Added Successfully";
        header("Location: temporary.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created";
        header("Location: temp_add.php");
        exit(0);
    }

}


?>