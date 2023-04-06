<?php
include "LogHeader.php";
include "con.php";
include "bootstrap.php";
/** @var mysqli $conn */

session_start();

if(isset($_POST['submit'])) {
    $sql = "INSERT INTO `lijst`(`gebruiker_id`, `name`, `description`, `mode_id`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $_SESSION['gebruikerid'], $_POST['title'], $_POST['description'], $_POST['mode']);
    $result = $stmt->execute();
    $realResult = true;

    $sql2 = 'SELECT * FROM lijst';
    $stmt2 = $conn->query($sql2);
    $listId = $stmt2->num_rows;

    for ($i = 0; $i < 5; $i++) {
        $sql = "INSERT INTO `lijst_vragen`(`lijst_id`,`question`, `good_answer`) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $listId, $_POST['vraagstelling' . $i], $_POST['antwoord' . $i]);
        $result = $stmt->execute();
        $realResult = true;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="d-flex justify-content-center">
    <form method="post" action="lijst.php" class="w-50">
        <div class="mb-4">
            <label for="title" class="form-label">List name</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter list name">
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
        </div>

        <div class="mb-4">
            <label for="mode" class="form-label">List mode</label>
            <select id="mode" name="mode" class="form-select">
                <option value="1">Public</option>
                <option value="2">Private</option>
            </select>
        </div>

        <div class="mb-4" id="questions">
            <div class="question-group">
                <div class="mb-0">
                    <label for="question1" class="form-label">Question 1</label>
                    <input type="text" class="form-control" id="question1" name="vraagstelling1" placeholder="Enter your question here">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="answer1" name="antwoord1" placeholder="Enter your answer here">
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <button type="button" id="add-question-btn" class="btn btn-primary mb-0 me-3">Add question</button>

            <button type="submit" name="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>


<script>
    const addQuestionButton = document.querySelector("#add-question-btn");
    const questionsContainer = document.querySelector("#questions");

    let questionCounter = 1;

    addQuestionButton.addEventListener("click", () => {
        questionCounter++;

        const questionDiv = document.createElement("div");
        questionDiv.classList.add("form-group");

        const questionLabel = document.createElement("label");
        questionLabel.classList.add("vraagteller");
        questionLabel.innerText = `Question ${questionCounter}`;

        const questionInput = document.createElement("input");
        questionInput.type = "text";
        questionInput.classList.add("form-control");
        questionInput.name = `vraagstelling${questionCounter}`;
        questionInput.placeholder = "Enter your question here";

        const answerInput = document.createElement("input");
        answerInput.type = "text";
        answerInput.classList.add("form-control");
        answerInput.name = `antwoord${questionCounter}`;
        answerInput.placeholder = "Enter your answer here";

        questionDiv.appendChild(questionLabel);
        questionDiv.appendChild(questionInput);
        questionDiv.appendChild(answerInput);

        questionsContainer.appendChild(questionDiv);
    });
</script>
</body>
</html>