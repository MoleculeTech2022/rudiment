<?php
session_start(); // Start the session to check if the user is logged in

// Check if the user is not logged in
if (!isset($_SESSION['student_email'])) {
    // Redirect to the login page
    header("Location: login_form.php");
    exit(); // Make sure to stop the script from further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background: linear-gradient(to right, #FFA726, #FB8C00);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header h1 a {
            color: white;
            text-decoration: none;
        }
        .header h1 a:hover {
            text-decoration: underline;
        }
        .header .counts {
            margin-top: 10px;
            font-size: 14px;
        }
        .container {
            width: 90%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            width: 97%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #FF7043;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        td {
            background-color: #fff;
            color: #555;
        }
        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        tr:hover td {
            background-color: #FFECB3;
        }
        .edit-btn {
            background-color: #42A5F5;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
        }
        .edit-btn:hover {
            background-color: #1E88E5;
        }
        .question-col {
            width: 30%;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="header">
    <h1><a href="index.php">HABITUDE</a></h1>
    <div class="counts">
        Total Questions: <span id="total-questions">0</span> | Subject-wise Count: <span id="subject-counts">Loading...</span>
    </div>
</div>

<div class="container">
    <h2>All Questions | <a href="add_question.php">ADD More Q</a></h2>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search questions by any field...">
    </div>
    <table>
        <thead>
            <tr>
                <th>Q ID</th>
                <th class="question-col">Question</th>
                <th>Options</th>
                <th>Correct Option</th>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Topic</th>
                <th>Level</th>
                <th>Exam</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="question-list">
            <!-- Data will be populated here dynamically -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('fetch_questions.php')
            .then(response => response.json())
            .then(data => {
                const questionList = document.getElementById('question-list');
                const totalQuestions = document.getElementById('total-questions');
                const subjectCounts = document.getElementById('subject-counts');

                // Update total question count
                totalQuestions.textContent = data.total;

                // Update subject-wise counts
                const subjectCountsArray = Object.entries(data.subjectWiseCounts).map(
                    ([subject, count]) => `${subject}: ${count}`
                );
                subjectCounts.textContent = subjectCountsArray.join(', ');

                // Populate table
                data.questions.forEach(question => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${question.question_id}</td>
                        <td>${question.question}</td>
                        <td>
                            A: ${question.option_a}<br>
                            B: ${question.option_b}<br>
                            C: ${question.option_c}<br>
                            D: ${question.option_d}
                        </td>
                        <td>${question.correct_option}</td>
                        <td>${question.question_subject}</td>
                        <td>${question.question_chapter}</td>
                        <td>${question.question_topic}</td>
                        <td>${question.question_level}</td>
                        <td>${question.question_exam}</td>
                        <td>
                            <a href="edit_question.php?id=${question.question_id}" class="edit-btn">Edit</a>
                        </td>
                    `;
                    questionList.appendChild(row);
                });

                // Add live search functionality
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', function () {
                    const filter = searchInput.value.toLowerCase();
                    const rows = questionList.getElementsByTagName('tr');

                    Array.from(rows).forEach(row => {
                        const cells = row.getElementsByTagName('td');
                        const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                        row.style.display = rowText.includes(filter) ? '' : 'none';
                    });
                });
            })
            .catch(error => console.error('Error fetching questions:', error));
    });
</script>

</body>
</html>
