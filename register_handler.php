<?php
require "db.php";

$name      = trim($_POST['full_name'] ?? "");
$email     = trim($_POST['email'] ?? "");
$role      = $_POST['role'] ?? "";
$password  = $_POST['password'] ?? null;
$studentId = trim($_POST['student_id'] ?? null);

if (!$name || !$role) {
    header("Location: register.php?error=Missing required fields");
    exit();
}

if ($role === "student") {
    if (!$studentId || empty($_FILES['photo']['tmp_name'])) {
        header("Location: register.php?error=Student must provide ID and photo");
        exit();
    }

    // ✅ Check if student ID already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE student_id=? LIMIT 1");
    $check->bind_param("s", $studentId);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: register.php?error=Student ID already registered");
        exit();
    }

    $photoData = file_get_contents($_FILES['photo']['tmp_name']);

    // ✅ Allow student email if provided, else NULL
    if (!empty($email)) {
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, role, student_id, photo, email) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $name, $role, $studentId, $photoData, $email);
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, role, student_id, photo, email) VALUES (?, ?, ?, ?, NULL)"
        );
        $stmt->bind_param("ssss", $name, $role, $studentId, $photoData);
    }

} elseif ($role === "admin" || $role === "proctor") {
    if (!$email || !$password) {
        header("Location: register.php?error=Email and password required for admin/proctor");
        exit();
    }

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE email=? LIMIT 1");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: register.php?error=Email already registered");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
}

if (isset($stmt) && $stmt->execute()) {
    if ($role === "student") {
        header("Location: success.php");
    } else {
        header("Location: login.php?registered=1");
    }
    exit();
} else {
    header("Location: register.php?error=Registration failed");
    exit();
}
