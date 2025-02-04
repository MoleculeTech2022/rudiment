<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search with Chosen - PHP and MySQL</title>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Chosen CSS and JavaScript -->
    <link rel="stylesheet" href="chosen/chosen.min.css">
    <script src="chosen/chosen.jquery.min.js"></script>

  
    <style>
    /* Add any custom CSS styles here */
    /* Set a minimum width for the Chosen select */
    #studentSelect_chosen {
        min-width: 200px; /* Adjust the width as needed */
    }
</style>
</head>
<body>
    <h1>Live Search with Chosen - PHP and MySQL</h1>

    <!-- Create a select element with the Chosen library -->
    <select id="studentSearch" size="5">
        <option value="">Search for a student</option>
    </select>


    <script>
         const studentSearch = document.getElementById('studentSearch');

studentSearch.addEventListener('input', () => {
    const searchValue = studentSearch.value;

    if (searchValue.length >= 2) { // Optional: Minimum characters required before searching
        fetch(`search.php?query=${searchValue}`)
            .then(response => response.json())
            .then(data => {
                studentSearch.innerHTML = '<option value="">Search for a student</option>';

                data.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.sid;
                    option.textContent = `${student.fname} ${student.mname} ${student.lname}`;
                    studentSearch.appendChild(option);
                });
            });
    } else {
        studentSearch.innerHTML = '<option value="">Search for a student</option>';
    }
});
    </script>
</body>
</html>
