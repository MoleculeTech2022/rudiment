document.getElementById('startTestBtn').addEventListener('click', function () {
    // Get the selected subject from the dropdown
    const subjectSelect = document.getElementById('subjectSelect');
    const selectedSubject = subjectSelect.value.trim();

    // Check if a subject is selected
    alert('Hello');
    alert(selectedSubject);
    if (!selectedSubject) {
        alert('Please select a subject before starting the test.');
        return;
    }

    // Fetch questions for the selected subject
    fetch(`test.php?subject=${encodeURIComponent(selectedSubject)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            if (!Array.isArray(data)) {
                alert("Unexpected data format received.");
                console.error("Data is not an array:", data);
                return;
            }

            // Populate questions in the DOM
            const questionsContainer = document.getElementById('questionsContainer');
            questionsContainer.innerHTML = ''; // Clear any previous content

            data.forEach((question, index) => {
                const questionElement = document.createElement('div');
                questionElement.classList.add('question');
                questionElement.innerHTML = `
                    <p><strong>Q${index + 1}:</strong> ${question.question}</p>
                    <label><input type="radio" name="question_${question.question_id}" value="A"> ${question.option_a}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="B"> ${question.option_b}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="C"> ${question.option_c}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="D"> ${question.option_d}</label><br>
                `;
                questionsContainer.appendChild(questionElement);
            });

            // Show the test page and hide instructions
            document.getElementById('instructions').style.display = 'none';
            document.getElementById('testPage').style.display = 'block';
        })
        .catch(error => {
            console.error("Error fetching questions:", error);
            alert("An error occurred while fetching questions. Please try again.");
        });
});
