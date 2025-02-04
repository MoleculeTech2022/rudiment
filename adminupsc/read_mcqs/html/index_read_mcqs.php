<?php
include('../../db.php'); // Include your DB connection file

// Fetch chapters based on selected subject
if (isset($_POST['subject']) && $_POST['subject'] != '') {
    $subject = $_POST['subject'];
    $sql = "SELECT DISTINCT question_chapter FROM question_master WHERE question_subject = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    $chapters = [];
    while ($row = $result->fetch_assoc()) {
        $chapters[] = $row['question_chapter'];
    }

    echo json_encode($chapters);
    $stmt->close();
    exit;
}

// Fetch question_ref based on selected chapter (for the same subject)
if (isset($_POST['chapter']) && $_POST['chapter'] != '') {
    $chapter = $_POST['chapter'];
    
    $sql = "SELECT DISTINCT question_ref FROM question_master WHERE question_chapter = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $chapter);
    $stmt->execute();
    $result = $stmt->get_result();

    $refs = [];
    while ($row = $result->fetch_assoc()) {
        $refs[] = $row['question_ref'];
    }

    echo json_encode($refs);
    $stmt->close();
    exit;
}

// Fetch questions based on subject, chapter, and question_ref
if (isset($_POST['subject']) && isset($_POST['chapter']) && isset($_POST['question_ref']) && $_POST['subject'] != '' && $_POST['chapter'] != '' && $_POST['question_ref'] != '') {
    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];
    $question_ref = $_POST['question_ref'];
    
    $sql = "SELECT * FROM question_master WHERE question_subject = ? AND question_chapter = ? AND question_ref = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $subject, $chapter, $question_ref);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = [
                'question' => $row['question'],
                'options' => [
                    'A' => $row['option_a'],
                    'B' => $row['option_b'],
                    'C' => $row['option_c'],
                    'D' => $row['option_d']
                ],
                'correct_option' => $row['correct_option'],
                'explanation' => $row['explanation']
            ];
        }
        echo json_encode($questions);
    } else {
        echo json_encode(['error' => 'No questions found for this subject, chapter, and question_ref.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read & Learn MCQs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        select, button {
            padding: 10px;
            margin: 10px;
        }
        .question-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <center>
        <a href="../../index.php" style="text-decoration:none;">
            <img src="../../side/template/assets/images/habitude_logo.png" style="width:300px;height:130px;margin-top:-40px;" alt="Habitude">
        </a>
    </center>
    <h1 style="background:linear-gradient(to right, rgb(61, 189, 203), rgb(5, 109, 95));color:#FFFF;margin-top:-20px;"><center>Read & Learn MCQs</center></h1>

    <!-- Subject Selection -->
    <label for="subject">Select Subject:</label>
    <select id="subject" onchange="fetchChapters()">
        <option value="">--Select Subject--</option>
        <option value="all">All Subject</option>
        <option value="history">History</option>
        <option value="polity">Polity</option>
        <option value="geography">Geography</option>
        <option value="economy">Economy</option>
        <option value="science">Science</option>
        <option value="current_affairs_2025">Current Affairs 2025</option>
        <option value="maths">Maths</option>
        <option value="reasoning">Reasoning</option>
        <option value="bihar_special">Bihar Special</option>
        <option value="up_special">UP Special</option>
        <option value="uttarakhand_special">Uttarakhand Special</option>
        <option value="mp_special">MP Special</option>
        <option value="maharashtra_special">Maharashtra Special</option>
        <option value="hindi">Hindi</option>
        <option value="current_affairs_2024">Current Affairs 2024</option>
    </select>

    <!-- Chapter Selection -->
    <label for="chapter">Select Chapter:</label>
    <select id="chapter" onchange="fetchRefs()">
        <option value="">--Select Chapter--</option>
    </select>

    <!-- Question Reference Selection -->
    <label for="question_ref">Select Question Reference:</label>
    <select id="question_ref" onchange="fetchQuestions()">
        <option value="">--Select Question Reference--</option>
    </select>

    <!-- Fetch Questions Button -->
    <button id="fetchQuestionsBtn" onclick="fetchQuestions()">Fetch Questions</button>

    <!-- Question, Options, and Explanation -->
    <div id="question-container" class="question-container"></div>
    <div id="question-fetching" class="question-fetching">
        <?php
        $subject = 'all';
        $count = 1;
        if($subject === "all"){
            $fetch_query = "SELECT * FROM question_master ORDER BY question_id DESC";
        }else{

            $fetch_query = "SELECT * FROM question_master WHERE question_subject = '$subject' ORDER BY question_id DESC";
        }
        $query_run = mysqli_query($conn,$fetch_query);
        if(mysqli_num_rows($query_run) > 0 ){
            while($rows = mysqli_fetch_assoc($query_run)){
                
                // questions
                // $row['question'] = nl2br(htmlspecialchars($rows['question']));

                ?>
                <h3><?= $count . ". " ; ?><?= nl2br(htmlspecialchars($rows['question'])); ?></h3>
                <i style="margin-left:800px;">(<?= $rows['question_subject'] .", ". $rows['question_chapter'] .", ". $rows['question_topic'] .",". $rows['question_ref']; ?>)</i>
                <p><?= "A. " . $rows['option_a']; ?></p>
                <p><?= "B. " . $rows['option_b']; ?></p>
                <p><?= "C. " . $rows['option_c']; ?></p>
                <p><?= "D. " . $rows['option_d']; ?></p>
                <h4><?= "Ans : " . $rows['correct_option']; ?></h4>
                <p><?= "Explanation : " . nl2br(htmlspecialchars($rows['explanation'])); ?></p>
                <hr>
                <?php
                $count++;
            }
        }
        
        ?>

    </div>

    <script>
        function fetchChapters() {
            let subject = document.getElementById("subject").value;
            let chapterSelect = document.getElementById("chapter");
            chapterSelect.innerHTML = '<option value="">--Select Chapter--</option>'; // Reset chapters

            if (subject) {
                fetch("<?php echo $_SERVER['PHP_SELF']; ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "subject=" + subject
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(chapter => {
                            chapterSelect.innerHTML += `<option value="${chapter}">${chapter}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching chapters:", error);
                });
            }
        }

        function fetchRefs() {
            let chapter = document.getElementById("chapter").value;
            let refSelect = document.getElementById("question_ref");
            refSelect.innerHTML = '<option value="">--Select Question Reference--</option>'; // Reset question_ref

            if (chapter) {
                fetch("<?php echo $_SERVER['PHP_SELF']; ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "chapter=" + chapter
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(ref => {
                            refSelect.innerHTML += `<option value="${ref}">${ref}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching references:", error);
                });
            }
        }

        function fetchQuestions() {
            let subject = document.getElementById("subject").value;
            let chapter = document.getElementById("chapter").value;
            let question_ref = document.getElementById("question_ref").value;
            let questionContainer = document.getElementById("question-container");

            if (subject && chapter && question_ref) {
                fetch("<?php echo $_SERVER['PHP_SELF']; ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `subject=${subject}&chapter=${chapter}&question_ref=${question_ref}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        questionContainer.innerHTML = `<p>${data.error}</p>`;
                    } else {
                        let html = '';
                        data.forEach((item, index) => {
                            html += `
                                <p><strong>Question ${index + 1}:</strong> ${item.question}</p>
                                <p><strong>Options:</strong></p>
                                <ul>
                                    <li>A. ${item.options.A}</li>
                                    <li>B. ${item.options.B}</li>
                                    <li>C. ${item.options.C}</li>
                                    <li>D. ${item.options.D}</li>
                                </ul>
                                <p><strong>Correct Option:</strong> ${item.correct_option}</p>
                                <p><strong>Explanation:</strong> ${item.explanation}</p>
                                <hr>
                            `;
                        });
                        questionContainer.innerHTML = html;
                    }
                })
                .catch(error => {
                    questionContainer.innerHTML = `<p>Error fetching questions: ${error}</p>`;
                });
            } else {
                questionContainer.innerHTML = "<p>Coming Soon...</p>";
            }
        }
    </script>
</body>
</html>
