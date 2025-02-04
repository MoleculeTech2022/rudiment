<?php
require '../dbcon.php';

// Check if 'sid' is set in the URL
if (isset($_GET['pros_id'])) {
    // Sanitize the input
    $student_id = mysqli_real_escape_string($con, $_GET['pros_id']);

    // Construct your SQL query
    $query = "SELECT * FROM prospect
            --   JOIN payment ON prospect.pros_id = payment.sid
            --   JOIN parents ON prospect.pros_id = parents.sid
            --   JOIN acdyear ON prospect.pros_id = acdyear.sid
              WHERE prospect.pros_id = '$student_id'";

    // Execute the query
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Check if there are any matching records
        if (mysqli_num_rows($query_run) > 0) {
            $student = mysqli_fetch_assoc($query_run);

            $sql = "SELECT SUM(payamt) AS total_amount FROM payment WHERE sid = '$student_id' ";
            $result = mysqli_query($con, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $totalAmount = $row["total_amount"];
            } else {
                echo "Error fetching total payment amount: " . mysqli_error($con);
            }
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Student View</title>
                <!-- CSS -->
                <link rel="stylesheet" href="css/style.css">
                <!-- Boxicons CSS -->
                <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
                <link rel="stylesheet" href="path-to-your-custom-chosen.css">


                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <style>
                    /* Google Fonts - Poppins */
                    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                        font-family: "Poppins", sans-serif;
                    }

                    body {
                        min-height: 100%;
                        background-color: #f2f4f6;
                    }


                    /* Custom styles for the Chosen select box container */
                    .chosen-container {
                        border: 2px solid #ffffff;
                        background-color: #f5f5f5;
                        color: #000000;
                        border-radius: 5px;
                        box-shadow: 1px 1px 1px 1px #edeaea;
                    }

                    /* Custom styles for the Chosen dropdown list */
                    .chosen-drop {
                        background-color: #fff;
                        border: 1px solid #ccc;
                    }

                    /* Custom styles for the Chosen selected options */
                    .chosen-choices {
                        border: 1px solid #ccc;
                        background-color: #f5f5f5;
                    }

                    .comment-card {
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        padding: 10px;
                        margin-bottom: 10px;
                        background-color: #f9f9f9;
                        margin-top: 10px;
                        width: 540px;
                        margin-left: 20px;
                    }

                    .comment-meta {
                        margin-bottom: 5px;
                    }

                    .comment-meta span {
                        margin-right: 10px;
                    }

                    .comment-content p {
                        margin: 0;
                        font-size: 14px;
                        line-height: 1.5;
                    }
                </style>
            </head>

            <body>
                <?php
                include "sidebar.html";
                ?>

                </div>
                <div class="second-navigation"
                    style="width:100%;height:40px;background-color:#ffff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:-18px;margin-left:0px;">

                    <div class="secondNavContents" style="margin-left:280px;">
                        <span>To search another student search student here.</span>

                        <div class="searchable-select-box" style="margin-left:420px;margin-top:-28px;">

                            <?php
                            // Execute a SQL query to select student names from the database
                            $direct = mysqli_query($con, "SELECT `pros_id`, fname, mname, lname FROM prospect");
                            echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                            echo "<option>Select Student</option>";
                            while ($row = mysqli_fetch_array($direct)) {
                                echo "<option value='" . $row['pros_id'] . "'>" . $row['pros_id'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="btns" style="margin-top:-33px;margin-left:720px;">

                            <a href="addprospect.php" style="text-decoration:none;">
                                <button
                                    style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(49, 217, 255);color:#fff;border:none;border-radius: 5px;">New
                                    Admisison</button>
                            </a>
                            <a href="report.php" style="text-decoration:none;">
                                <button
                                    style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Report</button>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="student-profile-first-card"
                    style="width:300px;height: 1030px;border-radius:5px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:280px;margin-top:20px;position:absolute;">

                    <div class="edit-profile-direct-btn"
                        style="width:70px;height:30px;background-color:rgb(225, 225, 249);border-radius:10px;padding:3px;margin-top:10px;margin-left:220px;">
                        <a href="prospectedit.php?pros_id=<?= $student['pros_id']; ?>"
                            style="margin-left:10px;text-decoration:none;">
                            Edit
                        </a>
                        <i class="fa fa-pencil" style="margin-left:3px;"></i>
                    </div>

                    <img src="../images/photo.png" style="width:120px;height:120px;margin-top:10px;margin-left:80px;">



                    <h4 style="margin-left:38px;margin-top:10px;">
                        <?php echo $student['fname']; ?>
                        <?php echo $student['mname']; ?>
                        <?php echo $student['lname']; ?>
                    </h4>

                    <div class="first-card-header" style="margin-top:10px;margin-left:10px;">
                        <h5>Student Details</h5>
                    </div>

                    <div class="another-details" style="margin-top:10px;">
                        <span style="margin-left:35px;margin-top:10px;">Class :
                            <?php echo $student['enrollclass']; ?>
                        </span>
                        <span style="margin-left: 20px;margin-top:10px;">DOB :
                            <?php echo $student['dob']; ?>
                        </span><br>
                    </div>
                    <div class="sixthteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Identifier :
                            <?php echo $student['identifier']; ?>
                        </span>
                    </div>
                    <div class="age-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Age :
                            <?php echo $student['age']; ?>
                        </span>
                    </div>
                    <div class="third-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Mob No :
                            M :
                            <?php echo $student['mcontact']; ?><br>
                        </span>
                    </div>
                    <div class="third-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Mob No :
                            F :
                            <?php echo $student['fcontact']; ?><br>
                        </span>
                    </div>
                    <div class="third-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Gender :
                            <?php echo $student['gender']; ?>
                        </span>
                    </div>
                    <div class="fifth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Region :
                            <?php echo $student['region']; ?>
                        </span>
                    </div>
                    <hr style="margin-top:7px;">
                    <div class="second-card-header" style="margin-top:10px;margin-left:10px;">
                        <h5>Parents Details</h5>
                    </div>
                    <div class="sixth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Father :
                            <?php echo $student['faname']; ?>
                        </span>
                    </div>
                    <div class="seventh-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">F-Occup :
                            <?php echo $student['foccup']; ?>
                        </span>
                    </div>
                    <div class="eigth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Mother :
                            <?php echo $student['moname']; ?>
                        </span>
                    </div>
                    <div class="ninth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">M-Occup :
                            <?php echo $student['moccup']; ?>
                        </span>
                    </div>
                    <div class="tenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">F-Salary :
                            <?php echo $student['fsalary']; ?>
                        </span>
                    </div>
                    <div class="eleventh-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">M-Salary :
                            <?php echo $student['msalary']; ?>
                        </span>
                    </div>
                    <hr style="margin-top:7px;">
                    <div class="third-card-header" style="margin-top:10px;margin-left:10px;">
                        <h5>Other Details</h5>
                    </div>
                    <div class="fourth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">DOV :
                            <?php echo $student['dov']; ?>
                        </span>
                    </div>
                    <div class="twelfth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">House Type :
                            <?php echo $student['house']; ?>
                        </span>
                    </div>
                    <div class="thirdteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Native Lang :
                            <?php echo $student['nativelang']; ?>
                        </span>
                    </div>
                    <div class="fourthteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">State :
                            <?php echo $student['state']; ?>
                        </span>
                    </div>
                    <div class="fiffthteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Ref :
                            <?php echo $student['ref']; ?>
                        </span>
                    </div>
                    <div class="seventhteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">State :
                            <?php echo $student['state']; ?>
                        </span>
                    </div>
                    <div class="eigthteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Chance :
                            <?php echo $student['admchance']; ?>
                        </span>
                    </div>
                    <div class="ninthteenth-details-layer" style="margin-top:10px;">
                        <span style="margin-left: 35px;margin-top:20px;">Remarks :
                            <?php echo $student['remarks']; ?>
                        </span>
                    </div>

                </div>


                <div class="student-payment-details-card"
                    style="position:absolute;width:600px;height:440px;border-radius:5px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:620px;margin-top:20px;">

                    <div class="header" style="margin-top:10px;margin-left:10px;">
                        <h3>Follow Up Comments</h3>
                    </div>
                    <br>
                    <div class="materails">

                        <form action="prospectdbcode.php" method="POST">

                            <input type="hidden" name="pros_id_tv" id="pros_id_tv" placeholder="pros_id"
                                value="<?php echo $student['pros_id']; ?>">

                            <div class="first-input" style="display:flex;margin-left:10px;margin-top:-18px;">
                                <select name="followmode" id="followmode" placeholder="Follow Mode"
                                    style="margin-top:20px;padding:5px;width:150px;border-radius:5px;border-width:1px;">
                                    <option value="Follow Up Mode">Follow Up Mode</option>
                                    <option value="Call">Call</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Whatsapp">Whatsapp</option>
                                    <option value="Home Meeting">Home Meeting</option>
                                    <option value="Office Meeting">Office Meeting</option>
                                </select>

                                <div class="fourth-input" style="margin-left:10px;margin-top:0px;">
                                    <input type="date" name="dof" placeholder="Date Of Follow" title="Date Of Follow"
                                        style="margin-left:0px;margin-top:20px;padding:5px;width:160px;border-radius:5px;border-width:1px;">
                                </div>

                                <div class="third-input" style="margin-left:10px;margin-top:0px;">
                                    <select name="followby" placeholder="Name"
                                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                                        <option value="Follow Up By">Follow Up By</option>
                                        <option value="Shivjyoti Mam">Shivjyoti Mam</option>
                                        <option value="Shikha Mam">Shikha Mam</option>
                                        <option value="Nidhi Mam">Nidhi Mam</option>
                                        <option value="Vaishali Mam">Vaishali Mam</option>
                                        <option value="Sweta Mam">Sweta Mam</option>
                                        <option value="Vinit Sir">Vinit Sir</option>
                                    </select>
                                </div>


                            </div>

                            <div class="second-input" style="margin-left:10px;margin-top:0px;">
                                <input type="text" name="comment" placeholder="Crux Comment"
                                    style="margin-left:0px;margin-top:20px;padding:5px;width:540px;border-radius:5px;border-width:1px;height:50px;">
                            </div>

                            <div class="third_level" style="display:flex;">

                                <div class="fiffth-input" style="margin-left:10px;margin-top:0px;">
                                    <input type="text" name="nextstep" placeholder="Next Step"
                                        style="margin-left:0px;margin-top:20px;padding:5px;width:310px;border-radius:5px;border-width:1px;height:80px;">
                                </div>

                                <div class="sixth-input" style="margin-left:10px;margin-top:0px;">
                                    <input type="date" name="nfd" id="nfd" placeholder="Next Date" title="Next Date"
                                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                                </div>
                            </div>
                            <div class="btn" style="margin-top:-30px;">
                                <button value="submit" name="commentaddbtn"
                                    style="margin-left:330px;width:210px;height:20px;padding:2px;height:30px;">Insert
                                    Comment</button>
                            </div>

                        </form>

                    </div>

                    <hr style="margin-top:15px;">

                    <?php
                    $pros = $student['pros_id'];
                    $selectcomments = "SELECT * FROM followup WHERE pros_id = '$pros'";
                    $selectcommentruns = mysqli_query($con, $selectcomments);
                    if (mysqli_num_rows($selectcommentruns) > 0) {
                        while ($rows = mysqli_fetch_assoc($selectcommentruns)) {
                            ?>
                            <div class="comment-card">
                                <div class="comment-meta">
                                    <span class="date" style="font-size:15px;">
                                        <?php echo "Date : " . $rows['dof']; ?>
                                    </span>
                                    <span class="follow-mode" style="font-size:15px;margin-left:12px;">
                                        <?php echo "Mode : " . $rows['followmode']; ?>
                                    </span>
                                    <span class="follow-by" style="font-size:15px;margin-left:12px;">
                                        <?php echo "By : " . $rows['followby']; ?>
                                    </span>
                                </div>
                                <div class="comment-content">
                                    <p style="margin-top:10px;">
                                        <?php echo $rows['comment']; ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No comments found for this student.";
                    }

                    ?>

                </div>


                </div>
                <script>
                    // Function to redirect to student-view.php with the selected student ID
                    function redirectToStudentView(studentID) {
                        if (studentID) {
                            window.location.href = 'prospectview.php?pros_id=' + studentID;
                        }
                    }
                </script>

                <script>

                    // Function to enable or disable the payamt input field
                    function togglePayAmtInput() {
                        const payAmtInput = document.getElementById('payamt');
                        const paymodeInput = document.getElementById('paymode');
                        const paydateInput = document.getElementById('paydate');
                        const feestitleInput = document.getElementById('feestitle');
                        const acdyearInput = document.getElementById('acdyear');
                        const refreshButton = document.getElementById('refreshButton');
                        const dueAmount = <?php echo $due; ?>; // Get the due amount from PHP

                        // If dueAmount is 0, disable the input; otherwise, enable it
                        if (dueAmount === 0) {
                            payAmtInput.disabled = true;
                            paymodeInput.disabled = true;
                            paydateInput.disabled = true;
                            feestitleInput.disabled = true;
                            acdyear.disabled = true;
                            refreshButton.disabled = true;
                        } else {
                            payAmtInput.disabled = false;
                        }
                    }

                    // Call the function to initially set the input field state
                    togglePayAmtInput();

                    // Add an event listener to update the input field state if dueAmount changes
                    document.addEventListener('DOMContentLoaded', function () {
                        const refreshButton = document.getElementById('refreshButton');
                        refreshButton.addEventListener('click', togglePayAmtInput);
                    });


                    // Get a reference to the button element
                    const refreshButton = document.getElementById('refreshButton');

                    // Add a click event listener to the button
                    refreshButton.addEventListener('click', function () {
                        // Use location.reload() to refresh the page
                        location.reload();
                    });

                    // Get a reference to the date input field
                    const dateInput = document.getElementById('paydate');

                    // Add an event listener to format the date when the user changes it
                    dateInput.addEventListener('change', function () {
                        // Get the selected date from the input
                        const selectedDate = dateInput.value;

                        // Format the date as desired (e.g., YYYY-MM-DD)
                        const formattedDate = formatDate(selectedDate);

                        // Update the input field with the formatted date
                        dateInput.value = formattedDate;
                    });

                    // Function to format the date as YYYY-MM-DD
                    function formatDate(dateString) {
                        const date = new Date(dateString);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    }



                </script>

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

                <!-- Include Chosen jQuery plugin -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>


                <!-- Include Chosen CSS -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

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

    // Close the database connection
    mysqli_close($con);
} else {
    echo "Student ID not provided in the URL.";
}
?>