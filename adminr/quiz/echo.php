<?php

include "../dbcon.php";
// anotherfile.php

// Check if qid parameter is set in the URL
if (isset($_GET['qid'])) {
    // Get the qid(s) from the URL
    $qids = $_GET['qid'];

    // Split the qid(s) into an array
    $qidArray = explode(',', $qids);
    // Separate qids into different variables

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Test</title>

    </head>

    <body>

        <?php include "sidebar.html"; ?>


        <div id="container" class="container" style="margin-left:300px;margin-top:-22px;">


            <h1>Create Test</h1>

            <form action="quizdbcode.php" method="POST">

                <input type="text" name="qids" value="<?php echo $qids; ?>" placeholder="qids"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <br>
                <input type="text" name="exam_name" placeholder="Exam Name"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <div class="second-inner-div-container" style="margin-left:230px;margin-top:-103px;">

                    <input type="text" name="subject" placeholder="Subject"
                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    <br>
                    <input type="text" name="topic" placeholder="Topic"
                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    <br>
                </div>
                <textarea name="instructions" id="myTextarea" rows="4" cols="50" placeholder="Instructions"
                    style="margin-top:20px;width:440px;padding:10px;"></textarea>
                <br>
                <input type="text" name="total_que" placeholder="No Of Questions"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <input type="text" name="each_mark" placeholder="Each Mark"
                    style="margin-left:15px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <select type="text" name="student_class" placeholder="Student Class"
                    style="margin-left:15px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    <option value="Select Student Class">Select Student Class</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                    <option value="5th">5th</option>
                </select>
                <br>
                <a href="show_exam.php">
                    <button value="submit" name="addexambtn"
                        style="height:40px;width:150px;margin-top:10px;margin-left:0px;background-color:rgb(38, 244, 148);color:#fff;border:none;border-radius: 5px;">Insert
                        Test</button>
                </a>
            </form>
        </div>

        <?php
}
?>
</body>
<script>
    document.getElementById('container').style.display = "block";
    document.getElementById('test-paper-container').style.display = "none";
    document.getElementById('test-paper-container').style.display = "none";
    function changeblock() {
        document.getElementById('container').style.display = "block";
        document.getElementById('test-paper-container').style.display = "none";
        document.getElementById('test-paper-container').style.display = "none";

    }
</script>

</html>