<?php
include "../dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Bank</title>
    <style>
        table {
            border-collapse: collapse;
            width: 850px;
            margin-left: 30px;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: none;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }

        .menu {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            padding: 10px;
            cursor: pointer;
        }

        .menu li:hover {
            background-color: #f2f2f2;
        }

        .active-status {
            color: rgb(4, 218, 32);
        }

        .pending-status {
            color: #eea435;
        }

        .suspended-status {
            color: rgb(255, 0, 0);
        }
    </style>
</head>

<body>
    <?php
    include "sidebar.html";
    ?>
    <div class="question-bank-page-contents" style="margin-top:-20px;">
        <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Question</span><br>
        <span style="font-size:35px;margin-left:290px;margin-top:20px;">Question Bank</span><br>
        <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Manage question bank here.</span>
    </div>
    <div class="buttons" style="margin-left:990px;margin-top:-90px;">
        <a href="addquestion.php" style="text-decoration:none;">
            <button
                style="height:40px;width:100px;margin-top:20px;margin-left:-10px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                Question</button>
        </a>
        <a href="show_exam.php">
            <button
                style="height:40px;width:130px;margin-top:20px;margin-left:10px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">Recently
                Exam</button>
        </a>
    </div>
    <div class="search" style="margin-top: 53px;margin-left:290px;">
        <input type="text" placeholder="search..." name="search" id="search"
            style="width: 250px; height: 35px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
    </div>

    <div class="filter-select-box" style="margin-top: -36px; margin-left: 560px;">
        <select name="student_class" id="student_class"
            style="width: 130px; height: 35px; padding: 5px; border: 1px solid #edeaea; border-radius: 5px;">
            <option value="all">Select Class</option>
            <option value="1st">1st</option>
            <option value="2nd">2nd</option>
            <option value="3rd">3rd</option>
            <option value="4th">4th</option>
            <option value="5th">5th</option>
        </select>
    </div>

    <div class="question-list-table"
        style="width:930px;margin-left: 290px;background-color: #fff;border-radius: 10px;height: 600px;margin-top: 20px;">

        <div class="table-header">

            <select name="subject" id="subject"
                style="width:130px;height:35px;margin-left:0px;margin-top:20px;padding: 5px;border-color: #edeaea;border-radius: 5px;">
                <option>Select Subject</option>
                <option>Math</option>
                <option>Science</option>
                <option>English</option>
                <option>Computer</option>
            </select>

            <button
                style="height:30px;width:70px;margin-top:20px;margin-left:10px;background-color:rgb(250, 174, 93);color:#fff;border:none;border-radius: 5px;">Apply</button>

            <button id="questionBtn"
                style="height:30px;width:150px;margin-top:20px;margin-left:530px;background-color:rgb(93, 203, 250);color:#fff;border:none;border-radius: 3px;">Question</button>


            <hr style="margin-top: 15px;color: #ffffff;">
        </div>
        <div class="table" id="student-table" style="margin-left: 0px;">

            <table style="width:930px;  ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="width:310px;">Question</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Option D</th>
                        <th>Correct</th>
                        <th>Class</th>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlFetchquestion = "SELECT * FROM questionbank
                        ORDER BY questionbank.qid DESC";
                    $resultFetchStudents = mysqli_query($con, $sqlFetchquestion);
                    $count = 0;

                    if (mysqli_num_rows($resultFetchStudents) > 0) {
                        while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {
                            ?>
                            <tr>
                                <td style="color:#000;">
                                    <input type="checkbox" value="<?php echo $rows['qid']; ?>">
                                </td>
                                <td style="width:310px;">
                                    <span style="font-size:15px;">
                                        <?php echo $rows['question']; ?>
                                    </span>

                                </td>
                                <td>
                                    <?php echo $rows['option_one']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['option_two']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['option_three']; ?>
                                </td>

                                <td>
                                    <?php echo $rows['option_four']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['answer']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['student_class']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['subj']; ?>
                                </td>

                            </tr>

                            <?php
                            $count++;
                        }
                    }

                    ?>
                </tbody>
            </table>

        </div>

    </div>

    <!-- live class filter select box script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const classSelect = document.getElementById('student_class');
            const tableRows = document.querySelectorAll('#student-table tbody tr');

            classSelect.addEventListener('change', function () {
                const selectedClass = classSelect.value;

                // Loop through table rows and show/hide based on selected class
                tableRows.forEach(function (row) {
                    const classCell = row.querySelector('td:nth-child(8)'); // Assuming class is in the 8th column
                    const classValue = classCell.textContent.trim();

                    if (selectedClass === 'all' || classValue === selectedClass) {
                        row.style.display = ''; // Show row
                    } else {
                        row.style.display = 'none'; // Hide row
                    }
                });
            });
        });
    </script>

    <!-- pass question to another file script echo.php -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const questionBtn = document.getElementById('questionBtn');
            const checkboxes = document.querySelectorAll('#student-table tbody input[type="checkbox"]');

            questionBtn.addEventListener('click', function () {
                const selectedQids = [];
                checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        selectedQids.push(checkbox.value);
                    }
                });

                // Redirect to another file with selected qid(s)
                if (selectedQids.length > 0) {
                    const qidsParam = selectedQids.join(',');
                    window.location.href = 'echo.php?qid=' + qidsParam;
                } else {
                    alert('Please select at least one question.');
                }
            });
        });
    </script>

    <!-- live search on the table script -->
    <!-- class wise subjects automatically filled script -->
    <script>
        const subjectsByClass = {
            '1st': ['Math', 'Science', 'English'],
            '2nd': ['Math', 'Science', 'Social Studies'],
            '3rd': ['Math', 'English', 'Physical Education'],
            '4th': ['Math', 'English', 'Science'],
            '5th': ['Math', 'History', 'Geography']
        };

        const classSelect = document.getElementById('student_class');
        const subjectSelect = document.getElementById('subject');

        classSelect.addEventListener('change', function () {
            const selectedClass = classSelect.value;
            const subjects = subjectsByClass[selectedClass] || [];

            // Clear existing options
            subjectSelect.innerHTML = '<option>Select Subject</option>';

            // Populate subject options
            subjects.forEach(function (subject) {
                const option = document.createElement('option');
                option.textContent = subject;
                subjectSelect.appendChild(option);
            });

            // Trigger change event on subject select to update table rows
            const event = new Event('change');
            subjectSelect.dispatchEvent(event);
        });
    </script>

    <!-- live class and subject filter select box script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const classSelect = document.getElementById('student_class');
            const subjectSelect = document.getElementById('subject');
            const tableRows = document.querySelectorAll('#student-table tbody tr');

            function filterRows() {
                const selectedClass = classSelect.value;
                const selectedSubject = subjectSelect.value;

                // Loop through table rows and show/hide based on selected class and subject
                tableRows.forEach(function (row) {
                    const classCell = row.querySelector('td:nth-child(8)'); // Assuming class is in the 8th column
                    const subjectCell = row.querySelector('td:nth-child(9)'); // Assuming subject is in the 9th column
                    const classValue = classCell.textContent.trim();
                    const subjectValue = subjectCell.textContent.trim();

                    if ((selectedClass === 'all' || classValue === selectedClass) &&
                        (selectedSubject === 'Select Subject' || subjectValue === selectedSubject)) {
                        row.style.display = ''; // Show row
                    } else {
                        row.style.display = 'none'; // Hide row
                    }
                });
            }

            // Apply filters on change of class or subject select
            classSelect.addEventListener('change', filterRows);
            subjectSelect.addEventListener('change', filterRows);
        });
    </script>

</body>

</html>