<?php
// Database connection
include('db.php');

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "Question ID is required.";
    exit();
}

$question_id = intval($_GET['id']);

// Fetch question data
$query = "SELECT * FROM question_master WHERE question_id = $question_id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "Question not found.";
    exit();
}

$question = $result->fetch_assoc();

// Update question on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $updated_question = $conn->real_escape_string($_POST['question']);
    $option_a = $conn->real_escape_string($_POST['option_a']);
    $option_b = $conn->real_escape_string($_POST['option_b']);
    $option_c = $conn->real_escape_string($_POST['option_c']);
    $option_d = $conn->real_escape_string($_POST['option_d']);
    $correct_option = $conn->real_escape_string($_POST['correct_option']);
    $explanation = $conn->real_escape_string($_POST['explanation']);
    $question_notes = $conn->real_escape_string($_POST['question_notes']);
    $question_subject = $conn->real_escape_string($_POST['question_subject']);
    $question_chapter = $conn->real_escape_string($_POST['question_chapter']);
    $question_topic = $conn->real_escape_string($_POST['question_topic']);
    $question_exam = $conn->real_escape_string($_POST['question_exam']);
    $question_level = $conn->real_escape_string($_POST['question_level']);
    $question_type = $conn->real_escape_string($_POST['question_type']);
    $question_ref = $conn->real_escape_string($_POST['question_ref']);
    $question_image = $conn->real_escape_string($_POST['question_image']);
    $dt = date("Y-m-d H:i:s");

    // Update query
    $update_query = "UPDATE question_master 
                     SET question = '$updated_question', 
                         option_a = '$option_a', 
                         option_b = '$option_b', 
                         option_c = '$option_c', 
                         option_d = '$option_d', 
                         correct_option = '$correct_option', 
                         explanation = '$explanation', 
                         question_notes = '$question_notes', 
                         question_subject = '$question_subject', 
                         question_chapter = '$question_chapter', 
                         question_topic = '$question_topic', 
                         question_exam = '$question_exam', 
                         question_level = '$question_level', 
                         question_type = '$question_type', 
                         question_ref = '$question_ref', 
                         question_image = '$question_image', 
                         dt = '$dt'
                     WHERE question_id = $question_id";

    if ($conn->query($update_query) === TRUE) {
        // Redirect to display_questions.php
        header("Location: display_questions.php");
        exit();
    } else {
        echo "Error updating question: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Question</h2>
    <form method="POST">
        <div class="form-group">
            <label for="question">Question</label>
            <textarea id="question" name="question" rows="3" required style="width:97%;height:120px;"><?php echo htmlspecialchars($question['question']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="option_a">Option A</label>
            <input type="text" id="option_a" name="option_a" value="<?php echo htmlspecialchars($question['option_a']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_b">Option B</label>
            <input type="text" id="option_b" name="option_b" value="<?php echo htmlspecialchars($question['option_b']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_c">Option C</label>
            <input type="text" id="option_c" name="option_c" value="<?php echo htmlspecialchars($question['option_c']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_d">Option D</label>
            <input type="text" id="option_d" name="option_d" value="<?php echo htmlspecialchars($question['option_d']); ?>" required>
        </div>
        <div class="form-group">
            <label for="correct_option">Correct Option</label>
            <select id="correct_option" name="correct_option" required>
                <option value="<?php echo htmlspecialchars($question['correct_option']); ?>">Current :- <?php echo htmlspecialchars($question['correct_option']); ?></option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <div class="form-group">
            <label for="explanation">Explanation</label>
            <textarea id="explanation" name="explanation"style="width:97%;height:150px;"><?php echo htmlspecialchars($question['explanation']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="question_notes">Detailed Solution</label>
            <textarea id="question_notes" name="question_notes"style="width:97%;height:150px;"><?php echo htmlspecialchars($question['question_notes']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="question_subject">Subject</label>
            <select id="question_subject" name="question_subject" required>
            <option value="<?php echo htmlspecialchars($question['question_subject']); ?>">Current :- <?php echo htmlspecialchars($question['question_subject']); ?></option>
            <option value="history">History</option>
                    <option value="polity">Polity</option>
                    <option value="geography">Geography</option>
                    <option value="economics">Economics</option>
                    <option value="science">Science</option>
                    <option value="current_affairs_2025">Current Affairs 2025</option>
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
            <label for="question_chapter">Chapter</label>
            <input type="text" id="question_chapter" name="question_chapter" value="<?php echo htmlspecialchars($question['question_chapter']); ?>" required>
        </div>
        <div class="form-group">
            <label for="question_topic">Topic</label>
            <input type="text" id="question_topic" name="question_topic" value="<?php echo htmlspecialchars($question['question_topic']); ?>">
        </div>
        <div class="form-group">
            <label for="question_exam">Exam</label>
            <select id="question_exam" name="question_exam" required>
            <option value="<?php echo htmlspecialchars($question['question_exam']); ?>">Current :- <?php echo htmlspecialchars($question['question_exam']); ?></option>
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
        <div class="form-group">
            <label for="question_level">Level</label>
            <select id="question_level" name="question_level">
                    <option value="<?php echo htmlspecialchars($question['question_level']); ?>">Current :- <?php echo htmlspecialchars($question['question_level']); ?></option>
                    <option value="Easy">Easy</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Hard">Hard</option>
            </select>
        <div class="form-group">
            <label for="question_type">Type</label>
            <select id="question_type" name="question_type">
                    <option value="<?php echo htmlspecialchars($question['question_type']); ?>">Current :- <?php echo htmlspecialchars($question['question_type']); ?></option>
                    <option value="simple_statement">Simple Statement</option>
                    <option value="multi_statement">Multi Statement</option>
                    <option value="match_the_following">Match the Following</option>
                    <option value="assertion_reason">Assertion Reason</option>
                    <option value="not_correctly_matched">Not Correctly Matched</option>
            </select>
        </div>
        <div class="form-group">
            <label for="question_ref">Reference</label>
            <input type="text" id="question_ref" name="question_ref" value="<?php echo htmlspecialchars($question['question_ref']); ?>" required>
        </div>
        <div class="form-group">
            <label for="question_image">Image</label>
            <input type="text" id="question_image" name="question_image" value="<?php echo htmlspecialchars($question['question_image']); ?>">
        </div>
        <button type="submit">Update Question</button>
    </form>
</div>

</body>
</html>
