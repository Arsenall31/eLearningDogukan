<?php
include "header.php";
include "con.php";
/** @var mysqli $conn */

session_start();


if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT * FROM gebruiker WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result);

    try {
        while ($row = $result->fetch_array()) {
            //result is in row
            $passwordreturn = password_verify($password, $row['password']);

            if ($passwordreturn) {
                $_SESSION['gebruiker'] = $name;
                $_SESSION['gebruikerid'] = $row['id'];
                echo '<script>alert("Logged in!")</script>';
                header('location:dashboard.php');
            } else {
                echo '<script>alert("Verkeerde login gegevens")</script>';
            }
        }
    } catch (Exception $e) {
        $e->getMessage();
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
</head>
<body>
<div class="col-md-8 col-lg-6 col-xl-5 offset-xl-1 my-lg-5 py-lg-5">
    <h1>Login here!</h1>
    <form method="POST">
        <!-- Username input -->
        <div class="form-outline mb-4">
            <input type="name" name="username" id="form3Example3" class="form-control form-control-lg" placeholder="Enter username">
            <label class="form-label" for="form3Example3" style="margin-left: 0px;">Username</label>
            <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>

        <!-- Password input -->
        <div class="form-outline mb-3">
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password">
            <label class="form-label" for="form3Example4" style="margin-left: 0px;">Password</label>
            <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 64.8px;"></div><div class="form-notch-trailing"></div></div></div>

        <div class="d-flex justify-content-between align-items-center">

        <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" name="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
        </div>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>