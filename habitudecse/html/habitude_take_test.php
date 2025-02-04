<?php
// habitude_take_test.php
include('../php/db_connect.php');

// Get the parameters from the URL
$subject = $_GET['subject'];
$chapter = $_GET['chapter'];
$numQuestions = $_GET['numQuestions'];

// Query to fetch questions based on subject, chapter
$query = "SELECT * FROM question_master WHERE question_subject = ? AND question_chapter = ? ORDER BY RAND() LIMIT ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $subject, $chapter, $numQuestions);
$stmt->execute();
$result = $stmt->get_result();

// Fetch questions
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitude CSE Test</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color:rgb(231, 209, 12);
            color: white;
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: 600;
            color: white;
            text-decoration: none;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .navbar ul li {
            margin: 0 10px;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-buttons a {
            margin-left: 10px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid white;
            border-radius: 5px;
            color: white;
        }
        .test-container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .test-container h2 {
            text-align: center;
            color: #333;
        }
        .question {
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .question p {
            margin: 0 0 10px;
            font-weight: 500;
        }
        .question input[type="radio"] {
            margin-right: 10px;
        }
        .question label {
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: white;
            cursor: pointer;
            transition: background 0.3s, border-color 0.3s;
        }
        .question label:hover {
            background: #f0f0f0;
            border-color: #aaa;
        }
        #timer {
            text-align: right;
            font-weight: bold;
            margin: 10px 0;
            color: #d9534f;
        }
        #submitBtn {
            display: block;
            width: 200px;
            padding: 10px;
            background:rgb(97, 149, 255);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            margin-right:50px;
        }
        #submitBtn:hover {
            background: #45a049;
        }
        #result-container {
            text-align: center;
            margin-top: 20px;
        }
        #result-container h3 {
            color: #333;
        }

        .test-container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto 100px; /* Add margin-bottom to leave space for footer */
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .test-footer {
            position: fixed; /* Ensures footer is always visible at the bottom */
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white; /* White background */
            display: flex;
            justify-content: space-between; /* Submit button on left, timer on right */
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Ensures footer is always on top */
        }

        .test-footer #timer {
            font-weight: bold;
            color: black; /* Timer text in black */
        }

        .test-footer button {
            padding: 8px 15px;
            font-size: 16px;
            background: #3498db; /* Match navbar signup button */
            color: #ecf0f1;
            border: 1px solid #3498db;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .test-footer button:hover {
            background-color: #ecf0f1;
            color: #3498db;
        }


        .options-container {
    display: flex;
    gap: 15px;
}

.option-card {
    padding: 15px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    flex: 1;
    text-align: center;
    transition: all 0.3s;
    font-weight: 500;
}

.option-card:hover {
    background: #f5f5f5;
}

.option-card.selected {
    border: 2px solid #3498db; /* Blue border for selected card */
    background: #f0f9ff; /* Slight blue background */
}

    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="logo">
            <i class="fas fa-book-reader"></i> Habitude
        </a>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Test</a></li>
            <li><a href="#">Notes</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="#" class="login">Login</a>
            <a href="#" class="signup">Sign Up</a>
        </div>
    </nav>

    <div class="test-container">
    <h2>Test: <?= htmlspecialchars($subject) ?> - <?= htmlspecialchars($chapter) ?></h2>

    <form id="testForm">
        <div id="questions-container">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                <p><?= htmlspecialchars($question['question']) ?></p>
                <input type="hidden" name="question_id_<?= $index ?>" value="<?= $question['question_id'] ?>">
                <!-- <i class="far fa-bookmark bookmark-icon" data-question-id="<?= $question['question_id'] ?>"></i> -->

                <div class="options-container">
                    <div class="option-card" data-value="A">
                        <?= htmlspecialchars($question['option_a']) ?>
                    </div>
                    <div class="option-card" data-value="B">
                        <?= htmlspecialchars($question['option_b']) ?>
                    </div>
                    <div class="option-card" data-value="C">
                        <?= htmlspecialchars($question['option_c']) ?>
                    </div>
                    <div class="option-card" data-value="D">
                        <?= htmlspecialchars($question['option_d']) ?>
                    </div>
                </div>
                <input type="hidden" name="question_<?= $index ?>" class="selected-option">
            </div>

            <?php endforeach; ?>
        </div>
    </form>
</div>

<footer class="test-footer">
    <div id="timer">Time left: 10:00</div>
    <button type="submit" id="submitBtn">Submit Test</button>
</footer>


        <div id="result-container" style="display: none;">
            <h3>Test Results</h3>
            <p>Correct Questions: <span id="correct-count"></span></p>
            <p>Incorrect Questions: <span id="incorrect-count"></span></p>
            <p>Not Attempted Questions: <span id="not-attempted-count"></span></p>
            <p>Accuracy: <span id="accuracy"></span>%</p>
        </div>
    </div>

    <script>

$(document).on('click', '.option-card', function () {
    const $this = $(this);

    // Remove 'selected' class from all siblings
    $this.siblings().removeClass('selected');

    // Add 'selected' class to the clicked card
    $this.addClass('selected');

    // Update the hidden input with the selected value
    const selectedValue = $this.data('value');
    $this.closest('.question').find('.selected-option').val(selectedValue);
});

let timer = 600; // 10 minutes in seconds
const timerElement = document.getElementById('timer');
const startTime = timer;

function updateTimer() {
    let minutes = Math.floor(timer / 60);
    let seconds = timer % 60;
    timerElement.innerText = `Time left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    timer--;

    if (timer < 0) {
        clearInterval(timerInterval);
        alert("Time is up! You can still submit the test.");
    }
}

const timerInterval = setInterval(updateTimer, 1000);

// Ensure Submit Button is always active
$('#submitBtn').on('click', function () {
    $('#testForm').submit(); // Trigger form submission
});

$('#testForm').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission
    const formData = $(this).serializeArray();
    const timeTaken = startTime - timer;

    formData.push({ name: 'time_taken', value: timeTaken });

    $.ajax({
        url: 'submit_test.php', // Redirect to result page
        method: 'POST',
        data: formData,
        success: function (response) {
            document.write(response);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('There was an error submitting the test');
        }
    });
});

// Bookmark functionality
$(document).on('click', '.bookmark-icon', function () {
    const questionId = $(this).data('question-id');
    const userId = 1; // Assuming the user ID is 1, replace with the actual logged-in user's ID

    $.ajax({
        url: '../php/bookmark_question.php',
        method: 'POST',
        data: { question_id: questionId, user_id: userId },
        success: function (response) {
            alert('Question bookmarked!');
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('There was an error bookmarking the question.');
        }
    });
});


</script>

</body>
</html>
