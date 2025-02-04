<?php

include "../dbcon.php";

if (isset($_POST['editexambtn'])) {

    $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
    $exam_name = mysqli_real_escape_string($con, $_POST['exam_name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $instructions = mysqli_real_escape_string($con, $_POST['instructions']);
    $topic = mysqli_real_escape_string($con, $_POST['topic']);
    $total_que = mysqli_real_escape_string($con, $_POST['total_que']);
    $each_mark = mysqli_real_escape_string($con, $_POST['each_mark']);
    $student_class = mysqli_real_escape_string($con, $_POST['student_class']);

    $query = "UPDATE create_exam SET exam_name='$exam_name', subject='$subject', instructions='$instructions', topic='$topic', total_que='$total_que',each_mark='$each_mark',student_class='$student_class' WHERE create_exam.exam_id = '$exam_id'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Test updaed successfully";
        header("Location: show_exam.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error : " . mysqli_error($con);
        header("Location: show_exam.php");
        exit(0);
    }

}


if (isset($_POST['addexambtn'])) {

    $qids = mysqli_real_escape_string($con, $_POST['qids']);
    $exam_name = mysqli_real_escape_string($con, $_POST['exam_name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $instructions = mysqli_real_escape_string($con, $_POST['instructions']);
    $topic = mysqli_real_escape_string($con, $_POST['topic']);
    $total_que = mysqli_real_escape_string($con, $_POST['total_que']);
    $each_mark = mysqli_real_escape_string($con, $_POST['each_mark']);
    $student_class = mysqli_real_escape_string($con, $_POST['student_class']);

    $query = "INSERT INTO create_exam (qids, exam_name, `subject`, instructions, topic,total_que,each_mark,student_class) 
    VALUES ('$qids', '$exam_name', '$subject', '$instructions', '$topic','$total_que','$each_mark','$student_class')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Question added successfully";
        header("Location: show_exam.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error : " . mysqli_error($con);
        header("Location: show_exam.php");
        exit(0);
    }

}

if (isset($_POST['questionaddbtn'])) {

    $question = mysqli_real_escape_string($con, $_POST['question']);
    $option_one = mysqli_real_escape_string($con, $_POST['option_one']);
    $option_two = mysqli_real_escape_string($con, $_POST['option_two']);
    $option_three = mysqli_real_escape_string($con, $_POST['option_three']);
    $option_four = mysqli_real_escape_string($con, $_POST['option_four']);
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $student_class = mysqli_real_escape_string($con, $_POST['student_class']);
    $difficulty = mysqli_real_escape_string($con, $_POST['difficulty']);
    $explanation = mysqli_real_escape_string($con, $_POST['explanation']);
    $topic = mysqli_real_escape_string($con, $_POST['topic']);
    $subj = mysqli_real_escape_string($con, $_POST['subj']);

    $query = "INSERT INTO questionbank (question, option_one, option_two, option_three, option_four,answer,explanation,student_class,difficulty,topic,subj) 
    VALUES ('$question', '$option_one', '$option_two', '$option_three', '$option_four', '$answer', '$explanation', '$student_class', '$difficulty', '$topic', '$subj')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Question added successfully";
        header("Location: addquestion.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error : " . mysqli_error($con);
        header("Location: addquestion.php");
        exit(0);
    }

}

?>