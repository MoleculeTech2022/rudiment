<?php
include "dbcon.php";
include "sidebar.html";

// Get payment id from payments page
if (isset($_GET['cfid'])) {

    // Sanitize the input
    $cfid = mysqli_real_escape_string($con, $_GET['cfid']);
    // Construct your SQL query
    $query = "SELECT * FROM complaint 
    JOIN students ON students.sid = complaint.sid
    JOIN dacdyear
    WHERE cfid = '$cfid'";

    // Check if a date filter is set and add it to the query
    if (isset($_POST['filterDate']) && !empty($_POST['filterDate'])) {
        $filterDate = mysqli_real_escape_string($con, $_POST['filterDate']);
        $query .= " AND date = '$filterDate'";
    }

    // Execute the query
    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if there are any matching records
        if (mysqli_num_rows($result) > 0) {
            $complaint = mysqli_fetch_assoc($result);
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>RUDIMENT - View Complaint</title>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $("#search").on("keyup", function () {
                            var searchText = $(this).val().toLowerCase();

                            $.ajax({
                                url: "paymentFilter.php",
                                method: "POST",
                                data: { search: searchText },
                                success: function (data) {
                                    $("#student-table tbody").html(data);
                                }
                            });
                        });
                    });
                </script>



            </head>

            <body style="background-color: #f2f4f6;">
                <div class="container">

                    <div class="second-navigation"
                        style="width:100%;height:40px;background-color:#f2f4f6;margin-top:-18px;margin-left:0px;box-shadow:1px 1px 1px 1px #edeaea;">

                        <div class="secondNavContents" style="margin-left:280px;">
                            <span>To search another student search student here.</span>

                            <div class="searchable-select-box" style="margin-left:420px;margin-top:-28px;">

                                <?php

                                $sqlJOIN = "SELECT * FROM students JOIN complaint ON students.sid = complaint.sid";
                                // Execute a SQL query to select student names from the database
                                $direct = mysqli_query($con, $sqlJOIN);
                                echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                                echo "<option>Select Student</option>";
                                while ($row = mysqli_fetch_array($direct)) {
                                    echo "<option value='" . $row['cfid'] . "'>" . $row['students.sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                            <div class="btns" style="margin-top:-33px;margin-left:720px;">

                                <a href="payments.php" style="text-decoration:none;">
                                    <button
                                        style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(49, 217, 255);color:#fff;border:none;border-radius: 5px;">Payments</button>
                                </a>
                                <a href="students.php" style="text-decoration:none;">
                                    <button
                                        style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Back</button>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="students-page-contents" style="margin-top:20px;">
                        <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Complaint/Feedback
                            Form</span><br>
                        <span style="font-size:35px;margin-left:290px;margin-top:20px;">Complaint/Feedback Resolve</span><br>
                        <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Edit Complaint/Feedback of any
                            Student.</span>
                    </div>


                    <div class="student-card"
                        style="position:absolute;width:900px;height:80px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:20px;margin-left:290px;border-radius:10px; ">
                        <a href="student-view.php?sid=<?php echo $complaint['sid'] ?>" style="text-decoration:none;">
                            <span style="display: block; margin-top: 20px;margin-left:20px;">Student Name :
                                <?php echo $complaint['fname']; ?>
                                <?php echo $complaint['mname']; ?>
                                <?php echo $complaint['lname']; ?>
                            </span>
                        </a>
                        <div class="student-class-and-acdyear" style="margin-left:40px;">
                            <span style="display: block; margin-top: -23px;margin-left:350px;">Class :
                                <?php echo $complaint['classAdmitted']; ?>
                            </span>
                            <span style="display: block; margin-top: -23px;margin-left:470px;">Academic Year :
                                <?php echo $complaint['default_acdyear']; ?>
                            </span>
                        </div>
                    </div>


                    <div class="addPaymentForm"
                        style="width:700px;height:330px;background-color:#fff;margin-left:290px;margin-top:120px;border-radius:5px;position:absolute;">

                        <div class="title" style="margin-top:10px;">
                            <span style="margin-left:20px;">Resolve Complaint/Feedback</span>
                        </div>

                        <!-- Complaint Resolution Form  -->
                        <form action="code.php" method="POST">

                            <input type="hidden" name="cfid" value="<?= $complaint['cfid']; ?>">
                            <input type="hidden" name="sid" value="<?= $complaint['sid']; ?>">


                            <div class="complaint-type" style="margin-left:20px;margin-top:10px;width:300px;">
                                <h5>Complaint type :</h5>
                                <span type="text" value="<?= $complaint['comtype']; ?>" name="comtype" placeholder="Comtype"
                                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                                    <?= $complaint['comtype']; ?>
                                </span>
                            </div>

                            <div class="complaint-date" style="margin-left:20px;margin-top:20px;width:300px;">
                                <h5>Complaint date :</h5>
                                <span type="date" title="Complaint Date" name="date" placeholder="Complaint Date"
                                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                                    <?= $complaint['date']; ?>
                                </span>
                            </div>

                            <br>



                            <br>
                            <div class="register-complaint" style="margin-left:20px;">
                                <p type="text" name="complaint" placeholder="Our Complaint"
                                    style="width:400px;height:50px;margin-left:40px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:-80px;border-color:#000;">
                                <h5>Complaint Details :</h5>
                                <?php echo $complaint['complaint']; ?>

                                </p>
                            </div>
                            <br>
                            <hr>
                            <input type="text" name="schoolComment" placeholder="Teacher Comment"
                                style="width:500px;height:50px;padding:10px;border-radius:5px;margin-top:10px;border-width:1px;margin-left:20px;">

                            <select name="comStatus" placeholder="Payment Mode"
                                style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                                <option value="In Progress">In Progress</option>
                                <option value="Resolved">Resolved</option>
                            </select>

                            <input type="date" name="sdate" title="Coplaint resolve date"
                                style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">


                            <br>
                            <button type="submit" name="editComplaint"
                                style="width:300px;height:30px;border-radius:5px;margin-left: 14px;background-color:#7cd5fb;border:none;margin-top:20px;">Resolve
                                Complaint</button>

                        </form>



                    </div>

                    <div class="messaging">
                        .first card
                    </div>

                </div>


                <script>
                    // Function to redirect to student-view.php with the selected student ID
                    function redirectToStudentView(studentID) {
                        if (studentID) {
                            window.location.href = 'viewComplaint.php?cfid=' + studentID;
                        }
                    }
                </script>

                <script>
                    $(document).ready(function () {
                        // Initial table load with default academic year
                        <?php
                        $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
                        $year = mysqli_fetch_assoc($year_query);
                        $default_acdyear = $year['default_acdyear'];
                        ?>
                        updateStudentTable("<?php echo $default_acdyear; ?>");
                        // updateStudentTable("2023-24");
                        // updateStudentTable("2024-25");

                        function updateStudentTable(selectedYear) {
                            $.ajax({
                                url: "payacdFilter.php",
                                method: "POST",
                                data: { academic_year: selectedYear },
                                success: function (data) {
                                    $("#student-table tbody").html(data);
                                },
                                error: function () {
                                    $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                                }
                            });
                        }

                        // Handle academic year change
                        $("#academic_year").change(function () {
                            var selectedYear = $(this).val();
                            updateStudentTable(selectedYear);
                        });
                    });


                    <?php
                    $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
                    $year = mysqli_fetch_assoc($year_query);
                    $default_acdyear = $year['default_acdyear'];
                    ?>
                    updateStudentTable("<?php echo $default_acdyear; ?>");
                    // updateStudentTable("2023-24");
                    // updateStudentTable("2024-25");

                    function updateStudentTable(selectedStatus) {
                        $.ajax({
                            url: "modeFilter.php",
                            method: "POST",
                            data: { paymode: selectedStatus },
                            success: function (data) {
                                $("#student-table tbody").html(data);
                            },
                            error: function () {
                                $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                            }
                        });
                    }


                    $("#status").change(function () {
                        var selectedStatus = $(this).val();
                        updateStudentTable(selectedStatus);
                    });

                </script>

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

                <!-- Include Chosen jQuery plugin -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

                <!-- Include Chosen CSS -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

                <!-- Initialize Chosen on the 'search' select element -->
                <script>
                    $('#fetch').chosen();
                </script>

            </body>

            </html>
            <?php

        } else {
            echo "<h4>No Such ID Found</h4>";
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>