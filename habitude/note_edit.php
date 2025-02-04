<?php
// Include db connection file
include 'dbcon.php';

// Check if note_id is set in the URL
if (isset($_GET['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($conn, $_GET['note_id']);

    // Query to fetch details from the database based on note_id
    $sql = "SELECT * FROM i_upsc_notes WHERE note_id = '$note_id'";
    $result = $conn->query($sql);

    // Check if result is not empty
    if ($result->num_rows > 0) {
        // Fetch data
        $row = $result->fetch_assoc();
        $subject = $row['subject'];
        $date = $row['date'];
        $chapter = $row['chapter'];
        $subtopic = $row['subtopic'];
        $note = $row['note'];
    } else {
        // If no matching record found, display error message or redirect
        // For example:
        // header("Location: notes.php");
        // exit();
        echo "No record found";
    }
} else {
    // If note_id is not set in the URL, display error message or redirect
    // For example:
    // header("Location: notes.php");
    // exit();
    echo "Note ID is missing";
}

// Close database connection
$conn->close();
?>


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


    <title>HABITUDE Edit Notes</title>

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
    <?php
    include "navbar.html";
    ?>

    <div class="add_section" style="margin-top: 80px; display: flex; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">Edit Notes Here</span>

        <div class="btns" style="margin-left: auto; display: flex; gap: 10px;margin-right: 65px;">
            <!-- <button onclick="addNotePage()" style="width: 150px; height: 45px; background-color: #ffa0fc; border: none; border-radius: 2px; color: #fff;">Add Notes</button> -->
            <!-- <button onclick="backPage()" style="width: 150px; height: 45px; background-color: #75ffbe; border: none; border-radius: 2px; color: #fff;">Back</button> -->
        </div>
    </div>

    <div class="edit_notes_form">

        <form action="edit_code.php" method="POST">

            <!-- // For note_id -->
            <input type="hidden" name="note_id" value="<?php echo $note_id; ?>"> <!-- Hidden input field for note_id -->

            <!-- Subject select -->
            <select name="subject" required
                style="height: 35px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
                <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
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
                <option value="Polity" <?php if ($subject == 'Polity')
                    echo 'selected'; ?>>Polity</option>
            </select>
            <!-- Date input -->
            <input type="date" placeholder="Date" name="date" value="<?php echo $date; ?>"
                style="height: 35px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
            <!-- Chapter input -->
            <input type="text" placeholder="Chapter" name="chapter" required
                style="height: 35px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;"
                value="<?php echo $chapter; ?>">
            <!-- Subtopic input -->
            <input type="text" placeholder="Subtopic" name="subtopic" required
                style="height: 35px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;"
                value="<?php echo $subtopic; ?>">


            <!-- Text Editor -->
            <div class="quill-container" style="height:500px;">

                <div id="note-editor"><?= $note; ?></div>
                <!-- <input type="hidden" placeholder="Note" id="note_editor"  name="note" required style="display:none;height: 275px; width: 82%; border: 1px solid #ccc; border-radius: 6px; margin-left: 15px; margin-top: 10px; margin-bottom: 15px; font-size: 1rem; padding: 10 14px; text-align: left;"> -->


                <input type="text" placeholder="Note" id="note_update" name="note" required
                    style="height: 275px; width: 82%; border: 1px solid #ccc; border-radius: 6px; margin-left: 15px; margin-top: 10px; margin-bottom: 15px; font-size: 1rem; padding: 10px 14px; text-align: left;">

            </div>


            <!-- Submit button -->
            <button type="submit" name="edit_notes_btn"
                style="width:300px; height: 45px; background-color: #ffef7a; border: none; border-radius: 2px; color: #000;margin-left: 15px;cursor:pointer;">Update
                Notes</button>
        </form>

    </div>

    <!-- Include Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Initialize Quill for Notes -->
    <!-- Include DOMPurify library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.3/purify.min.js"></script>

    <!-- Initialize Quill for Notes -->
    <script>
        var noteEditor = new Quill('#note-editor', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block'],
                    [{ 'color': [] }], // Font color dropdown
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    ['blockquote'],

                ],

            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
        });



        // Add an event listener to update hidden input when content changes
        noteEditor.on('text-change', function () {
            // coding yaha chal raha hai 
            var sanitizedHtml = noteEditor.root.innerHTML;
            document.getElementById('note_update').value = sanitizedHtml;
        });
    </script>


    <script>

        function addLink() {
            const url = prompt('Insert url');
            formatDoc('createLink', url);
        }

        const content = document.getElementById('content');

        content.addEventListener('mouseenter', function () {
            const a = content.querySelectorAll('a');
            a.forEach(item => {
                item.addEventListener('mouseenter', function () {
                    content.setAttribute('contenteditable', false);
                    item.target = '_blank';
                })
                item.addEventListener('mouseleave', function () {
                    content.setAttribute('contenteditable', true);
                })
            })
        })


        const showCode = document.getElementById('show-code');
        let active = false;

        showCode.addEventListener('click', function () {
            showCode.dataset.active = !active;
            active = !active
            if (active) {
                content.textContent = content.innerHTML;
                content.setAttribute('contenteditable', false);
            } else {
                content.innerHTML = content.textContent;
                content.setAttribute('contenteditable', true);
            }
        })



        const filename = document.getElementById('filename');

        function fileHandle(value) {
            if (value === 'new') {
                content.innerHTML = '';
                filename.value = 'untitled';
            } else if (value === 'txt') {
                const blob = new Blob([content.innerText])
                const url = URL.createObjectURL(blob)
                const link = document.createElement('a');
                link.href = url;
                link.download = `${filename.value}.txt`;
                link.click();
            } else if (value === 'pdf') {
                html2pdf(content).save(filename.value);
            }
        }
    </script>

    <script>

        function backPage() {
            // Redirect to notes.php
            window.location.href = "notes.php";
        }

        function toGoBackNotesPage() {
            // Redirect to notes.php
            window.location.href = "notes.php";
        }

    </script>

</body>

</html>