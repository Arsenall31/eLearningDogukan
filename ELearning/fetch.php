<?php
include "connection.php";
/** @var mysqli $conn */

$data = json_decode(file_get_contents('php://input'), true);


$vraagId = $data['vraagid'];
$answer = $data['antwoord'];

$sql = "SELECT * FROM `lijst_vragen` WHERE lijst_vragen.good_answer= ? AND lijst_vragen.id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $answer , $vraagId);
$stmt->execute();
$result = $stmt->get_result();

$response = array();

if ($result->num_rows > 0) {
    $response['has_rows'] = true;
}
else {
    $response['has_rows'] = false;
}


echo json_encode($response);
