<?php
include "../dbcon.php";

// Define an associative array to store selected options with their question IDs
$selected_answers = array();
$correct_count = 0;
$wrong_count = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each submitted field
    foreach ($_POST as $key => $value) {
        // Check if the field name starts with 'q', indicating it's a question
        if (substr($key, 0, 1) === 'q') {
            // Extract the question ID from the field name
            $qid = substr($key, 1);
            // Store the question ID and the selected option in the array
            $selected_answers[$qid] = $value;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam</title>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php
        $array = array();
        $counter = 1;
        for ($i = 1; $i <= 30; $i++) {
            if ($counter > 5) {
                break;
            }

            $min = 1;
            $max = 5;
            $random_number = mt_rand($min, $max);

            if (in_array($random_number, $array)) {
                continue;
            } else {
                $save = $random_number;
                $array[] = $save;

                $select_question = "SELECT * FROM questionbank WHERE qid = '$random_number'";
                $question_run = mysqli_query($con, $select_question);
                if (mysqli_num_rows($question_run) > 0) {
                    while ($rows = mysqli_fetch_assoc($question_run)) {
                        echo "<h3>" . "Q. " . $counter . " " . $rows['question'] . "</h3>";
                        ?>
                        <input type="radio" name="q<?php echo $rows['qid']; ?>" value="<?php echo $rows['option_one']; ?>">
                        <?php echo "A. " . $rows['option_one']; ?>

                        <input type="radio" name="q<?php echo $rows['qid']; ?>" value="<?php echo $rows['option_two']; ?>">
                        <?php echo "B. " . $rows['option_two']; ?>

                        <input type="radio" name="q<?php echo $rows['qid']; ?>" value="<?php echo $rows['option_three']; ?>">
                        <?php echo "C. " . $rows['option_three']; ?>

                        <input type="radio" name="q<?php echo $rows['qid']; ?>" value="<?php echo $rows['option_four']; ?>">
                        <?php echo "D. " . $rows['option_four']; ?>


                        <?php

                        $counter++;
                    }
                }
            }
        }
        ?>

        <input type="submit" id="submitBtn" name="submit" value="Submit">
    </form>

    <?php


    // Display selected answers after form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h2>Selected Answers:</h2>";
        foreach ($selected_answers as $qid => $selected_answer) {


            $que = "SELECT answer FROM questionbank WHERE qid = '$qid'";
            $que_run = mysqli_query($con, $que);
            if (mysqli_num_rows($que_run) > 0) {
                while ($rue = mysqli_fetch_assoc($que_run)) {
                    $correct_ans = $rue['answer'];
                    if ($selected_answer == $correct_ans) {
                        echo "Question " . $qid . " : " . $selected_answer . " = Right " . "<br>";
                        echo "Correct Answer = " . $correct_ans . "<br>";
                        $correct_count++;
                    } else {
                        echo "Question " . $qid . " : " . $selected_answer . " = Wrong " . "<br>";
                        echo "Correct Answer = " . $correct_ans . "<br>";
                        $wrong_count++;
                    }


                    // echo "Question $qid: $selected_answer<br>";
                }
            }

        }
        echo "<h3>Correct Answers: $correct_count</h3>";
        echo "<h3>Wrong Answers: $wrong_count</h3>";
    }
    ?>
</body>

</html>