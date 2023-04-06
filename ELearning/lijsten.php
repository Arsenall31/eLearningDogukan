<?php
include "LogHeader.php";
include "con.php";
/** @var mysqli $conn */

session_start();


$sql = "SELECT * FROM lijst WHERE mode_id = 1 OR gebruiker_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['gebruikerid']);
$stmt->execute();
$result = $stmt->get_result();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<div class="container mx-auto">
    <?php if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $lijst = "
        <div class='container'>
            <div class='row g-3 justify-content-center'>
                <div class='col-lg-6'>
                    <div class='modal modal-sheet position-static d-block p-2 py-md-3' tabindex='-1' role='dialog' id='modalSheet'>
                        <div class='modal-dialog mx-auto' role='document'>
                            <div class='modal-content rounded-4 shadow'>
                                <div class='modal-header border-bottom-0'>
                                    <h1 class='modal-title fs-5'>" . $row["name"] . "</h1>
                                </div>
                                <div class='modal-body py-0'>
                                    <p>" . $row["description"] . "</p>
                                </div>
                                <div class='modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0'>
                                    <a href='speellijst.php?id=" . $row['id'] . "' type='button' class='btn btn-lg btn-primary'>Play</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>";
            echo($lijst);
        }
    }
    ?>


</div>


</div>
</body>
</html>
