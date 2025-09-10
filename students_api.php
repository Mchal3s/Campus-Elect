<?php
require "db.php";
header("Content-Type: application/json");

$result = $conn->query("SELECT user_id, full_name, student_id, photo FROM users WHERE role='student'");
$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = [
        "id" => $row['student_id'],
        "name" => $row['full_name'],
        "photo" => base64_encode($row['photo'])
    ];
}
echo json_encode($students);
?>
