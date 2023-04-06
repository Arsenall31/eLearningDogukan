<?php
include "LogHeader.php";
include "con.php";
/** @var mysqli $conn */

session_start();
$lijst_id = $_GET['id'];


$sql = "SELECT * FROM `lijst_vragen` WHERE lijst_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$lijst_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf  -8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div>
    <div class="d-flex justify-content-center">
        <div class="container mx-auto form-container" style="width: 60%;">

            <?php
            echo "<div class='text-center mt-4'>
                     <h4 class='mb-3'>Score:</h4>
                     <h2 id='score'>0</h2>
                     </div>";
            if ($result->num_rows > 0) {
                $totaalvragen = $result->num_rows;
                while ($row = $result->fetch_assoc()) {
                    $lijstvragen =
                        "<div class='mb-4'>
                    <div id='list1' class='form-group'>
                    <h1 class='form-control'>" . $row["question"] ."</h1>
                   <input type='text' id='antwoord". $row["id"] ."' name='antwoord1' class='form-control' placeholder='Enter your answer here'>
                </div>
                <div class='d-flex align-items-center'>
                  <button onclick='fetchmyshit(". $row["id"] .")' type='submit' name='submit' class='btn btn-primary me-3'>Check</button>
                  <div id='result". $row["id"] ."'></div>
                </div>
              </div>";
                    echo($lijstvragen);
                }
                ;
            }
            ?>
        </div>
    </div>
</div>

<script>
    let correctAnswers = 0;
    let wrongAnswers = 0;

    function fetchmyshit(id) {
        const value = document.getElementById("antwoord"+ id).value;

        const data = {
            antwoord: value,
            vraagid: id,
        };

        fetch("fetch.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.has_rows) {
                    console.log("Goed antwoord");
                    correctAnswers++;
                    document.getElementById("result" + id).innerHTML = "<span style='color: green;'>Correct!</span>";
                } else {
                    console.log("Fout antwoord");
                    wrongAnswers++;
                    document.getElementById("result" + id).innerHTML = "<span style='color: red;'>Wrong!</span>";
                }
                console.log("Correct Answers: " + correctAnswers);
                console.log("Wrong Answers: " + wrongAnswers);

                const scoreElement = document.getElementById("score");
                const totaalvragen1 = <?php echo $totaalvragen; ?>;
                const scoreMessage = "Your Score: " + correctAnswers + "/" + totaalvragen1;
                scoreElement.innerHTML = scoreMessage;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>