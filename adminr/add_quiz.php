<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz Form</title>
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
    <input type="text" name="subtopic" placeholder="Topic" style="margin-top: 20px;">
    <input type="text" name="question" required placeholder="Question" style="margin-top: 20px;">
    <input type="text" name="option_one" required placeholder="Option one" style="margin-top: 20px;">
    <input type="text" name="option_two" required placeholder="Option two" style="margin-top: 20px;">
    <input type="text" name="option_three" required placeholder="Option three" style="margin-top: 20px;">
    <input type="text" name="option_four" required placeholder="Option four" style="margin-top: 20px;">
    <input type="text" name="answer" required placeholder="Answer" style="margin-top: 20px;">
    <input type="text" name="explanation" placeholder="Explanation" style="margin-top: 20px;">
    <input type="text" name="chapter" name="chapter" placeholder="Chapter" style="margin-top: 20px;">
    <select name="level" placeholder="Level" style="margin-top: 20px;">
        <option value="Select Level">Select Level</option>
        <option value="Easy">Easy</option>
        <option value="Hard">Hard</option>
        <option value="Medium">Medium</option>
        <option value="Extreme">Extreme</option>
</select>

<Button name="insert_btn">Add Question</Button>
</Form>  
</body>
</html>