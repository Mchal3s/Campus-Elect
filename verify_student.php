<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = $_POST['student_id'] ?? null;

    if ($studentId) {
        $stmt = $conn->prepare("UPDATE users SET verified=1 WHERE student_id=?");
        $stmt->bind_param("s", $studentId);
        if ($stmt->execute()) {
            echo "Student verified";
        } else {
            echo "Error updating student";
        }
    } else {
        echo "No student ID provided";
    }
}
?>
