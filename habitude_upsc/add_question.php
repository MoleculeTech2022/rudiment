<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Add Question</h2>
    <form id="questionForm" action="save_question.php" method="POST">
        <!-- Subject Dropdown -->
        <label for="subject">Select Subject:</label>
        <select id="subject" name="subject" required>
            <option value="">Select Subject</option>
        </select>

        <!-- Sub-Subject Dropdown -->
        <label for="sub_subject">Select Sub-Subject:</label>
        <select id="sub_subject" name="sub_subject" required>
            <option value="">Select Sub-Subject</option>
        </select>

        <!-- Question Field -->
        <label for="question">Question:</label>
        <textarea id="question" name="question" rows="4" required></textarea>

        <!-- Options -->
        <label for="option_a">Option A:</label>
        <input type="text" id="option_a" name="option_a" required>

        <label for="option_b">Option B:</label>
        <input type="text" id="option_b" name="option_b" required>

        <label for="option_c">Option C:</label>
        <input type="text" id="option_c" name="option_c" required>

        <label for="option_d">Option D:</label>
        <input type="text" id="option_d" name="option_d" required>

        <!-- Correct Option -->
        <label for="correct_option">Correct Option:</label>
        <select id="correct_option" name="correct_option" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select>

        <button type="submit">Add Question</button>
    </form>

    <script>
        // Fetch subjects
        $(document).ready(function() {
            $.getJSON('fetch_data.php?type=subjects', function(data) {
                let subjectDropdown = $('#subject');
                data.forEach(function(subject) {
                    subjectDropdown.append(new Option(subject, subject));
                });
            });

            // Fetch sub-subjects on subject change
            $('#subject').change(function() {
                let subject = $(this).val();
                let subSubjectDropdown = $('#sub_subject');
                subSubjectDropdown.empty().append(new Option('Select Sub-Subject', ''));

                if (subject) {
                    $.getJSON('fetch_data.php?type=sub_subjects&hab_subject=' + subject, function(data) {
                        data.forEach(function(subSubject) {
                            subSubjectDropdown.append(new Option(subSubject, subSubject));
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
