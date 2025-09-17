<?php
session_start();
require "db.php";

// Only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['end_time'])) {
    $end_time = $_POST['end_time'];

    // Insert or update timer (keep only 1 active row)
    $conn->query("DELETE FROM election_timer");
    $stmt = $conn->prepare("INSERT INTO election_timer (end_time) VALUES (?)");
    $stmt->bind_param("s", $end_time);
    $stmt->execute();
}

header("Location: admin.php");
exit();
?>
