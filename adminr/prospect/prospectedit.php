<?php
require '../dbcon.php';

// Check if 'sid' is set in the URL
if (isset($_GET['pros_id'])) {
    // Sanitize the input
    $pros_id = mysqli_real_escape_string($con, $_GET['pros_id']);

    // Construct your SQL query
    $query = "SELECT * FROM prospect
              WHERE prospect.pros_id = '$pros_id'";

    // Execute the query
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Check if there are any matching records
        if (mysqli_num_rows($query_run) > 0) {
            $student = mysqli_fetch_assoc($query_run);
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>RUDIMENT - Prospect Edit</title>
                <!-- CSS -->
                <link rel="stylesheet" href="css/style.css">
                <!-- Boxicons CSS -->
                <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
                <style>
                    .enroll-btn:hover {
                        background-color: #dddd;
                    }
                </style>

            </head>

            <body>
                <?php
                include "sidebar.html";
                ?>

<div class="dashboard-contents"
        style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: -30px;border-bottom:-60px;">
        <h3 style="text-align:center;margin-left:340px;">Prospect Form</h3>
        <div class="student-admission-form"
            style="border:2px solid #40e0d0;width:900px;margin-left:30px;border-radius:5px;">
            <!-- // Student Details Edit FORM  -->
            <form action="prospectdbcode.php" method="POST">

                <div class="student-details">
                    <div class="title"
                        style="margin-top:20px;width:97%;height:25px;background-color:#40e0d0;padding:10px;margin-left:30px;">
                        <div class="title-2" style="margin-top:-10px;">
                            <span style="margin-left:30px;margin-top:-30px;color:#fff;">Student Details</span>
                        </div>
                    </div>

                    <input type="text" value="<?php echo $student['sname']; ?>" name="sname" required placeholder="Student Name *"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <input type="text" value="<?php echo $student['age']; ?>" name="age" placeholder="Student Age *"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    <div class="third-input" style="margin-left:520px;margin-top:-51px;">

                        <input type="number" name="mcontact" value="<?php echo $student['mcontact']; ?>" required placeholder="Mother Contact *" title="Mother Contact"
                            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    </div>

                    <input type="number" name="fcontact" value="<?php echo $student['fcontact']; ?>" title="Father Contact" placeholder="Father Contact *"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <div class="third-input" style="margin-left:275px;margin-top:-51px;">
                        <select type="gender" name="gender" placeholder="Student Register No"
                            style="margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <option value="<?php echo $student['gender']; ?>"><?php echo $student['gender']; ?></option>
                            <option value="Not Selected">Select Student Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                        <select name="state" required
                            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <option value="<?php echo $student['state']; ?>"><?php echo $student['state']; ?></option>
                            <option value="Select State">Select State</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="MP">MP</option>
                        <option value="Telangana">Telangana</option>
                        <option value="UP">UP</option>
                        <option value="Other">Other</option>
                        </select>
                        </div>

                    <select name="enrollclass" placeholder="Select Enroll Class"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        </option>
                        <option value="<?php echo $student['enrollclass']; ?>"><?php echo $student['enrollclass']; ?></option>
                        <option value="Select Enroll Class">Select Enroll Class</option>
                        <option value="NUR">Nursery</option>
                        <option value="LKG">LKG</option>
                        <option value="UKG">UKG</option>
                        <!-- <option value="class 1">Class 1</option>
        <option value="class 2">Class 2</option>
        <option value="class 3">Class 3</option>
        <option value="class 4">Class 4</option> -->
                    </select>

                    <select name="region"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option value="<?php echo $student['region']; ?>"><?php echo $student['region']; ?></option>
                        <option value="Select Region">Select Region</option>
                        <option value="Bodkewadi">Bodkewadi</option>
                        <option value="Boherwadi">Boherwadi</option>
                        <option value="Chande Phata">Chande Phata</option>
                        <option value="Gawarewadi">Gawarewadi</option>
                        <option value="Joshi Wadewala">Joshi Wadewala</option>
                        <option value="Joyville Side">Joyville Side</option>
                        <option value="Maan Gaon">Maan Gaon</option>
                        <option value="Mulani Basti">Mulani Basti</option>
                        <option value="Ozarkarwadi">Ozarkarwadi</option>
                        <option value="Pandav Nagar">Pandav Nagar</option>
                        <option value="Power House">Power House</option>
                        <option value="Others">Others</option>
                    </select>

                    <input type="text" value="<?php echo $student['ref']; ?>" name="ref" pla ceholder="Refrrence *" required
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


                </div>

                <div class="title"
                    style="margin-top:20px;width:97%;height:25px;background-color:#40e0d0;padding:10px;margin-left:30px;">
                    <div class="title-2" style="margin-top:-10px;">
                        <span style="margin-left:30px;margin-top:-30px;color:#fff;">Parents Details</span>
                    </div>
                </div>

                <div class="parents-details">
                    <input type="text" value="<?php echo $student['faname']; ?>" name="faname" required placeholder="Father Name"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <input type="text" value="<?php echo $student['foccup']; ?>" name="foccup" placeholder="Father Occupation"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                    <input type="text" value="<?php echo $student['fsalary']; ?>" name="fsalary" placeholder="Father Salary" id="fsalary"
                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                   </div>

                    <input type="text" value="<?php echo $student['moname']; ?>" name="moname" required placeholder="Mother Name"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <input type="text" value="<?php echo $student['moccup']; ?>" name="moccup" placeholder="Mother Occuption"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                    <input type="text" value="<?php echo $student['msalary']; ?>" name="msalary" placeholder="Mother Salary" id="msalary"
                        style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                
                        </div>

                        <select name="house" id="house" placeholder="House Type"
                        style="margin-left:30px;margin-top:-20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option value="<?php echo $student['house']; ?>"><?php echo $student['house']; ?></option>
                        <option value="Select House Type">Select House Type</option>
                        <option value="Rented">Rented</option>
                        <option value="Owned">Owned</option>
                    </select>

                    <select name="local" required placeholder="Select Lcal"
                        style="margin-left:20px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option value="<?php echo $student['local']; ?>"><?php echo $student['local']; ?></option>
                        <option value="Select Local">Select Local</option>
                        <option value="Local">Local</option>
                        <option value="Non Local">Non Local</option>
                    </select>

                    <input type="text" value="<?php echo $student['identifier']; ?>" name="identifier" id="identifier" placeholder="Identifier"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;height:30px;">
                    
                   </div>

                <div class="title"
                    style="margin-top:20px;width:97%;height:25px;background-color:#40e0d0;padding:10px;margin-left:30px;">
                    <div class="title-2" style="margin-top:-10px;">
                        <span style="margin-left:30px;margin-top:-30px;color:#fff;">Other Details</span>
                    </div>
                </div>

                <div class="update-student-details-div"
                    style="margin-left:30px;margin-top:15px;margin-bottom:20px;height:300px;">

                    <select name="admchance" id="admchance" placeholder="House Type"
                        style="margin-left:0px;margin-top:-20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option value="<?php echo $student['admchance']; ?>"><?php echo $student['admchance']; ?></option>
                        <option value="Select House Type">Admission Chance</option>
                        <option value="Pakka karenge">Pakka karenge</option>
                        <option value="Pappa se puch ke batayenge">Pappa se puch ke batayenge</option>
                        <option value="Fees jyada lag raha hai">Fees jyada lag raha hai</option>
                        <option value="School dur hai">School dur hai</option>
                        <option value="Bas tuition lagana hai">Bas tuition lagana hai</option>
                        <option value="Others">Others</option>
                    </select>

                    <input type="date" value="<?php echo $student['dov']; ?>" name="dov" title="Date Of Visit *" required
                        style="margin-left:15px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  
                    <select name="status" required placeholder="Select Lcal"
                        style="margin-left:20px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option value="<?php echo $student['status']; ?>"><?php echo $student['status']; ?></option>
                        <option value="New Prospect">New Prospect</option>
                        <option value="Follow up">Follow up</option>
                        <option value="Ready To Meet">Ready To Meet</option>
                        <option value="Not Picking">Not Picking</option>
                        <option value="Meting Done">Meting Done</option>
                        <option value="Enrolled">Enrolled</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Call After a Month">Call After a Month</option>
                    </select>
                    <br>

                    <input type="text" value="<?php echo $student['remarks']; ?>" name="remarks" placeholder="Remarks"
                        style="margin-left:0px;margin-top:20px;padding:5px;width:680px;border-radius:5px;border-width:1px;height:60px;">
<br>
                    <button class="update-student-details" name="submit" value="submit"
                        style="width:280px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;margin-top:30px;">Enroll
                        Student</button>

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