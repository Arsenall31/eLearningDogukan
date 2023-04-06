<?php
include "header.php";
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
</body>
<form action="signup.php" method="post">
    <div class="col-md-8 col-lg-6 col-xl-5 offset-xl-1 my-lg-5 py-lg-5">
        <h1>Create your account here!</h1>
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
            <button type="submit" name="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Create account</button>
        </div>
</form>

<?php
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg')</script>";
}
$connection = mysqli_connect("localhost", "root", "", "e-learning");

if (isset($_POST["submit"])) {
    $wachtwoord = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql2 = "SELECT * FROM gebruiker WHERE username = ?";
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("s", $_POST['username']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($row = $result2->fetch_array() == true) {
        echo "<script>alert('naam bestaat al');</script>";
    } else {
        $sql = "INSERT INTO gebruiker(username, password) VALUES (?,?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $_POST['username'], $wachtwoord);
        $result = $stmt->execute();
        $realResult = true;
        alert('Account aangemaakt');
        header("Refresh:0.1; url=login.php", true, 303);
    }
}
?>
</body>
</html>
