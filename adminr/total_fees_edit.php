<?php
include "dbcon.php";
include "sidebar.html";

// Get payment id from payments page
if (isset($_GET['aid'])) {

    // Sanitize the input
    $aid = mysqli_real_escape_string($con, $_GET['aid']);
    // Construct your SQL query
    $query = "SELECT * FROM acdyear 
    JOIN students ON students.sid = acdyear.sid
    WHERE aid = '$aid'";

    // Execute the query
    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if there are any matching records
        if (mysqli_num_rows($result) > 0) {
            $payment = mysqli_fetch_assoc($result);
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>RUDIMENT - Total Fees Edit</title>

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

                                $sqlJOIN = "SELECT * FROM students JOIN payment ON students.sid = payment.sid";
                                // Execute a SQL query to select student names from the database
                                $direct = mysqli_query($con, $sqlJOIN);
                                echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                                echo "<option>Select Student</option>";
                                while ($row = mysqli_fetch_array($direct)) {
                                    echo "<option value='" . $row['payid'] . "'>" . $row['students.sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
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
                        <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Total Fees Edit
                            Form</span><br>
                        <span style="font-size:35px;margin-left:290px;margin-top:20px;">Total Fees Edit</span><br>
                        <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Total Fees Edit Of Any Student.</span>
                    </div>


                    <div class="student-card"
                        style="position:absolute;width:900px;height:80px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:20px;margin-left:290px;border-radius:10px; ">
                        <a href="student-view.php?sid=<?php echo $payment['sid'] ?>" style="text-decoration:none;">
                            <span style="display: block; margin-top:20px;margin-left:20px;">Student Name :
                                <?php echo $payment['fname']; ?>
                                <?php echo $payment['mname']; ?>
                                <?php echo $payment['lname']; ?>
                            </span>
                        </a>
                        <div class="student-class-and-acdyear" style="margin-left:40px;">
                            <span style="display: block; margin-top:-23px;margin-left:350px;">Class :
                                <?php echo $payment['current_class']; ?>
                            </span>
                            <span style="display: block; margin-top:-23px;margin-left:490px;">Academic Year :
                                <?php echo $payment['acdyear']; ?>
                            </span>
                        </div>
                    </div>


                    <div class="addPaymentForm"
                        style="width:700px;height:330px;background-color:#fff;margin-left:290px;margin-top:120px;border-radius:5px;position:absolute;">

                        <div class="title" style="margin-top:10px;">
                            <span style="margin-left:20px;">Edit Payment</span>
                        </div>
                        <form action="code.php" method="POST">

                            <input type="hidden" name="aid" value="<?= $payment['aid']; ?>">
                            <input type="hidden" name="sid" value="<?= $payment['sid']; ?>">

                            <input type="text" value="<?= $payment['acdyear']; ?>" name="acdyear" placeholder="Academic Year"
                                style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">

                            <input type="number" value="<?= $payment['total_fees']; ?>" name="total_fees" placeholder="Total Fees"
                                style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">

                            <br>
                            <button type="submit" name="total_fees_edit_btn"
                                style="width:300px;height:35px;border-radius:5px;margin-left:20px;background-color:#7cd5fb;border:none;margin-top:20px;">Save
                                Changes</button>

                        </form>



                    </div>


                </div>

                <script>
                    // Function to redirect to student-view.php with the selected student ID
                    function redirectToStudentView(studentID) {
                        if (studentID) {
                            window.location.href = 'payment_edit.php?payid=' + studentID;
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