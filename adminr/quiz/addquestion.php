<?php
include "../dbcon.php";
include "sidebar.html";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question to Quesiton Bank</title>
</head>

<body>
    <div class="student-create-question-card"
        style="position:absolute;width:600px;height:470px;border-radius:5px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:280px;margin-top:-28px;">

        <div class="header" style="margin-top:10px;margin-left:10px;">
            <h3>Add Question To Question Bank</h3>
        </div>
        <br>
        <div class="materails">

            <form action="quizdbcode.php" method="POST">

                <div class="second-input" style="margin-left:10px;margin-top:0px;">
                    <input type="text" name="question" placeholder="Write Question Here"
                        style="margin-left:0px;margin-top:-10px;padding:5px;width:540px;border-radius:5px;border-width:1px;height:50px;">
                </div>


                <div class="first-input" style="display:flex;margin-left:10px;margin-top:-5px;">
                    <input type="text" name="option_one" id="option_one" placeholder="Option No 1"
                        style="margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">

                    <div class="second-input" style="margin-left:10px;margin-top:0px;">
                        <input type="text" name="option_two" placeholder="Option No 2"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">
                    </div>

                    <div class="third-input" style="margin-left:10px;margin-top:0px;">
                        <input type="text" name="option_three" placeholder="Option No 3"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">
                    </div>
                    <div class="fiffth-input" style="margin-left:10px;margin-top:0px;">
                        <input type="text" name="option_four" placeholder="Option No 4"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">
                    </div>

                </div>

                <div class="fiffth-input" style="margin-left:10px;margin-top:0px;">
                    <select name="answer" placeholder="Answer"
                        style="margin-left:0px;margin-top:20px;width:230px;border-radius:5px;border-width:1px;height:30px;">
                        <option value="Select Answer">Select Answer</option>
                        <option value="option_one">1</option>
                        <option value="option_two">2</option>
                        <option value="option_three">3</option>
                        <option value="option_four">4</option>
                </div>

                <div class="sixth_level" style="display:flex;">

                    <div class="fiffth-input" style="margin-left:10px;margin-top:0px;">
                        <textarea name="explanation" placeholder="Explanation Of Answer"
                            style="margin-left:0px;margin-top:20px;width:530px;border-radius:5px;border-width:1px;height:80px;"></textarea>

                    </div>
                </div>
                <br>
                <div class="class-input" style="margin-left:10px;margin-top:-23px;">
                    <select name="student_class" placeholder="Select Class"
                        style="margin-left:0px;margin-top:-20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">
                        <option value="Select Class">Select Class</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                    </select>
                    <select name="difficulty" placeholder="Select Difficulty"
                        style="margin-left:20px;margin-top:-20px;padding:5px;width:140px;border-radius:5px;border-width:1px;">
                        <option value="Select Difficulty">Select Difficulty</option>
                        <option value="practice">Very Easy</option>
                        <option value="easy">Easy</option>
                        <option value="normal">Normal</option>
                        <option value="hard">Hard</option>
                        <option value="extreme">Extreme</option>
                    </select>

                    <input type="text" name="subj" placeholder="Subject"
                        style="margin-left:10px;margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">

                    <input type="text" name="topic" placeholder="Topic"
                        style="margin-left:10px;margin-top:20px;padding:5px;width:130px;border-radius:5px;border-width:1px;">
                    <div class="topic-input" style="margin-left:10px;margin-top:0px;">
                    </div>

                </div>
                <br>
                <div class="buttons" style="display:flex;">

                    <div class="btn" style="margin-top:5px;">
                        <button value="submit" name="questionaddbtn"
                            style="height:40px;width:150px;margin-top:10px;margin-left:10px;background-color:rgb(244, 193, 38);color:#fff;border:none;border-radius: 5px;">Insert
                            Question</button>


                    </div>
                    <a href="question.php">
                        <button
                            style="height:40px;width:150px;margin-top:16px;margin-left:15px;background-color:rgb(196, 38, 244);color:#fff;border:none;border-radius: 5px;">Question
                            Bank</button>
                    </a>
                </div>

            </form>


        </div>


</body>

</html>