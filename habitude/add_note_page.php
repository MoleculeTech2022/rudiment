<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="style.css">
        
    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== Text Editor CDN ===== -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <title>HABITUDE Add Notes</title>

    <style>
        #editor {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 100px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        #editor:empty:before {
            content: attr(placeholder);
            color: #ccc;
        }

        .quill-container {
            border: 1px solid #ccc;
            min-height: 100px;
            padding: 5px;
            font-family: Arial, sans-serif;
            overflow-y: auto;
            margin-bottom: 15px;
        }
    </style>
</head>
<body style="background-color:#fff;">
    <?php include "navbar.html"; ?>

    <div class="add_section" style="margin-top: 80px; display: flex; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">Enter Notes Here</span>
    
        <div class="btns" style="margin-left: auto; display: flex; gap: 10px;margin-right: 65px;">
            <!-- Placeholder for buttons if needed -->
        </div>
    </div>

    <div class="add_notes_form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <select name="subject" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
                <option value="None">Subject</option>
                <option value="Current Affairs">Current Affairs</option>
                <option value="History-Ancient">History-Ancient</option>
                <option value="History-Medieval">History-Medieval</option>
                <option value="History-Modern">History-Modern</option>
                <option value="Polity">Polity</option>
                <option value="Geography">Geography</option>
                <option value="Economy">Economy</option>
                <option value="Science and Tech">Science and Tech</option>
                <option value="Environment">Environment</option>
                <option value="Mapping">Mapping</option>
                <option value="Intr. Relation">Intr. Relation</option>
                <option value="Ethics">Ethics</option>
                <option value="Strategy">Strategy</option>
                <option value="Hindi">Hindi</option>
                <option value="Marathi">Marathi</option>
                <option value="English">English</option>
                <option value="CSAT">CSAT</option>
                <option value="Bihar Special">Bihar Special</option>
                <option value="UP Special">UP Special</option>
                <option value="Maharashtra Special">Maharashtra Special</option>
                <option value="Rajasthan Special">Rajasthan Special</option>
                <option value="Uttarakhand Special">Uttarakhand Special</option>
                <option value="Haryana Special">Haryana Special</option>
                <option value="Jharkhand Special">Jharkhand Special</option>
                <option value="Madhya Pradesh Special">Madhya Pradesh Special</option>
                <option value="Chhattisgarh Special">Chhattisgarh Special</option>
                <option value="History Optional">History Optional</option>
                <option value="Polity Optional">Polity Optional</option>
                <option value="Geography Optional">Geography Optional</option>
                <option value="Others">Others</option>
            </select>

            <input type="date" name="date" value="<?= date('Y-m-d'); ?>" style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
            <input type="text" name="chapter" placeholder="Chapter" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
            <input type="text" name="subtopic" placeholder="Subtopic" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">

            <!-- Text Editor -->
            <div class="quill-container" style="height:500px;">
                <div id="note-editor"></div>
                <input type="hidden" id="note_editor" name="note" required>
            </div>

            <button type="submit" name="add_notes_btn" style="width: 300px; height: 45px; background-color: #ffef7a; border: none; border-radius: 2px; color: #000;margin-left: 15px;cursor:pointer;">Add Note</button>
        </form>
    </div>

    <!-- Include Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Initialize Quill for Notes -->
    <script>
    var noteEditor = new Quill('#note-editor', {
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
            ],
        },
        placeholder: 'Write Your Notes here ',
        theme: 'snow'
    });

    // Add an event listener to update hidden input when content changes
    noteEditor.on('text-change', function() {
        document.getElementById('note_editor').value = noteEditor.root.innerHTML;
    });
    </script>
</body>
</html>

<?php
// Database connection
include "dbcon.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $chapter = $_POST['chapter'];
    $subtopic = $_POST['subtopic'];
    $note = $_POST['note'];

    // Function to extract formatted text from HTML
    function extractFormattedText($html) {
        // Load HTML into a DOMDocument
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        // Initialize an empty string to store the formatted text
        $formattedText = "";

        // Loop through each <p> element in the HTML
        foreach ($dom->getElementsByTagName('p') as $p) {
            // Initialize an empty string to store formatted text within this <p> element
            $formattedTextInsideP = "";
            // Loop through each child node of the <p> element
            foreach ($p->childNodes as $node) {
                // Check node type
                if ($node->nodeName == 'strong') {
                    $formattedTextInsideP .= "<b>" . $node->nodeValue . "</b>";
                } elseif ($node->nodeName == 'em') {
                    $formattedTextInsideP .= "<i>" . $node->nodeValue . "</i>";
                } elseif ($node->nodeName == 'u') {
                    $formattedTextInsideP .= "<u>" . $node->nodeValue . "</u>";
                } else {
                    $formattedTextInsideP .= $node->nodeValue;
                }
            }
            $formattedTextInsideP .= "<br/>";
            $formattedText .= $formattedTextInsideP;
        }

        return $formattedText;
    }

    $formattedNote = extractFormattedText($note);

    // Insert data into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO i_upsc_notes (subject, date, chapter, subtopic, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $subject, $date, $chapter, $subtopic, $formattedNote);

    if ($stmt->execute()) {
        // Get the last inserted note_id
        $last_id = $stmt->insert_id;
        if ($last_id) {
            echo "<script>window.location.href='note_view.php?note_id=$last_id';</script>";
            exit();
        } else {
            echo "Error retrieving note ID.";
        }
    } else {
        echo "Error inserting note: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
