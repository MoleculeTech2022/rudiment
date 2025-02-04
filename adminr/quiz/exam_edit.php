<?php

include "../dbcon.php";
// anotherfile.php

// Check if qid parameter is set in the URL
if (isset($_GET['exam_id'])) {
    // Get the qid(s) from the URL
    $exam_id = $_GET['exam_id'];

    echo $exam_id;

    $select_data = "SELECT * FROM create_exam WHERE exam_id = '$exam_id'";
    $run_data = mysqli_query($con, $select_data);
    if (mysqli_num_rows($run_data) > 0) {
        while ($rows = mysqli_fetch_assoc($run_data)) {

            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Exam Edit</title>
            </head>

            <body>
                <?php include "sidebar.html"; ?>

                <div class="container" style="margin-left:300px;margin-top:-30px;">
                    <h1>Update Test Details</h1>

                    <form action="quizdbcode.php" method="POST" style="margin-top:10px;">

                        <input type="hidden" name="exam_id" value="<?php echo $rows['exam_id']; ?>" placeholder="Exam Id"
                            style="margin-left:0px;margin-top:10px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                        <select type="text" name="student_class" value="<?php echo $rows['student_class']; ?>"
                            placeholder="student_class"
                            style="margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <option value="Select Student Class">Select Student Class</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                            <option value="5th">5th</option>
                        </select>
                        <br>
                        <input type="text" name="exam_name" value="<?php echo $rows['exam_name']; ?>" placeholder="Exam Name"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                        <div class="second-inner-div-container" style="margin-left:230px;margin-top:-103px;">

                            <input type="text" name="subject" value="<?php echo $rows['subject']; ?>" placeholder="Subject"
                                style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <br>
                            <input type="text" name="topic" value="<?php echo $rows['topic']; ?>" placeholder="Topic"
                                style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <br>
                        </div>
                        <textarea name="instructions" id="myTextarea" rows="4" cols="50" placeholder="Instructions"
                            style="margin-top:20px;width:440px;padding:10px;"><?php echo $rows['instructions']; ?></textarea>
                        <br>
                        <input type="text" name="total_que" value="<?php echo $rows['total_que']; ?>" placeholder="No Of Questions"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                        <input type="text" name="each_mark" value="<?php echo $rows['each_mark']; ?>" placeholder="Each Mark"
                            style="margin-left:15px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                        <br>
                        <div class="save-changes-btn" style="margin-top:10px;">
                            <button value="submit" name="editexambtn"
                                style="height:40px;width:150px;margin-top:10px;margin-left:0px;background-color:rgb(38, 244, 148);color:#fff;border:none;border-radius: 5px;">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </body>

            </html>

            <?php

        }
    }

}
?>