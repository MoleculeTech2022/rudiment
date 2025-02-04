<?php
// Database connection
include('../php/db_connect.php');

// Fetch subjects for the initial page load
$subjects = [];
$query = "SELECT DISTINCT question_subject FROM question_master";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['question_subject'];
    }
}

// Handle AJAX request for fetching chapters based on the selected subject
if (isset($_GET['fetch_chapters']) && isset($_GET['subject'])) {
    header('Content-Type: application/json');
    
    $subject = $_GET['subject'];

    if ($subject === 'all') {
        $query = "SELECT DISTINCT question_chapter FROM question_master ORDER BY question_chapter ASC";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT DISTINCT question_chapter FROM question_master WHERE question_subject = ? ORDER BY question_chapter ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $subject);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $chapters = [];
    while ($row = $result->fetch_assoc()) {
        $chapters[] = $row['question_chapter'];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($chapters);
    exit();
}

// Handle AJAX request for fetching question references
if (isset($_GET['fetch_question_ref']) && isset($_GET['subject']) && isset($_GET['chapter'])) {
    header('Content-Type: application/json');
    
    $subject = $_GET['subject'];
    $chapter = $_GET['chapter'];

    if ($subject === 'all' && $chapter === 'all') {
        $query = "SELECT DISTINCT question_ref FROM question_master ORDER BY question_ref ASC";
        $stmt = $conn->prepare($query);
    } elseif ($subject === 'all') {
        $query = "SELECT DISTINCT question_ref FROM question_master WHERE question_chapter = ? ORDER BY question_ref ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $chapter);
    } elseif ($chapter === 'all') {
        $query = "SELECT DISTINCT question_ref FROM question_master WHERE question_subject = ? ORDER BY question_ref ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $subject);
    } else {
        $query = "SELECT DISTINCT question_ref FROM question_master WHERE question_subject = ? AND question_chapter = ? ORDER BY question_ref ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $subject, $chapter);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $question_refs = [];
    while ($row = $result->fetch_assoc()) {
        $question_refs[] = $row['question_ref'];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($question_refs);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitude CSE Test</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Flaticon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- CSS File -->
    <link href="../style/habitude_test.css" rel="stylesheet">
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
            <a href="student_profile.php" class="signup">Profile</a>
        </div>
    </nav>
    <div class="test-container">
        <h2>Habitude CSE Test</h2>
        <div class="instructions">
            <ul>
                <li><i class="fas fa-check-circle"></i> Read each question carefully before answering.</li>
                <li><i class="fas fa-check-circle"></i> Choose the subject, chapter, and other details before starting.</li>
                <li><i class="fas fa-check-circle"></i> Manage your time wisely during the test.</li>
                <li><i class="fas fa-check-circle"></i> Ensure a stable internet connection for a smooth experience.</li>
            </ul>
        </div>
        <div class="select-group">
            <select id="subjectSelect">
            <option value="all">All Subjects</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= htmlspecialchars($subject) ?>"><?= htmlspecialchars($subject) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="question_chapter" name="question_chapter" disabled>
                <option value="" disabled selected>Select Chapter</option>
            </select>
            <select id="question_ref" name="question_ref" disabled>
                <option value="" disabled selected>Select Question Reference</option>
            </select>
        </div>
        <div class="select-group">
            <select id="no_of_question" name="no_of_question">
                <option value="" disabled selected>Number of Questions</option>
                <option value="25">25</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="90">90</option>
                <option value="100">100</option>
                <option value="120">120</option>
                <option value="150">150</option>
            </select>
        </div>
        <button id="startTestBtn">Start Test</button>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const subjectSelect = document.getElementById('subjectSelect');
    const chapterSelect = document.getElementById('question_chapter');
    const refSelect = document.getElementById('question_ref');

    // Fetch chapters when a subject is selected
    subjectSelect.addEventListener('change', function () {
        const subject = subjectSelect.value;
        chapterSelect.innerHTML = '<option value="" disabled selected>Select Chapter</option>';
        refSelect.innerHTML = '<option value="" disabled selected>Select Question Reference</option>';
        chapterSelect.disabled = true;
        refSelect.disabled = true;

        fetch(`<?php echo $_SERVER['PHP_SELF']; ?>?fetch_chapters=true&subject=${encodeURIComponent(subject)}`)
            .then(response => response.json())
            .then(data => {
                chapterSelect.disabled = false;
                chapterSelect.innerHTML += `<option value="all">All Chapters</option>`;
                data.forEach(chapter => {
                    const option = document.createElement('option');
                    option.value = chapter;
                    option.textContent = chapter;
                    chapterSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching chapters:', error));
    });

    // Fetch question references when a chapter is selected
    chapterSelect.addEventListener('change', function () {
        const subject = subjectSelect.value;
        const chapter = chapterSelect.value;
        refSelect.innerHTML = '<option value="" disabled selected>Select Question Reference</option>';
        refSelect.disabled = true;

        fetch(`<?php echo $_SERVER['PHP_SELF']; ?>?fetch_question_ref=true&subject=${encodeURIComponent(subject)}&chapter=${encodeURIComponent(chapter)}`)
            .then(response => response.json())
            .then(data => {
                refSelect.disabled = false;
                refSelect.innerHTML += `<option value="all">All References</option>`;
                data.forEach(ref => {
                    const option = document.createElement('option');
                    option.value = ref;
                    option.textContent = ref;
                    refSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching question references:', error));
    });
});


        document.getElementById('startTestBtn').addEventListener('click', function () {
            const subject = document.getElementById('subjectSelect').value;
            const chapter = document.getElementById('question_chapter').value;
            const numQuestions = document.getElementById('no_of_question').value;
            
            if (subject && chapter && numQuestions) {
                window.location.href = `habitude_take_test.php?subject=${subject}&chapter=${chapter}&numQuestions=${numQuestions}`;
            } else {
                alert("Please select subject, chapter, and number of questions.");
            }
        });
    </script>
</body>
</html>
