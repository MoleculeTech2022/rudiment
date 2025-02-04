<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
</head>
<body>
<Form action="quiz_code.php" method="POST">

    <select name="subject" placeholder="Subject">
    <option value="Select Subject">Select Subject</option>
        
        <option value="History">History</option>
        <option value="Polity">Polity</option>
        <option value="Geography">Geography</option>
        <option value="Economics">Economics</option>
        <option value="Current Affairs">Current Affairs</option>
        <option value="Intr. Relations">Intr. Relations</option>
        <option value="Physics">Physics</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Biology">Biology</option>
        <option value="Enviroment">Enviroment</option>
        <option value="Bihar Special">Bihar Special</option>
        <option value="Mapping">Mapping</option>
        <option value="Disaster Management">Disaster Management</option>
        <option value="Hindi">Hindi</option>
        <option value="English">English</option>
</select>
<br>
 <input type="text" name="chapter" placeholder="Chapter" style="margin-top: 20px;">
    <br>

    <input type="text" name="subtopic" placeholder="Topic" style="margin-top: 20px;">
    <br>
    
<input type="date" name="date" required placeholder="Option one" style="margin-top: 20px;" value="<?php echo date('Y-m-d'); ?>">
    <br>
<textarea name="note" required placeholder="Note" style="margin-top: 20px; width: 850px; height: 250px;"></textarea>
<br>
<Button name="add_note_btn">Add Notes</Button>
</Form> 

<?php
include 'dbcon.php';

// Fetch data from the database
$sql = "SELECT note_id, subject, note, subtopic, date FROM h_ipsc_notes ORDER BY note_id DESC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<table border='1'>";
     echo "<tr><th>Note ID</th><th>Subject</th><th>Note</th><th>Subtopic</th><th>Date</th><th>Edit</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["note_id"]."</td><td>".$row["subject"]."</td><td>".$row["note"]."</td><td>".$row["subtopic"]."</td><td>".$row["date"]."</td><td><a href='edit_note.php?id=".$row["note_id"]."'>Edit</a></td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$con->close();
?>

</body>
</html>