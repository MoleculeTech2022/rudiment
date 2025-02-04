<?php
include "../dbcon.php";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Exam</title>
</head>

<body>

    <?php include "sidebar.html"; ?>

    <div class="second-header-content" id="second-header-content" style="margin-top:-25px;margin-left:300px;">

        <h1>Test created successfully</h1>

        <div class="second-header-button-content" style="margin-top:-42px;margin-left:627px;">
            <?php
            $exam_id = "SELECT max(exam_id) AS max_qid FROM create_exam";
            $exam_id_run = mysqli_query($con, $exam_id);
            if (mysqli_num_rows($exam_id_run) > 0) {
                while ($rows = mysqli_fetch_assoc($exam_id_run)) {
                    $max_exam_id = $rows['max_qid'];
                    ?>
                    <a href="exam_edit.php?exam_id=<?php echo $max_exam_id; ?>" style="text-decoration: none;">
                        <button
                            style="height:40px;width:130px;margin-top:0px;margin-left:0px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">Do
                            changes</button>
                    </a>
                    <?php
                }
            }
            ?>
            <a href="question.php">
            <button
                style="height:40px;width:130px;margin-top:0px;margin-left:10px;background-color:rgb(38, 244, 148);color:#fff;border:none;border-radius: 5px;">Confirmed</button>
            </a>
        </div>

    </div>

    <div class="test-paper-container" id="test-paper-container"
        style="position: absolute;width:900px;height:328px;background-color:#fff;border: 1px solid #000;margin-left:300px;margin-top:20px;border-radius:2px;align-items: center;">

        <?php

        $select_max_qid_test = "SELECT max(exam_id) AS max_qid FROM create_exam";
        $max_qid_run = mysqli_query($con, $select_max_qid_test);
        if (mysqli_num_rows($max_qid_run) > 0) {
            while ($rows = mysqli_fetch_assoc($max_qid_run)) {
                $max_qid = $rows['max_qid'];

                $select_test = "SELECT * FROM create_exam WHERE exam_id = '$max_qid'";
                $select_test_run = mysqli_query($con, $select_test);
                if (mysqli_num_rows($select_test_run) > 0) {
                    while ($rows = mysqli_fetch_assoc($select_test_run)) {
                        ?>


                        <div class="test-header-content" style="margin-top:17px;">
                            <h2 style="margin-left:220px;color:turquoise;">
                                RUDIMENT INTERNATIONAL SCHOOL
                                </h1>
                                <h1 style="margin-left:320px;">
                                    <?php echo $rows['exam_name']; ?>
                                </h1>
                                <h4 style="margin-left:365px;margin-top:6px;">Sub -
                                    <?php echo $rows['subject']; ?>
                                </h4>

                                <div class="test-second-header-content" style="margin-left:13px;margin-top:-26px;">
                                    <h4 style="margin-top:6px;">Class :
                                        <?php echo $rows['student_class']; ?>
                                    </h4>
                                    <h4 style="margin-top:6px;">Date :
                                        <?php echo date('d-m-y'); ?>
                                    </h4>
                                </div>

                                <div class="test-third-header-content" style="margin-left:710px;margin-top:-58px;">
                                    <h4 style="margin-top:6px;">Total Questions :
                                        <?php echo $rows['total_que']; ?>
                                    </h4>
                                    <h4 style="margin-top:6px;margin-left:1px;">Total Mark :
                                        <?php
                                        $each_mark = $rows['each_mark'];
                                        $mul = $rows['each_mark'] * $rows['total_que'];
                                        echo $mul;
                                        ?>
                                    </h4>
                                </div>

                        </div>

                        <hr style="margin-top:10px;">

                        <div class="instruction-div-content" style="position: absolute;">
                            <div class="instruction-heading" style="margin-top:10px;margin-left:10px;">
                                <h3>Instructions :-</h3>
                            </div>
                            <div class="instruction-notice">
                                <span style="margin-left:10px;">
                                    <?php echo $rows['instructions'] ?>
                                </span>
                            </div>
                        </div>
                        <hr style="margin-top:150px;">

                        <div class="fourth-questions-cotent">
                            <?php
                            $qids = $rows['qids']; // Assuming $rows['qids'] contains the string '4,5,6,7,8'
            
                            // Split the string into an array using comma as the delimiter
                            $qidArray = explode(',', $qids);

                            // Now $qidArray will contain individual qids as separate elements
// You can access each qid using array indexing
            
                                    $counter = 0;
                            foreach ($qidArray as $qid) {
                                // echo "Question ID:" . $qid . "<br>";
                                $select_questions = "SELECT * FROM questionbank WHERE qid = '$qid'";
                                $question_run = mysqli_query($con, $select_questions);
                                if (mysqli_num_rows($question_run) > 0) {
                                    while ($question = mysqli_fetch_assoc($question_run)) {
                                        ?>
                                        <div class="question-div" style="margin-top:23px;margin-top:20px;">
                                            <h2 style="margin-left:30px;">Q. 
                                                <?php echo $counter + 1 . ". " . $question['question']; ?>
                                            
                                            </h2>
                                        </div>
                                        <div class="options-div" style="margin-left:30px;margin-top:20px;">
                                            <span>
                                                <?php echo "A. " . $question['option_one']; ?>
                                            </span>
                                            <span style="margin-left:100px;">
                                                <?php echo "B. " . $question['option_two']; ?>
                                            </span>
                                            <span style="margin-left:100px;">
                                                <?php echo "C. " . $question['option_three']; ?>
                                            </span>
                                            <span style="margin-left:100px;">
                                                <?php echo "D. " . $question['option_four']; ?>
                                            </span>
                                        </div>
                                        <?php
                                        $counter++;
                                    }
                                }
                            }

                            ?>

                        </div>

                    </div>



                    <?php
                    }
                }

            }
        }

        ?>

</body>

</html>