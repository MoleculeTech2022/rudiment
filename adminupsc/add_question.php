<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
        }
        .side-panel {
            width: 20%;
            background-color: #64b2b9;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px;
            box-shadow: 2px 0 5px rgba(203, 160, 160, 0.1);
        }
        .side-panel .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .side-panel .button {
            background-color: #70305b;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            width: 100%;
            text-align: center;
            margin: 10px 0;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .side-panel .button:hover {
            background-color: #555;
        }
        .main-content {
            width: 90%;
            padding: 20px;
            margin-left: 1%;
        }
        .header {
            background: linear-gradient(to right, #FFFF00, #FFD700);
            color: rgb(127, 9, 9);
            text-align: center;
            padding: 7px;
        }
        .header h1 {
            margin: 0;
        }
        .form-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>


<div class="main-content">
    <div class="header">
        <h1>Insert Question</h1>
    </div>
    <div class="form-container">
        <form action="insert_question.php" method="POST">
            <div class="form-group">
                <label for="question">Question</label>
                <textarea id="question" name="question" required style="height: 150px;"></textarea>
            </div>
            <div class="form-group">
                <label for="option_a">Option A</label>
                <input type="text" id="option_a" name="option_a" required>
            </div>
            <div class="form-group">
                <label for="option_b">Option B</label>
                <input type="text" id="option_b" name="option_b" required>
            </div>
            <div class="form-group">
                <label for="option_c">Option C</label>
                <input type="text" id="option_c" name="option_c" required>
            </div>
            <div class="form-group">
                <label for="option_d">Option D</label>
                <input type="text" id="option_d" name="option_d" required>
            </div>
            <div class="form-group">
    <label for="correct_option">Correct Option</label>
    <select id="correct_option" name="correct_option" required>
        <option value="" disabled selected>Select the correct option</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
</div>

            <div class="form-group">
                <label for="explanation">Explanation - To the point</label>
                <textarea id="explanation" name="explanation" style="height: 150px;"></textarea>
            </div>
            <div class="form-group">
                <label for="question_notes">Detailed Explanation</label>
                <textarea id="question_notes" name="question_notes" style="height: 150px;"></textarea>
            </div>
            <div class="form-group">
                <label for="question_image">Question Image (URL)</label>
                <input type="text" id="question_image" name="question_image">
            </div>
            <div class="form-group">
                <label for="question_exam">Exam Name</label>
                <select id="question_exam" name="question_exam" required>
                    <option value="">-- Select an Option --</option>
                    <option value="all_civil_services">All Civil Services Exam</option>
                    <option value="upsc_only">UPSC Only</option>
                    <option value="bpsc_only">BPSC Only</option>
                    <option value="uppcs_only">UPPCS Only</option>
                    <option value="ras_only">RAS Only</option>
                    <option value="hcs_only">HCS Only</option>
                    <option value="mppcs_only">MPPCS Only</option>
                    <option value="ukpcs_only">UKPCS Only</option>
                    <option value="mpsc_only">MPSC Only</option>
                    <option value="cgl_only">CGL Only</option>
                </select>
            </div>
            <div class="form-group">
                <label for="question_subject">Question Subject</label>
                <select id="question_subject" name="question_subject" required>
                    <option value="">-- Select an Option --</option>
                    <option value="current_affairs_2025">Current Affairs 2025</option>
                    <option value="history">History</option>
                    <option value="polity">Polity</option>
                    <option value="geography">Geography</option>
                    <option value="economics">Economics</option>
                    <option value="science">Science</option>
                    <option value="maths">Maths</option>
                    <option value="reasoning">Reasoning</option>
                    <option value="bihar_special">Bihar Special</option>
                    <option value="up_special">UP Special</option>
                    <option value="uttarakhand_special">Uttarakhand Special</option>
                    <option value="mp_special">MP Special</option>
                    <option value="maharashtra_special">Maharashtra Special</option>
                    <option value="english">English</option>
                    <option value="hindi">Hindi</option>
                    <option value="current_affairs_2024">Current Affairs 2024</option>
                </select>
            </div>
            <div class="form-group">
                <label for="question_chapter">Question Chapter</label>
                <input type="text" id="question_chapter" name="question_chapter" required>
            </div>
            <div class="form-group">
                <label for="question_topic">Question Topic</label>
                <input type="text" id="question_topic" name="question_topic">
            </div>
            <div class="form-group">
                <label for="question_ref">Question Reference</label>
                <input type="text" id="question_ref" name="question_ref" required>
            </div>
            <div class="form-group">
                <label for="question_level">Question Level</label>
                <select id="question_level" name="question_level" >
                    <option value="">-- Select an Option --</option>
                    <option value="easy">Easy</option>
                    <option value="moderate">Moderate</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="question_type">Question Type</label>
                <select id="question_type" name="question_type" >
                    <option value="">-- Select an Option --</option>
                    <option value="simple_statement">Simple Statement</option>
                    <option value="multi_statement">Multi Statement</option>
                    <option value="match_the_following">Match the Following</option>
                    <option value="assertion_reason">Assertion Reason</option>
                    <option value="not_correctly_matched">Not Correctly Matched</option>
                </select>
            </div>

            
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

</body>
</html>
