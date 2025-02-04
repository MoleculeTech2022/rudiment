document.getElementById('startTestBtn').addEventListener('click', function() {
    document.getElementById('instructions').style.display = 'none';
    document.getElementById('testPage').style.display = 'block';
    startTimer();
    fetchQuestions();
});

function startTimer() {
    let time = 600; // 10 minutes in seconds
    const timerElement = document.getElementById('time');

    const interval = setInterval(function() {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
            seconds = '0' + seconds;
        }

        timerElement.textContent = `${minutes}:${seconds}`;
        time--;

        if (time < 0) {
            clearInterval(interval);
            alert("Time's up!");
            document.getElementById('quizForm').submit(); // Automatically submit when time is up
        }
    }, 1000);
}

function fetchQuestions() {
    fetch('test.php')
        .then(response => response.json())
        .then(data => {
            const questionsContainer = document.getElementById('questionsContainer');
            data.forEach((question, index) => {
                const questionElement = document.createElement('div');
                questionElement.classList.add('question');
                questionElement.innerHTML = `
                    <p><strong>Q${index + 1}:</strong> ${question.question}</p>
                    // <p><strong>Category:</strong> ${question.question_category}</p>
                    // <p><strong>Subject:</strong> ${question.question_subject}</p>
                    // <p><strong>Level:</strong> ${question.question_level}</p>
                    // <p><strong>Chapter:</strong> ${question.question_chapter}</p>
                    // <p><strong>Topic:</strong> ${question.question_topic}</p>
                    // <p><strong>Notes:</strong> ${question.question_notes}</p>
                    // <img src="${question.question_image}" alt="Question Image" style="max-width: 100%; height: auto;"/><br><br>
                    
                    <input type="radio" name="question_${question.question_id}" value="A"> ${question.option_a}<br>
                    <input type="radio" name="question_${question.question_id}" value="B"> ${question.option_b}<br>
                    <input type="radio" name="question_${question.question_id}" value="C"> ${question.option_c}<br>
                    <input type="radio" name="question_${question.question_id}" value="D"> ${question.option_d}<br>
                    <input type="hidden" name="correct_answer_${question.question_id}" value="${question.correct_option}">
                    <input type="hidden" name="explanation_${question.question_id}" value="${question.explanation}">
                `;
                questionsContainer.appendChild(questionElement);
            });
        });
}
